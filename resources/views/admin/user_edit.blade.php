@extends('admin.layouts.app')

@section('subtitle')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-note icon-gradient bg-amy-crisp">
            </i>
        </div>
        <div>USER EDIT</div>
    </div>
    <div class="page-title-actions">
        <div class="d-inline-block">
        <a href="{{route('admin.user')}}" class="btn-shadow btn btn-info">
            <span class="btn-icon-wrapper pr-2 opacity-7">
                <i class="fa fa-angle-double-left fa-w-20"></i>
            </span>
            Back
        </a>
        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card-hover-shadow profile-responsive card-border border-success mb-3 card">
            <div class="dropdown-menu-header">
                <div class="dropdown-menu-header-inner bg-success">
                    <div class="menu-header-content">
                        <div class="avatar-icon-wrapper btn-hover-shine mb-2 avatar-icon-xl">
                            <div class="avatar-icon rounded"><img src="{{asset('images/avatars/1.png')}}" alt="Avatar 6"></div>
                        </div>
                        <div><h5 class="menu-header-title">{{$user->name}}</h5><h6 class="menu-header-subtitle">{{$user->user_name}}</h6></div>                        
                    </div>
                </div>
            </div>
            <div class="p-5 card-body">
                {{-- {{dd($errors)}} --}}
                <form action="{{route('admin.user_save')}}" method="post" id="editform">
                    @csrf
                <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">User ID <span class="require-field">*</span></label>
                                <div>
                                    <input type="text" class="form-control" id="userid" name="name" placeholder="User ID" value="{{$user->name}}" required autocomplete="off"/>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert" style="display:block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                    <em id="userid-require-error" class="error invalid-feedback">Please enter your User ID</em>
                                    <em id="userid-unique-error" class="error invalid-feedback">The User ID is already stored in the database.</em>
                                </div>
                            </div>
        
                            <div class="form-group">
                                <label for="username">User Name</label>
                                <div>
                                    <input type="text" class="form-control" id="username" value="{{$user->user_name}}" name="username" placeholder="Username"/>
                                </div>
                            </div>
        
                            <div class="form-group">
                                <label for="email">User Email</label>
                                <div>
                                    <input type="text" class="form-control" id="email" name="email"  value="{{$user->email}}" placeholder="Email"/>
                                    <em id="email-type-error" class="error invalid-feedback">Please enter your correct email</em>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Balance</label>
                                <div>
                                    <input type="number" class="form-control" min="0" id="balance" name="balance"  value="{{$user->balance}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</span></label>
                                <input type="password" class="form-control" id="password" name="password" value="" placeholder="Password"/>
                                <em id="password-require-error" class="error invalid-feedback">Please enter your password</em>
                                <em id="password-length-error" class="error invalid-feedback">Your password must be at least 8 characters long</em>
                            </div>
        
                            <div class="form-group">
                                <label for="confirm_password">Confirm password</span></label>
                                <div>
                                    <input type="password" class="form-control" id="confirm_password" value="" name="confirm_password" placeholder="Confirm password"/>
                                    <em id="confirm_password-require-error" class="error invalid-feedback">Please enter your confirm password</em>
                                    <em id="password-same-error" class="error invalid-feedback">Please enter the same password as above</em>
                                </div>
                            </div>                           
                        </div>
                        
                    </div>
                    <hr>
                    <div class="text-center">
                        <input type="submit" id="edituser" class="btn-shadow-primary btn btn-primary btn-lg" value="Save">
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/sweetalert.min.js') }}" defer></script>
    <script>
        $(document).ready(function(){
            var success = "{{session('success')}}";
            console.log(success)
            if(success){
            swal({
                title: "Success",
                text: success,
                icon: "success",
                button: "OK",
                });
            }
        })
        
    </script>
@endsection
