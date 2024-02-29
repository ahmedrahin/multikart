<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view for customer.
     */
    public function customer_login(): View
    {
        return view('frontend.pages.auth-user.login');
    }

    /**
     * Display the login view for admin.
     */
    public function admin_login(): View
    {
        return view('backend.pages.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {   
        $request->authenticate();
        $request->session()->regenerate();
        
        session()->flash('alert-type', 'success');
        session()->flash('message', 'Logged Successfully');
        return redirect()->intended(RouteServiceProvider::CUSTOMER_HOME);
    }

    public function admin_store(LoginRequest $request): RedirectResponse
    {   
        $request->authenticate();
        $request->session()->regenerate();
        
        if( Auth::user()->role == 1  || Auth::user()->role == 3 ){
            session()->flash('alert-type', 'success');
            session()->flash('message', 'Logged Successfully');
            return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
        }else {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        session()->flash('alert-type', 'warning');
        session()->flash('message', 'You has been logged out!');
        return redirect()->back();
    }

    /**
     * Destroy an authenticated session.
     */
    public function admin_logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        session()->flash('alert-type', 'warning');
        session()->flash('message', 'You has been logged out!');
        return redirect()->route('admin.login');
    }
}
