@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @if(auth()->user()->isAdmin())
        @include('dashboard.partials.admin')
    @elseif(auth()->user()->isManager())
        @include('dashboard.partials.manager')
    @else
        @include('dashboard.partials.sales')
    @endif
@endsection