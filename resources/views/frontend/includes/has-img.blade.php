<div class="container" id="hoyja">
    <div class="row">
        <div class="col-12">
            <div class="profile-pic">
                <a href="" class="addPopup" type="button" data-bs-toggle="modal" data-bs-target="#userId{{ Auth::user()->id }}"></a>
                <img src="{{ asset('uploads/user/'.Auth::user()->image) }}" alt="" class="img-fluid">
                {{-- remove image --}}
                <form action="{{ route('profile-image-remove', Auth::user()->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="remove_image" value="1">
                    <button type="submit" class="btnProfileRemove">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>

                <!-- Modal -->
                <div class="modal fade" id="userId{{ Auth::user()->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-window-close"></i>
                        </button>
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            Update Profile Picture
                        </h1>
                        </div>

                        <div class="profile-pic">
                            <img src="{{ asset('uploads/user/'.Auth::user()->image) }}" alt="" class="img-fluid" id="upImg">
                            {{-- remove image --}}
                            <form action="{{ route('profile-image-remove', Auth::user()->id) }}" method="POST" name="btnProfileRemove">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="remove_image" value="1">
                                <button type="submit" id="btnProfileRemove">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                            {{-- upload image --}}
                            <form action="{{ route('profile-image-update', Auth::user()->id) }}" method="POST" name="profileImageUpload" class="profileImageUpload" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input name="image" type="file" class="form-control profile-image-input image-upload" accept="">
                                {{-- image/jpeg, image/jpg, image/png --}}
                                <button type="button" name="btnAdd" class="btn btn-sm btn-solid" id="upProPic">Update Profile</button>
                            </form> 
                            <button class="removeBtn">
                                <span>&#10060;</span>
                            </button>
                        </div>       
                    
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</div>
