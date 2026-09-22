@extends('layouts.portal')
@section('title', 'Account settings')
@section('content')
    <div class="page-heading"><span class="eyebrow">THE ESSENTIALS</span><h1>Your account<span class="accent">.</span></h1><p>A few details that make this space yours.</p></div>
    <section class="card settings-card" aria-labelledby="profile-title">
        <div class="settings-description"><h2 id="profile-title">Personal details</h2><p>Changing your email requires your current password and a new email verification.</p></div>
        <form method="POST" action="{{ route('user-profile-information.update') }}" class="form-stack">
            @csrf @method('PUT')
            <x-input name="name" label="Your name" bag="updateProfileInformation" :value="old('name', auth()->user()->name)" autocomplete="name" required maxlength="100" />
            <x-input name="email" label="Email address" type="email" bag="updateProfileInformation" :value="old('email', auth()->user()->email)" autocomplete="username" required maxlength="254" />
            <x-input name="current_password" id="profile-current-password" label="Current password (only when changing email)" type="password" bag="updateProfileInformation" autocomplete="current-password" />
            <button class="button primary" type="submit">Save details</button>
        </form>
    </section>
    <section class="card settings-card" aria-labelledby="password-title">
        <div class="settings-description"><h2 id="password-title">Password</h2><p>Choose a passphrase with 12–72 characters. Other sessions will be signed out when you change it.</p></div>
        <form method="POST" action="{{ route('user-password.update') }}" class="form-stack">
            @csrf @method('PUT')
            <x-input name="current_password" id="password-current-password" label="Current password" type="password" bag="updatePassword" autocomplete="current-password" required />
            <x-input name="password" label="New password" type="password" bag="updatePassword" autocomplete="new-password" required minlength="12" maxlength="72" />
            <x-input name="password_confirmation" label="Confirm new password" type="password" bag="updatePassword" autocomplete="new-password" required minlength="12" maxlength="72" />
            <button class="button primary" type="submit">Update password</button>
        </form>
    </section>
@endsection
