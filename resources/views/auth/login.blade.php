@extends('layouts.app')

@section('content')
    @if (session('message'))
        <div class="alert alert-danger">{{ session('message') }}</div>
    @endif
    <form method="POST" action="{{ route('auth.login') }}">
        @csrf
        <base-input
            name="username"
            @if(old('username'))
            old_value="{{old('username','')}}"
            @endif
            @error('username')
            error_message="{{$message??''}}"
            @enderror
        ></base-input>

        <base-input
            name="password"
            type="password"
            @error('password')
            error_message="{{$message??''}}"
            @enderror
        ></base-input>

        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>

                @if (Route::has('user.password.request'))
                    <a class="btn btn-link" href="{{ route('user.password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </div>
    </form>

@endsection
