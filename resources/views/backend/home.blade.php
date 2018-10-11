@extends('backend.templates.default')

@section('title')CMS {{ config('app.site_name') }}@endsection

@section('head')
@endsection

@section('js')
@endsection

@section('content')
<iframe src="/dashboard" style="width: 100%; height: 600px"></iframe>
    
@endsection