@extends('layout-login')
@section('content')
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <!-- Logo Section -->
                                <!-- Login Title -->
                                <div class="text-center">
                                @if(Session::has('message'))
                                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                                @endif
                                    <h1 class="h4 text-gray-900 mb-4">Login to Your Account</h1>
                                </div>
                                <!-- Login Form -->
                                <form class="user" method="POST" action="{{ route('login.post') }}" id="form">
                                    @csrf
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-text bg-warning text-white">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" class="form-control form-control-user" id="input-username"
                                                placeholder="Enter Username..." name="username">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-text bg-warning text-white">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" class="form-control form-control-user" id="input-password"
                                                placeholder="Enter Password..." name="password">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-warning btn-user btn-block">
                                        <i class="fas fa-sign-in-alt"></i> Login
                                    </button>
                                </form>
                                <!-- Forgot Password Link -->
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="#">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{route('register-page')}}">Create Account?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        body {
            background: url('your-background-image-url.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
        }

        .input-group-text {
            border-right: 0;
        }

        .form-control-user {
            border-left: 0;
        }
    </style>
@endsection
