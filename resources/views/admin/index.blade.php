@extends('layouts.admin.layoutAdmin')

@section('headerH1')
    <h1>ADMIN index page</h1>
@endsection

@section('title', $title ?? 'no title')

@section('content')
    <h2>Header h2</h2>
    @isset($users)

    <ul>
     @foreach($users as $user)
         <li>{{$loop->iteration}} - {{ $user['name'] }}</li>
     @endforeach
    </ul>
    @endisset
@endsection
