<nav class="navbar navbar-inverse">
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

</div>
@if($menu)
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
             @include(config('settings.theme').'.Admin./customMenu', ['items'=>$menu->roots()])
        </ul>
    </div>


@endif
</nav>
