@extends('layouts.auth')
@section('title', 'Check your inbox')
@section('intro', 'One small step before you’re in.')
@section('content')
    <p class="verification-copy">Open the verification link sent to <strong>{{ auth()->user()->email }}</strong> to activate your account. If it hasn’t arrived, check your spam folder or request another email.</p>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="button primary full" type="submit">Resend verification email</button>
    </form>
    <form method="POST" action="{{ route('logout') }}" class="form-foot">
        @csrf
        <button type="submit" class="text-button">Sign out</button>
    </form>
@endsection
