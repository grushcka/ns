@extends('layouts.app')
@section('title')
    Profile
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profile</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        Its Your Profile Edit Page
                        @can('change',$user)
                            <form method="POST" action="{{route('profile.update',$user)}}">
                                @csrf
                                @error('login')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label>
                                    Login
                                    <input type="text" name="login" placeholder="login">
                                </label>
                                <input type="submit">
                            </form>
                        @endcan
                        <form method="post" action="{{route('profile.delete',$user)}}">
                            @csrf
                            <button>Delete</button>
                        </form>
                        <b>{{$user->name}}</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
