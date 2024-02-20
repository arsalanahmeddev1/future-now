@extends('layout.front-layout')
@section('title','Forgot Password')
@section('content')
        <div class="login-form-main position-relative">
            <div class="container container-c">
                <div class="row">
                    <div class="col-10 mx-auto">
                        <div class="login-form p-login-page mb-24">
                            <div class="form-head d-flex flex-column justify-content-center align-items-center">
                                <h1 class="form-top-heading">Forget Password</h1>
                                <p class="form-bottom-heading">Enter your email and password to sign in</p>
                            </div>
                            <form action="{{route('user.forgot-password')}}" class="form" method="POST">
                                @csrf
                                @error('email')
                                    {{ $message }}
                                @enderror
                                <label for="#" class="label-field mt-4 ">Enter your email to recover your password *</label>
                                <input type="email" name="email" placeholder="Enter your email" required class="input-field my-3 py-3 px-4">
                                <button type="submit" class="register-btn mb-2">Continue</button>
                                <a href="{{route('user.register')}}" class="form-bottom-heading" style="text-decoration: none;">Don't have an account? <span class="target-page" style="color: #F54D81;"> Sign up </span></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
