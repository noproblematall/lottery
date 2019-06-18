<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CMS') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}" defer></script>    

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <style>
        .bg-plum-plate {
            background-color:#05052a !important;
        }
        .modal-content {
            background-color:#05052a;
            box-shadow: 0 0 15px 3px;
            border-radius: 1.3rem;
        }
    </style>
</head>

<body>
<div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100 bg-plum-plate bg-animation">
                <div class="mx-auto mt-5 text-center">
                    <img src="{{asset('images/logo.png')}}" alt="" srcset="" width="250" height="144">
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    
                    <div class="mx-auto app-login-box col-md-8">
                        {{-- <div class="app-logo-inverse mx-auto mb-3"></div> --}}
                        <div class="modal-dialog w-100 mx-auto">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="h5 modal-title text-center">
                                        <h4 class="mt-2">
                                            <span>Please sign in to your account below.</span>
                                        </h4>
                                    </div>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <input name="name" id="exampleEmail" placeholder="Name here..." value="{{ old('name') }}" type="text" class="form-control @error('name') is-invalid @enderror" autofocus>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <input name="password" id="examplePassword" placeholder="Password here..." type="password" class="form-control @error('password') is-invalid @enderror">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            {{-- @error('block')
                                                <span class="invalid-feedback" style="display:block;font-size:100%;" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror --}}
                                            @if(session('block'))
                                                <span class="invalid-feedback" role="alert" style="display:block;font-size:100%;">
                                                    <strong>{{ session('block') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="divider"></div>
                                        <div class="text-center">
                                            <button type="submit"  class="btn btn-primary btn-lg">{{ __('Login') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="text-center text-white opacity-8 mt-3">&copy; 2019 kaizerassoc.com</div>
                    </div>
                </div>
            </div>
        </div>
</div>
</html>
