@extends('layouts.auth')
@section('title', 'Confirm it’s you')
@section('intro', 'Please enter your password to continue.')
@section('content')
    <form method="POST" action="{{ route('password.confirm.store') }}" class="form-stack">
        @csrf
        <x-input name="password" label="Password" type="password" autocomplete="current-password" required autofocus />
        <button class="button primary full" type="submit">Continue</button>
    </form>
@endsection
