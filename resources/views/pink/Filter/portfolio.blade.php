@if(count($filter) > 0)
    <div class="container">
        <h2>Фильтрация Portfolio</h2>

            <div class="row">
                <div class="block">
                    <button class="btn btn-link current">All</button>
                   @foreach($filter as $f)
                       <button class="btn btn-link">{{ $f->title }}</button>
                   @endforeach
                </div>
            </div>
    </div>
@endif

<hr>
@foreach($parametrs as $item)

    <div class="related_project {{ $item->filter_alias }}">
        <a class="related_img dark_square" href="{{ route('portfolios.show', ['alias'=>$item->alias]) }}" title="{{ $item->title }}"><img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $item->img->mini }}" alt="0061" title="0061" /></a>
        <h4><a href="{{ route('portfolios.show', ['alias'=>$item->alias]) }}">{{ $item->title }}</a></h4>
    </div>


@endforeach

<div id="show"></div>