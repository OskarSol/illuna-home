@extends('layouts.auth')
@section('title', 'Welcome back')
@section('intro', 'Sign in to your Illuna account.')
@section('content')
    <form method="POST" action="{{ route('login.store') }}" class="form-stack">
        @csrf
        <x-input name="email" label="Email address" type="email" :value="old('email')" autocomplete="username" required autofocus maxlength="254" />
        <x-input name="password" label="Password" type="password" autocomplete="current-password" required />
        <div class="form-row">
            <label class="checkbox"><input type="checkbox" name="remember" value="1" @checked(old('remember'))> Remember me</label>
            <a href="{{ route('password.request') }}">Forgot password?</a>
        </div>
        <button class="button primary full" type="submit">Sign in <span aria-hidden="true">→</span></button>
    </form>
    @if (Route::has('register'))
        <p class="form-foot">New to Illuna? <a href="{{ route('register') }}">Create an account</a></p>
    @else
        <p class="form-foot">New registrations are currently closed.</p>
    @endif
@endsection
