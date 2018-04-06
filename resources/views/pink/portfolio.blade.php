@if(count($portf) > 0)

<div id="content-home" class="content group">
        <div class="hentry group">
            <div class="section portfolio">
            <!--вивід свіжого портфоліо --->
                @if(!empty($last))


                    <h3 class="title">{{ (Config::get('app.locale') == 'ru') ? trans('ru.latest_progect'): 'latest_progect' }}</h3>

                    <div class="hentry work group portfolio-sticky portfolio-full-description">
                        <div class="work-thumbnail">
                            <a class="thumb"><img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $last->img->max }}" alt="{{ $last->img->max }}" title="{{ $last->img->max }}" /></a>
                            <div class="work-overlay">
                                <h3><a href="{{ route('portfolios.show' , ['alias'=>$last->alias]) }}">{{ $last->title }}</a></h3>
                                <p class="work-overlay-categories"><img src="{{ asset(config('settings.theme')) }}/images/categories.png" alt="Categories" /> in: <a href="{{ route('filterportfolio', $last->filter_alias) }}"> {{ $last->filter_alias }}</a>, </p>

                            </div>
                        </div>
                        <div class="work-description">
                            <h2><a href="{{ route('portfolios.show',['alias'=>$last->alias]) }}">{{ $last->title }}</a></h2>
                            <!---------------------- filtre--------------------------->

                            in: <a href="{{ route('filterportfolio', $last->filter_alias) }}"> {!! $last->filter_alias !!}</a>
                            <p>{{ str_limit($last->text,200) }}</p>
                            <a href="{{ route('portfolios.show' , ['alias'=>$last->alias]) }}" class="read-more">|| Read more</a>


                        </div>
                    </div>
            @endif<!-------------->
                <div class="clear"></div>


                <div class="portfolio-projects">
                    <!-- вивід портфоліо 4шт крім свіжого-->

                    @foreach($portf as $item)
                        @if($item->id !== $last->id)

                    <div class="related_project {{ ($portf->last()) ? 'related_project_last related_project':''}}">
                        <div class="overlay_a related_img">
                            <div class="overlay_wrapper">
                                {{--<img src="http://gravatar.com/avatar/{}?dmm&55" alt="0061" title="0061" />--}}
                                <img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $item->img->max }}" alt="0061" title="0061" />
                                <div class="overlay">
                                    <a class="overlay_img" href="{{ asset(config('settings.theme')) }}/images/projects/{{ $item->img->path }}" rel="lightbox" title=""></a>
                                    <a class="overlay_project" href="{{ route('portfolios.show', ['alias'=>$item->alias]) }}"></a>
                                    <span class="overlay_title">{{ $item->title }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="work-description">
                            <h4><a href="{{ route('portfolios.show', ['alias'=>$item->alias]) }}">{{ $item->title }}</a></h4>
                            <p>{{ str_limit($item->text, 50) }}</p>
                            <a href="{{ route('portfolios.show' , ['alias'=>$last->alias]) }}" class="read-more">|| Read more</a>
                        </div>
                    </div>
                        @endif
                    @endforeach

                </div>

            </div>
            <div class="clear"></div>
        </div>
        <!-- START COMMENTS -->
        <div id="comments">
        </div>
        <!-- END COMMENTS -->
</div>
    @else
    <!-- Якщо немає жодного портфоліо--->
        <p class="alert alert-info" style="width: 50%">{!! Config::get('settings.non_portfolio') !!}</p>

    @endif