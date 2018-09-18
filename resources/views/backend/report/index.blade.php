@extends('backend.templates.default')

@section('css')

@endsection

@section('js')
    <script type="text/javascript">
        $('.frame').attr('height', 650);
    </script>
    
@endsection

@section('content')
    <iframe src="{{ url('route') }}" class="frame" width="100%" border="0"></iframe>
@endsection