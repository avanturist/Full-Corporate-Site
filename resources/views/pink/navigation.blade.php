@if($menu)
    <div class="menu classic" >
        <ul id="nav" class="menu">
            <!-- root() повертає батьківське меню -->
            @include(config('settings.theme').'.customMenuItems', ['items'=>$menu->roots()])
        </ul>
    </div>
@endif
