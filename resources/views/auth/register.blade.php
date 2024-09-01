@extends('layouts.auth')
@section('content')
<div class="authPage">
    <h1 class="text-white m-0">Register</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <fieldset>
                <input id="name" type="text" class="@error('name') b-red @enderror" name="name" value="{{ old('name') }}" placeholder="Name" required autocomplete="name">
                @error('name')
                <p>{{ $message }}</p>
                @enderror
            </fieldset>
            <fieldset>
                <input id="email" type="email" class="@error('email') b-red @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">
                @error('email')
                <p>{{ $message }}</p>
                @enderror
            </fieldset>
            <fieldset>
                <input id="password" type="password" class="@error('password') b-red @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                @error('password')
                <p>{{ $message }}</p>
                @enderror
            </fieldset>
            <fieldset>
                <input id="password-confirm" type="password" class="@error('password') b-red @enderror" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                @error('password')
                <p>{{ $message }}</p>
                @enderror
            </fieldset>
        </div>
        <button type="submit">Register</button>
    </form>
</div>


@endsection
