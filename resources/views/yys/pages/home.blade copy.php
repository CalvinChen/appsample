@extends('yys.layouts.app')

@section('title')
    Page Title
@endsection

@section('sidebar')
    @parent
    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <p>This is my body content.</p>
@endsection