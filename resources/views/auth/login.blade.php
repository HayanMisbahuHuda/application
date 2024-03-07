@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <!-- <div class="card "> -->
                <!-- <div class="card-header text-center">{{ __('Welcome') }}</div> -->

                <div class="card-body text-center">
                <img style="" src="{{asset('images/LogoHuda.png')}}">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                            <div class="row mb-3 mt-5">
                            <label for="email" class="text-login col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email Address" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="text-login col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 form-check-input1">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check" style="position :absolute; margin-left: 50px;">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"  {{ old('remember') ? 'checked' : '' }}>

                                    <label class="text-login form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="text-center" style="margin-top: 12px;">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
<br>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .text-login2{
        color: white ;
        
    }
    .text-login {
        color: white !important;
    }
    .card-body {
        /* display: flex; */
        align-items: center;
        flex-direction: column;
        padding: 3rem;
        width: 100%;
        background-color: #1b2028;
        border-radius: 16px;
        position: relative;
        border: 3px solid transparent;
        background-clip: padding-box;
        text-align: center;
        color: #f1f3f3;
        background-image: linear-gradient(
            135deg,
            rgba(#752e7c, 0.35),
            rgba(#734a58, 0.1) 15%,
            #1b2028 20%,
            #1b2028 100%
        );
        &:after {
            content: "";
            display: block;
            top: -3px;
            left: -3px;
            bottom: -3px;
            right: -3px;
            z-index: -1;
            position: absolute;
            border-radius: 16px;
            background-image: linear-gradient(
                135deg,
                #752e7c,
                #734a58 20%,
                #1b2028 30%,
                #2c333e 100%
            );
        }
    }
</style>
