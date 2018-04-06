@foreach($items as $item)
    <li {{ (URL::current() == $item->url()) ? 'class=active' : '' }}>
        <!-- url()повертає адресу пункта меню -->
        <a href="{{ $item->url() }}">{{ $item->title }}</a>
        <!--Умова якщо у пункта меню є дочірні пункти-->
        @if($item->hasChildren() )
            <ul class="sub-menu">
                @include(config('settings.theme'). '.customMenuItems', ['items'=>$item->children()])
            </ul>
        @endif

    </li>


@endforeach
