@extends('admin.layouts.master')

@section('content')

<div class="page-wrapper default-version">
    @include('admin.components.sidenav')
    <div class="top-nav-bg">
        @include('admin.components.topnav')
        <div class="breadcrumb-wrapper">
            @include('admin.components.breadcrumb')
        </div>
    </div>

    <div class="body-wrapper">
        <div class="bodywrapper__inner">
            @yield('panel')
        </div>
    </div>
</div>



@endsection