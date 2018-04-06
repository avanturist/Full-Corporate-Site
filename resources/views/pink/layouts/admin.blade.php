<!DOCTYPE html>
<!-- START HEAD -->
<head>

    <meta charset="UTF-8" />
    <!-- this line will appear only if the website is visited with an iPad -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.2, user-scalable=yes" />
    <meta name="description" content="{!! $meta_desc or 'mets_desc' !!}">
    <meta name="keywords" content="{!! $keywords or 'keywords' !!}">
    <meta name="author" content="{!! $author or 'author' !!}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{!!  $title or 'MySite' !!}</title>

    <!-- [favicon] begin -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(config('settings.theme')) }}/images/contribute.png" />

    <!-- Latest compiled and minified CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- CSSs -->
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme'))}}/css/reset.css" /> <!-- RESET STYLESHEET -->
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/style.css" /> <!-- MAIN THEME STYLESHEET -->
    <link rel="stylesheet" id="max-width-1024-css" href="{{ asset(config('settings.theme')) }}/css/max-width-1024.css" type="text/css" media="screen and (max-width: 1240px)" />
    <link rel="stylesheet" id="max-width-768-css" href="{{ asset(config('settings.theme')) }}/css/max-width-768.css" type="text/css" media="screen and (max-width: 987px)" />
    <link rel="stylesheet" id="max-width-480-css" href="{{ asset(config('settings.theme')) }}/css/max-width-480.css" type="text/css" media="screen and (max-width: 480px)" />
    <link rel="stylesheet" id="max-width-320-css" href="{{ asset(config('settings.theme')) }}/css/max-width-320.css" type="text/css" media="screen and (max-width: 320px)" />

    <!-- CSSs Plugin -->
   <link rel="stylesheet" id="thickbox-css" href="{{ asset(config('settings.theme')) }}/css/thickbox.css" type="text/css" media="all" />
    <link rel="stylesheet" id="styles-minified-css" href="{{ asset(config('settings.theme')) }}/css/style-minifield.css" type="text/css" media="all" />
    <link rel="stylesheet" id="buttons" href="{{ asset(config('settings.theme')) }}/css/buttons.css" type="text/css" media="all" />
    <link rel="stylesheet" id="cache-custom-css" href="{{ asset(config('settings.theme')) }}/css/cache-custom.css" type="text/css" media="all" />
    <link rel="stylesheet" id="custom-css" href="{{ asset(config('settings.theme')) }}/css/custom.css" type="text/css" media="all" />

   {{-- <link rel="stylesheet" href="{{  asset(config('settings.theme')) }}/jQuery-widgets/jquery-ui.css">--}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>
<!-- END HEAD -->

<!-- START BODY -->
<body class="no_js responsive stretched">

<!-- START BG SHADOW -->
<div class="bg-shadow">

    <!-- START WRAPPER -->
    <div id="wrapper" class="group">

        <!-- START HEADER -->
        <div id="header" class="group">

            <div class="group inner">
                <div id="sidebar-header" class="group">
                    <div  style="float:right; margin-right: 30px">
                        <a href="?locale=en">en</a> |
                        <a href="?locale=ru">ru</a>
                    </div>
                </div>

                <!-- START LOGO -->
                <div id="logo" class="group">
                    @if(url()->current() == url('/login'))
                        <h1>{!! link_to('/login', 'Вход в Админку') !!}</h1>
                    @elseif(url()->current() == url('/registration'))
                        <h1>{!! link_to('/registration', 'Регистрация') !!}</h1>
                    @else
                        <h1>{!! link_to('/admin', 'Панель Администратора') !!}</h1>
                    @endif


                </div>
                <!-- END LOGO -->

                <div id="sidebar-header" class="group">

                    {{--<div class="yit_text_quote dropdown" >
                        <a class="dropdown-toggle" id="menu1" data-toggle="dropdown">LogOut
                         <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu logout" aria-labelledby="menu1">
                            <li><a href="{{ url('/logout') }}"  >Выйти</a></li>
                        </ul>
                    </div>--}}

                </div>
                <div class="clearer"></div>

                <hr />

                <!-- START MAIN NAVIGATION -->

                    @yield('navigation')


            <!-- END MAIN NAVIGATION -->

            </div>

        </div>
        <!-- END HEADER -->



        <!-- START PRIMARY -->
        <div id="primary" class="sidebar-{!! isset($bar) ? $bar: 'no' !!}">
            <div class="inner group">
                <!-- START CONTENT -->

                <!---PORTFOLIO-->
            @yield('content')
            <!--/PORTFOLIO-->

                <!-- END CONTENT -->

            </div>
        </div>
        <!-- END PRIMARY -->

        <!-- START COPYRIGHT -->
        <div id="copyright">
            @yield('footer')
        </div>
        <!-- END COPYRIGHT -->
    </div>
    <!-- END WRAPPER -->
</div>
<!-- END BG SHADOW -->




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

{{--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
<script src="{{ asset(config('settings.theme')) }}/ckeditor_4.9.0_full/ckeditor/ckeditor.js"></script>
<script src="{{ asset(config('settings.theme')) }}/jQuery-widgets/jquery-ui.js"></script>
<script type="text/javascript" src="{{ asset(config('settings.theme')) }}/js/bootstrap-filestyle.min.js"></script>

<script>
        CKEDITOR.replace('text');
        CKEDITOR.replace('desc');

</script>
<script>
   $(function() {
        $( "#accordion" ).accordion()
   });
</script>




</body>
<!-- END BODY -->
</html>