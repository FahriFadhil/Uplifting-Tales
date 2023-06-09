@extends('layouts.app')

@section('content')

<!-- <div class="form-group row">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

    <div class="col-md-6">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

    <div class="col-md-6">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-6 offset-md-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-8 offset-md-4">
        <button type="submit" class="btn btn-primary">
            {{ __('Login') }}
        </button>

        @if (Route::has('password.request'))
        <a class="btn btn-link" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }}
        </a>
        @endif
    </div>
</div> -->


<div class="px-64 py-16 flex flex-col items-center">
    <h1 class="text-2xl text-sky-700">Selamat datang kembali! Bagikan kisah inspiratifmu.</h1>
    <div class="border border-sky-700 rounded-lg py-8 px-16 mt-12 w-5/12 shadow-lg">
        <h1 class="text-xl">Masukkan Akun Kamu!</h1>
        <form method="POST" action="{{ route('login') }}" class="flex flex-col justify-start w-full mt-4">
            @csrf
            <label class="text-sm" for="name">Email</label>
            <input id="email" type="email" class="py-2 px-4 bg-sky-50 focus:border border-sky-700 shadow outline-0 mb-4 mt-1 rounded" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            <label class="text-sm" for="name">Password</label>
            <input id="password" type="password" class="py-2 px-4 bg-sky-50 focus:border border-sky-700 shadow outline-0 mb-4 mt-1 rounded" name="password" required autocomplete="current-password">
            <div class="flex justify-between">
                <div class="flex items-center gap-2">
                    <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="text-sm" for="remember">Ingatkan saya</label>
                </div>
                <a class="text-sm hover:underline" href="{{ route('password.request') }}">Lupa Password?</a>
            </div>
            <button type="submit" class="bg-sky-700 text-sky-50 py-2 px-4 rounded-lg mt-4">
                Masuk
            </button>
        </form>
    </div>
    <a href="/register" class="text-sky-700/75 hover:text-sky-700 hover:underline mt-6">Belum Memiliki Akun? Daftar Disini!</a>
</div>

@endsection