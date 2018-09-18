@extends('backend.templates.default')

@section('title')CMS {{ config('app.site_name') }}@endsection

@section('head')
@endsection

@section('js')
@endsection

@section('content')
    <!-- <div class="row">
        <div class="col-md-3">
            <div class="widget schedule">
                <h3>Guard on Duty</h3>
                <div class="content">
                    <ul>
                        @foreach($schedules as $schedule)
                        <li>{{ $schedule->getGuard->name }}({{ $schedule->getShift->name }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div> -->
    
@endsection