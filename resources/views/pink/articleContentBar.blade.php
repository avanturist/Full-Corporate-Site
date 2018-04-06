@if($articleBarPor)
    <div class="widget-first widget recent-posts">
        <h3>{{ (Config::get('app.locale') == 'ru') ? Lang::get('ru.Recent Posts') : 'Recent Posts'}}</h3>
        <div class="recent-post group">
            @foreach($articleBarPor as $item)
                <div class="hentry-post group">
                    <div class="thumb-img"><img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $item->img->mini }}" alt="{{ $item->img->mini }}" title="{{ $item->img->mini }}" /></div>
                    <div class="text">
                        <a href="{{ route('portfolios.show', ['alias'=>$item->alias]) }}" title="Section shortcodes &amp; sticky posts!" class="title">{{ $item->title }}</a>
                        <p>{{ str_limit($item->text, 50) }}</p>
                        <p class="post-date">{{ $item->created_at->format('F d, Y') }}</p>
                        <a class="read-more" href="{{ route('portfolios.show', ['alias'=>$item->alias]) }}">&rarr; {{ (Config::get('app.locale') == 'ru') ? trans('ru.Read_more') : 'Read more'  }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endif

@if(count($comments) > 0)
    <div class="widget-last widget recent-comments">
        <h3>{{ (Config::get('app.locale') == 'ru') ? Lang::get('ru.recent_comments') : 'Recent Comments'}}</h3>
        <div class="recent-post recent-comments group">
            @foreach($comments as $comment)
            <div class="the-post group">

                    <div class="avatar">
                        @set($hash, ($comment->email) ? md5($comment->email) : $comment->user->email )
                        <img alt="" src="https://www.gravatar.com/avatar/{{$hash}}?d=mm&s=55" class="avatar" />
                    </div>
                        <!------------   -------------------- Якщо юзер зареестровагний то виводимо його імя, якщо ні то імя хто написав коммент -------->
                    <span class="author"><strong>{{ isset($comment->user) ? $comment->user->name : $comment->name  }}</strong> in</span>
                    <a class="title" href="{{ route('articles.show', ['alias'=>$comment->article->alias])  }}">{{ $comment->article->name }}</a>
                    <p class="comment">
                            {{ $comment->text }}
                         <a class="goto" href="{{ route('articles.show', ['alias'=>$comment->article->alias])  }}">&#187;</a>
                    </p>

            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>


