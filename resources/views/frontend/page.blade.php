@extends('frontend.templates.default')

@section('css')

@endsection

@section('js')
    
@endsection

@section('content')

    <section class="section sectionTop">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li class="last"><a href="#">{{ $page->title }}</a></li>
                        </ul>
                    </div>
                    <div class="sectionBody align-left">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 margin mb10">
                                <div class="imageStyle">
                                    <a href="#">
                                        <img src="{{ asset('uploads/images/' . $page->image) }}" alt="{{ $page->title }}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-8 margin mb10">
                                {!! $page->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection