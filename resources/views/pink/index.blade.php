@extends(config('settings.theme').'.layouts.site')

@section('navigation')
    {{--використовуємо змінну в якій будемо зберігати код конкретного макету--}}
    {!! $navigation !!}
@endsection

@section('slider')
        {!! $sliders !!}
@endsection

@section('content')
    {!! $portfolio !!}
    @endsection

@section('sidebar')
    {!! $rightBar !!}
@endsection

@section('footer')
    {!! $footer !!}
    @endsection