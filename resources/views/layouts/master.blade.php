<!DOCTYPE html>
<html class="loading" lang="{{getLocale()}}" data-textdirection="ltr">
<head>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <title>@yield('page.name') | {{config('app.name')}}</title>

    <!-- Put your site keywords here... -->
    <meta name="keywords" content="{{config('app.keywords')}}">

    <!-- Put your description here... -->
    <meta name="description" content="{{config('app.description')}}">

    <!-- BEGIN FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{config('app.shortcut_icon') ?: asset('/images/icon/favicon.ico')}}">
    <!-- END FAVICON -->

    <!-- BEGIN FONT CSS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    <!-- END FONT CSS -->

    <!-- BEGIN APPLICATION CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
    <!-- END APPLICATION CSS-->

    <!-- BEGIN PAGE STYLESHEETS -->
    @stack('css')
    <!-- END PAGE STYLESHEETS -->

    @include('includes.scripts')

</head>
<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar"
      data-menu="vertical-menu" data-col="2-columns" data-open="click">

    <!-- BEGIN TOP SECTION -->
    @include('layouts.top')
    <!-- END TOP SECTION -->

    <!-- BEGIN MENU SECTION -->
    @include('layouts.menu')
    <!-- END MENU SECTION -->


    <div class="app-content content">
        <div class="content-wrapper" id="app">
            @yield('page.body')
        </div>
    </div>

    @hasanyrole('admin|moderator|super_moderator')
    @include('layouts.admin')
    @endhasanyrole

    <!-- BEGIN FOOTER SECTION -->
    @include('layouts.footer')
    <!-- END FOOTER SECTION -->

    <!-- BEGIN PRELOADER -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <!-- END PRELOADER -->

    <!-- BEGIN APPLICATION LIBRARIES -->
    <script src="{{asset('js/app.js')}}" type="text/javascript"></script>
    <!-- END APPLICATION LIBRARIES -->

    {!! toastr()->render() !!}
    @include('includes.toastr')

    <!-- BEGIN PAGE MiXIN -->
    @stack('mixins')
    <!-- END PAGE MIXIN -->

    <!-- BEGIN VUE INSTANCE -->
    <script src="{{asset('js/vue.js')}}" type="text/javascript"></script>
    <!-- END VUE INSTANCE -->

    <!-- BEGIN PAGE SCRIPTS -->
    @stack('scripts')
    <!-- END PAGE SCRIPTS -->

    <!-- BEGIN CUSTOM SCRIPTS -->
    <script type="text/javascript">
        function setOnline() {
            axios.put('{{route('ajax.profile.setOnline', ['user' => Auth::user()->name])}}');
        }

        function setAway() {
            axios.put('{{route('ajax.profile.setAway', ['user' => Auth::user()->name])}}');
        }

        $(document).ready(function () {
            setOnline();

            $(this).idle({
                onIdle: function () {
                    setAway();
                },

                onActive: function () {
                    setOnline();
                },

                idle: 1000 * 60
            })
        });
    </script>
    <!-- END CUSTOM SCRIPTS -->
</body>
</html>
