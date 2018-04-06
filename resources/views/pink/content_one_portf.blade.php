@if(count($one_portf) > 0)
    <div id="content-page" class="content group" >
        <div class="clear"></div>

        <div class="posts">
                <div class="group portfolio-post internal-post">
                    <div id="portfolio" class="portfolio-full-description">

                        <div class="fulldescription_title gallery-filters">
                            <h1>{{ $one_portf->title }}</h1>
                        </div>

                        <div class="portfolios hentry work group">
                            <div class="work-thumbnail">
                                <a class="thumb"><img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $one_portf->img->max }}" alt="{{ $one_portf->img->max }}" title="{{ $one_portf->title }}" /></a>
                            </div>
                            <div class="work-description">
                                <p>{!! $one_portf->text !!}</p>
                                <p>Sed <a href="http://yourinspirationweb.com/demo/sheeva/work/xmas-icons/#">porttitor eros </a>ut purus elementum a consectetur purus vulputate</p>
                                <div class="clear"></div>
                                <div class="work-skillsdate">
                                    <p class="skills"><span class="">Filter:</span><a href="{{ route('filterportfolio', $one_portf->filter_alias) }}"> {{ $one_portf->filter_alias }}</a></p>
                                    <p class="workdate"><span class="">Year:</span> {{ $one_portf->created_at->format('Y')}}</p>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>

                    </div>
                    <div class="clear"></div>

                </div>
        </div>
        <div class="clear"></div>

        @if(count($all_prt_content) > 0 )
        <h3>Other Projects</h3>

        <div class="portfolio-full-description-related-projects">
            @foreach($all_prt_content as $portfolio)

                @if($portfolio->id !== $one_portf->id)

                    <div class="related_project">
                        <a class="related_img dark_square" href="{{ route('portfolios.show', ['alias'=>$portfolio->alias]) }}" title="{{ $portfolio->title }}"><img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->img->mini }}" alt="0061" title="0061" /></a>
                        <h4><a href="{{ route('portfolios.show', ['alias'=>$portfolio->alias]) }}">{{ $portfolio->title }}</a></h4>
                    </div>

                @endif

            @endforeach
        </div>
        @else
            <div class="alert alert-info">
                {{ Config::get('settings.non_portfolio') }}
            </div>
        @endif

    @else
        <!-- /portfolio/filter -------------->
            @if(count($all_prt_content) > 0 && !isset($one_portf))

                @include(config('settings.theme').'.Filter.portfolio', ['parametrs'=>$all_prt_content, 'filter'=>$filter_prt])

            @else
                <div class="alert alert-info">
                    {{ Config::get('settings.non_portfolio') }}
                </div>

            @endif

    </div>
@endif


