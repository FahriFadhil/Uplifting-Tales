@extends('layouts.app')

@section('content')

<!-- <div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

    <div class="col-md-6">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

    <div class="col-md-6">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-primary">
            {{ __('Register') }}
        </button>
    </div>
</div> -->

<div class="px-64 py-16 flex flex-col items-center">
    <h1 class="text-2xl text-sky-700">Bergabung dengan kami untuk berbagi kisah inspiratif kamu!</h1>
    <div class="border border-sky-700 rounded-lg py-8 px-16 mt-12 w-5/12 shadow-lg">
        <h1 class="text-xl">Daftarkan Akun Kamu!</h1>
        <form method="POST" action="{{ route('register') }}" class="flex flex-col justify-start w-full mt-4">
            @csrf
            <label class="text-sm" for="name">Nama</label>
            <input id="name" type="text" class="py-2 px-4 bg-sky-50 focus:border border-sky-700 shadow outline-0 mb-4 mt-1 rounded" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            <label class="text-sm" for="name">Email</label>
            <input id="email" type="email" class="py-2 px-4 bg-sky-50 focus:border border-sky-700 shadow outline-0 mb-4 mt-1 rounded" name="email" value="{{ old('email') }}" required autocomplete="email">
            <label class="text-sm" for="name">Password</label>
            <input id="password" type="password" class="py-2 px-4 bg-sky-50 focus:border border-sky-700 shadow outline-0 mb-4 mt-1 rounded" name="password" required autocomplete="new-password">
            <label class="text-sm" for="name">Konfirmasi Password</label>
            <input id="password-confirm" type="password" class="py-2 px-4 bg-sky-50 focus:border border-sky-700 shadow outline-0 mb-8 mt-1 rounded" name="password_confirmation" required autocomplete="new-password">
            <button type="submit" class="bg-sky-700 text-sky-50 py-2 px-4 rounded-lg">
                Daftar
            </button>
        </form>
    </div>
    <a href="/login" class="text-sky-700/75 hover:text-sky-700 hover:underline mt-6">Sudah Memiliki Akun? Masuk Disini!</a>
</div>
@endsection