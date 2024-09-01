@extends('layouts.auth')
@section('content')
<div class="authPage">
    <h1 class="text-white m-0">Login</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <fieldset>
                <input id="email" type="email" class="@error('email') b-red @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">
                @error('email')
                    <p>{{ $message }}</p>
                @enderror
            </fieldset>
            <fieldset>
                <input id="password" type="password" class="@error('password') b-red @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                @error('password')
                    <p>{{ $message }}</p>
                @enderror
            </fieldset>
            <div class="col-3 checkbox">
                <input type="checkbox" name="remember" id="check1" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="check1"> Remember me </label>
            </div>
        </div>
        <button type="submit">Login</button>
    </form>
    @if (Route::has('password.request'))
        <a class="forgot" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }}
        </a>
    @endif
</div>


@endsection
