@extends(config('settings.theme').'.layouts.site')

@section('navigation')
  {!! $navigation!!}
    @endsection

@section('content')
    <div id="content-index" class="content group">
        <img class="error-404-image group" src="{{ asset(config('settings.theme')) }}/images/features/404.png" title="Error 404" alt="404" />
        <div class="error-404-text group">
            <p>
                @if(Config::get('app.locale') == 'en')
                    We are sorry but the page you are looking for does not exist.<br />
                    You could <a href="{{ route('home') }}">return to the home page.</a>
                @else
                    Мы сожелеем, но страница которую вы ищете не существует.<br />
                    Вы можете <a href="{{ route('home') }}"> вернутся на главную страницу.</a>
                @endif
            </p>

        </div>
    </div>
    @endsection

@section('footer')
    @include(config('settings.theme').'.footer')
    @endsection