<div class="pagination">
    @if($parametrs->lastPage() > 1)
<!----------------------PREV----------------------->
         @if($parametrs->currentPage() !== 1)
            <a href="{{ $parametrs->url($parametrs->currentPage() - 1) }}">{{ Lang::get('pagination.previous') }}</a>
         @endif
<!-------------------All pages-------------------------->
             @for($i = 1; $i <= $parametrs->lastPage(); $i++ )
                 @if($parametrs->currentPage()  == $i)
                        <a class="alert-danger">{{ $i }}</a>
                 @else
                    <a href="{{ $parametrs->url($i) }}">{{ $i }}</a>
                 @endif

             @endfor
<!-----------------------NEXt---------------------->
         @if($parametrs->currentPage() !== $parametrs->lastPage())
             <a href="{{ $parametrs->url($parametrs->currentPage() + 1) }}">{{ Lang::get('pagination.next') }}</a>
         @endif
    @endif

</div>
