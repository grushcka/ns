@extends('layouts.app')

@section('content')

    <hello-component> </hello-component>
    @if(auth()->id())
        <auth-hello-component username="{{auth()->user()->email}}"></auth-hello-component>
    @endif
@endsection
