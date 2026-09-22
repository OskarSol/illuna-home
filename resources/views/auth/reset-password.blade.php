@extends('layouts.auth')
@section('title', 'Choose a new password')
@section('intro', 'A fresh start for your account.')
@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="form-stack">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <x-input name="email" label="Email address" type="email" :value="old('email', $request->email)" autocomplete="username" required maxlength="254" />
        <x-input name="password" label="New password" type="password" autocomplete="new-password" required autofocus minlength="12" maxlength="72" />
        <small class="helper">Use 12–72 characters.</small>
        <x-input name="password_confirmation" label="Confirm new password" type="password" autocomplete="new-password" required minlength="12" maxlength="72" />
        <button class="button primary full" type="submit">Reset password</button>
    </form>
@endsection
