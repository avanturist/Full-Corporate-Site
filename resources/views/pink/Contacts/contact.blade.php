@extends(config('settings.theme').'.layouts.site')

@section('navigation')
    {!! $navigation !!}
    @endsection

@section('sidebar')
    {!! $leftBar !!}
@endsection

@section('content')
    {!! $content !!}
@endsection

@section('footer')
    {!! $footer !!}
@endsection