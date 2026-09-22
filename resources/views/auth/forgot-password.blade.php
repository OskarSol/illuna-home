@extends('layouts.auth')
@section('title', 'Forgot your password?')
@section('intro', 'Enter your email address and we’ll help you get back in.')
@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="form-stack">
        @csrf
        <x-input name="email" label="Email address" type="email" :value="old('email')" autocomplete="username" required autofocus maxlength="254" />
        <button class="button primary full" type="submit">Send reset link</button>
    </form>
    <p class="form-foot"><a href="{{ route('login') }}">Back to sign in</a></p>
@endsection
