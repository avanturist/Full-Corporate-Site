<div id="content-blog" class="content group" >
    @if(count($art_content) > 0)
        @foreach($art_content as $item)
            <div class="hentry hentry-post blog-big group">
                <!-- post featured & title -->
                <div class="thumbnail">
                    <!-- post title -->
                    <h2 class="post-title"><a href="{{ route('articles.show', ['alias'=>$item->alias]) }}">{{ $item->name }}</a></h2>
                    <!-- post featured -->
                    <div class="image-wrap">
                        <img src="{{ asset(config('settings.theme')) }}/images/articles/{{ $item->img->max }}" alt="{{ $item->img->max }}" title="{{ $item->img->max }}" />
                    </div>
                    <p class="date">
                        <span class="month">{{ (isset($item->created_at)) ? $item->created_at->format('M'): 'Mon'}}</span>
                        <span class="day">{{ (isset($item->created_at)) ? $item->created_at->format('d'): 'D' }}</span>
                    </p>
                </div>
                <!-- post meta -->
                <div class="meta group">
                    <p class="author"><span>by <a href="#" title="Posts by " rel="author">{!! $item->user->name !!}</a></span></p>
                    <p class="categories"><span>In: <a href="{{ route('articlesCat', ['cat_alias'=>$item->category->alias]) }}" title="View all posts in {{ $item->category->title }}" rel="category tag">{{ $item->category->title }}</a></span></p>
                    <p class="comments"><span><a href="{{ route('articles.show', ['alias'=>$item->alias])  }}#respond" title="Comment on Section shortcodes &amp; sticky posts!">{{ count($item->comments) ? count($item->comments): '0'}} {{ (Config::get('app.locale') == 'ru') ? Lang::choice('ru.all_comments', count($item->comments)) : 'comments' }} </a></span></p>
                </div>

                <!-- post content -->
                <div class="the-content group">
                   <p>{!! $item->desc !!}</p>
                    <p><a href="{{ route('articles.show', ['alias'=>$item->alias]) }}" class="btn   btn-beetle-bus-goes-jamba-juice-4 btn-more-link">→ {{ (Config::get('app.locale') == 'ru') ? trans('ru.Read_more') : 'Read more'  }}</a></p>
                </div>
                <div class="clear"></div>
            </div>

        @endforeach
            <div style="text-align: center">
                {{ $art_content->links(config('settings.theme').'.links_pagin', ['parametrs'=>$art_content]) }}
            </div>

    @else
        <div class="hentry hentry-post blog-big group">
            <div class="thumbnail" >
                <p class="alert-info" style="margin-top: 20px!important;">{{ (Config::get('app.locale') == 'ru') ? Lang::get('ru.no_articles'): 'Article' }}</p>
            </div>
        </div>

    @endif
</div>
