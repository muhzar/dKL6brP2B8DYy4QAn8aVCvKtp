@extends('frontend.templates.default')

@section('css')
<style type="text/css">
    .img-responsive {
        width: 100%;
    }
    h2 {
        text-transform: uppercase;
        padding:  30px 0 ;
        color:  #fff;
        background-color: #000;
    }
    .cluster {
        background-color: #000;
        border:  2px solid #000;
        margin-top: 30px;
    }
    .title {
        color: #fff;
        text-transform: uppercase;
        font-size: 12px;
        background-color: #000;
        font-weight: bold;
    }
    body {
        background-color: #337ab7;

    }
</style>
@endsection

@section('js')
    
        
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Alam Sutera Guard Monitoring</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <a href="/cluster/all">
                    <div class="cluster">
                        <img src="images/cluster/all.png" class="img-responsive">
                        <div class="text-center" style="display: block;"><span class="title">All</span></div>
                    </div>
                </a>
            </div>
            @foreach($clusters as $cluster)
            <div class="col-md-2">
                <a href="/cluster/{{ $cluster->code }}">
                    <div class="cluster">
                        <img src="images/cluster/{{ strtolower($cluster->code) }}.png" class="img-responsive">
                        <div class="text-center" style="display: block;"><span class="title">{{ $cluster->name }}</span></div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
@endsection
