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

                        Its Your Profile Page

                        <b>{{$user->name}}</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
