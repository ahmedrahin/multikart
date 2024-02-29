<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\support\Str;
use App\Mail\contactMail;
use App\Mail\replyEmail;
use Auth;
use DataTables;
use Carbon\Carbon;
use Mail;

class MessageController extends Controller
{
    /**
     * All message
     */
    public function manage()
    {   
        if( request()->ajax() ){
            $this->sl = 0;
            $message = Message::orderBy('id', 'desc')->get();
            return Datatables::of($message)
                ->addIndexColumn()
                ->addColumn('sl',function($row){
                    return $this->sl = $this->sl+1;
                })
                ->addColumn('name',function($data){
                    return $data->first_name . " " . $data->last_name;
                })
                ->addColumn('phone',function($data){
                    
                    if( !is_null( $data->phone ) ){
                        return $data->phone;
                    }else {
                        return '<span class="no">N/A</span>';
                    }
                })
                ->addColumn('message',function($data){
                    return '<p class="msg-info">' . ucfirst(Str::limit($data->message, 45, '...')) . '</p>';
                })
                ->addColumn('time', function ($data) {
                    $messageTime = Carbon::parse($data->message_time);
                    $timeDiff = $messageTime->diffInSeconds();
                
                    if ($timeDiff < 60) {
                        return $timeDiff . ' sec ago';
                    } elseif ($timeDiff < 3600) {
                        return $messageTime->diffInMinutes() . ' min ago';
                    } elseif ($timeDiff < 86400) {
                        return $messageTime->diffInHours() . ' hr ago';
                    } elseif ($timeDiff < 31536000) {
                        return $messageTime->diffInDays() . ' days ago';
                    } else {
                        return $messageTime->diffInYears() . ' years ago';
                    }
                })
                ->addColumn('action', function($data) {
                    return  '<a class="btn btn-primary br-0" href="' . route('show-message', $data->id) . '">
                                <i class="bi bi-eye"></i>
                            </a>' .
                            '<button type="button" class="btn btn-danger br-0" data-bs-toggle="modal" data-bs-target="#message' . $data->id . '"><span class="cancell">&#10060</span></button>';
                })
                
                ->rawColumns(['sl', 'name', 'phone', 'message', 'time', 'action'])
                ->make(true);
            }
        
        $messages = Message::orderBy('id', 'desc')->get();
        return view('backend.pages.messages.manage', compact('messages'));
    }

    /**
     * Store new message.
     */
    public function store(Request $request)
    {
        // validation
        $this->validate($request, [
            'first_name'  => 'required',
            'last_name'  => 'required',
            'user_email' => 'required|email',
            'message'    => 'required',
        ]);
        
        $contactData = [
            'user_id'      => Auth::check() ? Auth::user()->id : null,
            'ip_address'   => request()->ip(),
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'user_email'   => $request->user_email,
            'phone'        => $request->phone,
            'message'      => $request->message,
            'message_time' => Carbon::now(),
        ];

        // send mail to admin
        Mail::to('ahmedrahin660@gmail.com')->send( new contactMail($contactData) );

        // notification
        session::flash('alert-type', 'success');
        session::flash('message', 'Your Message is Sent Successfully');
        // Save $message to database
        Message::insert($contactData);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = Message::find($id);
        if( !is_null($message) ){
            return view('backend.pages.messages.message-box', compact('message'));
        }
    }

    // replay message
    public function replyMessage(Request $request, string $id){
        // validation
        $this->validate($request, [
            'rep_message'  => 'required',
        ]);

        $update = Message::findOrFail($id);
        $replyData = [
            'user_email'  => $request->email,
            'rep_message' => $request->rep_message,
            'message'     => $request->message,
        ];

        // send mail to admin
        $mail = $replyData['user_email'];
        Mail::to($mail)->send( new replyEmail($replyData) );

        // notification
        session::flash('alert-type', 'success');
        session::flash('message', 'Message is Sent Successfully');
        // Save $message to database
        $update->update($replyData);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $del_message = Message::find($id);
        $del_message->delete();
        session()->flash('alert-type', 'warning');
        session()->flash('message', 'The Message is Deleted');
        return redirect()->route('manage-message');
    }
}
