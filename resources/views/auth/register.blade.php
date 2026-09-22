@extends('layouts.auth')
@section('title', 'Make yourself at home')
@section('intro', 'Create your Illuna account to get started.')
@section('content')
    <form method="POST" action="{{ route('register.store') }}" class="form-stack">
        @csrf
        <x-input name="name" label="Your name" :value="old('name')" autocomplete="name" required autofocus maxlength="100" />
        <x-input name="email" label="Email address" type="email" :value="old('email')" autocomplete="username" required maxlength="254" />
        <x-input name="password" label="Password" type="password" autocomplete="new-password" required minlength="12" maxlength="72" aria-describedby="password-help" />
        <small id="password-help" class="helper">Use 12–72 characters. A memorable passphrase works well.</small>
        <x-input name="password_confirmation" label="Confirm password" type="password" autocomplete="new-password" required minlength="12" maxlength="72" />
        <button class="button primary full" type="submit">Create account <span aria-hidden="true">→</span></button>
    </form>
    <p class="form-foot">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
@endsection
