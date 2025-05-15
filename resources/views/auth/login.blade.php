@extends('layouts.app')

@extends('layouts.app')

@section('content')
<div class="container-xl px-4">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5 mb-0">
                <div class="align-items-center text-center mt-4">
                    <!-- Gambar Logo Aplikasi -->
                    <img src="{{ asset('assets/img/logo-kasta.png') }}" alt="Logo Aplikasi" class="img-fluid" style="max-width: 100px;">
                </div>
                <div class="card-body mt-0">
                    @if ($errors->any())
                    <div style="color: red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Email -->
                        <div class="mb-3">
                            <label class="small mb-1" for="email">{{ __('Email') }}</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter email" />
                            @error('email')
                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="small mb-1" for="password">{{ __('Password') }}</label>
                            <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" required placeholder="Enter password" />
                            @error('password')
                            <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />
                                <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            @if (Route::has('password.request'))
                            <a class="small" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                            @endif
                            <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    @if (Route::has('register'))
                    <div class="small">
                        <a href="{{ route('register') }}">{{ __('Need an account? Sign up!') }}</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection