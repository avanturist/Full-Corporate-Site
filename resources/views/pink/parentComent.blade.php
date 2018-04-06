@foreach($items as $comment)

    <li id="li-comment-{{ $comment->id }}" class="comment even {{ ($comment->user_id == $one_artic->user_id) ? 'bypostauthor odd' : ''}} ">

        <div id="comment-{{$comment->id }}" class="comment-container">
            <div class="comment-author vcard">
                @set($person, isset($comment->email) ? md5($comment->email): md5($comment->user->email))
                <img alt="" src="https://www.gravatar.com/avatar/{{ $person }}?d=mm&s=55" class="avatar" height="75" width="75" />
                <cite class="fn">{{ ($comment->name) ? $comment->name : $comment->user->name }}</cite>
            </div>
            <!-- .comment-author .vcard -->
            <div class="comment-meta commentmetadata">
                <div class="intro">
                    <div class="commentDate">
                        <a href="#comment-{{$comment->id}}">
                            {{ is_object($comment->created_at) ? $comment->created_at->format('F d, Y \a\t h:i a') : '' }}
                        </a>
                    </div>
                    <div class="commentNumber"># </div>
                </div>
                <div class="comment-body">
                    <p>{!! $comment->text !!}</p>
                </div>
                <div class="reply group">
                    <a class="comment-reply-link" href="#respond" onclick="return addComment.moveForm(&quot;comment-{{$comment->id}}&quot;, &quot;{{$comment->id}}&quot;, &quot;respond&quot;, &quot;{{$comment->article_id}}&quot;)" >Reply</a>

                </div>
                <!-- .reply -->
            </div>
            <!-- .comment-meta .commentmetadata -->
        </div>
        <!-- #comment-##  -->

        <!-- ДОЧЕРНІ КОМЕНТИ-ОТВЕТИ  -->

        @if(isset($com[$comment->id]))
           {{-- {{ $com[$comment->id] }}--}}
            <ul>
                <li class="children" style="list-style: none; margin: 20px">
                    {{--рекурсивний визов --}}
                    @include(config('settings.theme').'.parentComent', ['items'=>$com[$comment->id]])
                </li>
            </ul>
        @endif
    </li>
@endforeach