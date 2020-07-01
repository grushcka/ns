@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">{{ __('Register') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('user.register') }}">
                @csrf
                @foreach([
                    'login' => 'text',
                    'email' => 'email',
                    'password' => 'password',
                    'password_confirmation' => 'password'
                    ] as $name => $type)
                    <base-input
                        name="{{$name}}"
                        @if(old($name))
                        old_value="{{old($name,'')}}"
                        @endif
                        @error($name)
                        error_message="{{$message??''}}"
                        @enderror
                        type="{{$type}}"
                    ></base-input>
                @endforeach

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
<script>
    import BaseInput from "../../../js/components/BaseInput";

    export default {
        components: {BaseInput}
    }
</script>
