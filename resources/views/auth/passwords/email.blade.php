@extends('layouts.auth')
@section('content')
<div class="authPage">
    <h1 class="text-white m-0">{{ __('Reset Password') }}</h1>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <fieldset>
                <input id="email" type="email" class="@error('email') b-red @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">
                @error('email')
                <p>{{ $message }}</p>
                @enderror
            </fieldset>
        </div>
        <button type="submit"> {{ __('Send Password Reset Link') }}</button>
    </form>
</div>
@endsection
