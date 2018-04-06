@extends(config('settings.theme').'.layouts.admin')

@section('navigation')
    {!! $navigation !!}
    @endsection

@section('content')
    <div class="error_403">
        <h4>У Вас нет прав доступа!</h4>
    </div>
    @include(config('settings.theme').'.Admin.admin_content')
    @endsection

