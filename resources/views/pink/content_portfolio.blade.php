@if(count($all_portsf) > 0)


<div id="content-page" class="content group">
    <div class="hentry group">
        @foreach($all_portsf as $portfolio)
            <div id="portfolio" class="portfolio-big-image">
                <div class="hentry work group">
                    <div class="work-thumbnail">
                        <div class="nozoom">

                            <img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->img->path}}" alt="{{ $portfolio->img->path  }}" title="{{ $portfolio->title  }}" />
                            <div class="overlay">
                                <a class="overlay_img" href="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->img->path }}" rel="lightbox" title="Love"></a>
                                <a class="overlay_project" href="{{ route('portfolios.show', ['alias'=>$portfolio->alias]) }}"></a>
                                <span class="overlay_title">{{ $portfolio->title }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="work-description">
                        <h3>{!! $portfolio->title !!}</h3>
                        <p>{!! str_limit($portfolio->text, 1000) !!}</p>
                        <div class="clear"></div>
                        <div class="work-skillsdate">
                            <p class="skills"><span class="">Filter:</span><a href="{{ route('filterportfolio', $portfolio->filter_alias) }}"> {{ $portfolio->filter_alias }}</a></p>
                            <p class="skills"><span class="">Customer:</span> {{ $portfolio->customer }}</p>
                            <p class="skills"><span class="">Year:</span> {{ $portfolio->created_at->format('Y') }}</p>
                        </div>
                        <a class="read-more" href="{{ route('portfolios.show', ['alias'=>$portfolio->alias]) }}">View Project</a>
                    </div>
                    <div class="clear"></div>
                </div>

            </div>
        @endforeach

        <!---- pagination --->
            <div style="text-align: center">
                {{ $all_portsf->links() }}
            </div>

        <div class="clear"></div>
    </div>


</div>
    @else
        <div class="alert alert-info">
            {{ Config::get('settings.non_portfolio') }}
        </div>
    @endif