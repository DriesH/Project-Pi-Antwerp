<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Welkom | Project | Antwerpen.be</title>

        <!-- BOOTSTRAP & FONT-AWESOME -->
        <link rel="shortcut icon" href="/pictures/favicon/favicon-32x32.png" type="image/png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css"/>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="/css/bootstrap-datepicker3.standalone.min.css" type="text/css">
        <!-- FONTS -->
        <link rel="stylesheet" href="/fonts/Antwerpen-Regular.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="/fonts/Sun-Antwerpen.css" media="screen" title="no title" charset="utf-8">
        <!-- PAGE LAYOUT -->
        <link rel="stylesheet" href="/css/master.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="/css/nav-bar.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="/css/project-box.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="/css/project-page.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="/css/carousel.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="/css/admin-panel.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="/css/dashboard-user.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="/css/fases.css" media="screen" title="no title" charset="utf-8">
        <!-- FUNCTIONAL CSS -->
        <link rel="stylesheet" href="/css/vertical-timeline-css.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="/css/slick-theme.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="/css/grid-layout.css" media="screen" title="no title" charset="utf-8">
    </head>
    <body>

        <nav class="navbar navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#inlog-field">
                        <span class="fa fa-bars"></span>
                    </button>
                    <a href="/" class="navbar-brand">
                        <img src="/pictures/a-logo.svg" alt="a-logo" />
                    </a>
                    <ul class="nav navbar-nav navbar-left">
                        <li><a id="page-title" href="/"><h1> Projecten</h1></a></li>

                    </ul>
                </div>

                <a href="#"><img id="mascot-styling" src="/pictures/mascot.png" alt="mascot-van-de-website" />
                    <p>
                        speel de app!
                    </p>
                </a>
                

                <div class="collapse navbar-collapse" id="inlog-field">

                    <ul class="nav navbar-nav navbar-right dropdown" id="navbar-login">
                        @if (Auth::guest())
        					<li><a href="/auth/register"><i class="fa fa-pencil-square-o"></i>Registreren</a></li>
        					<li><a href="/auth/login"><i class="fa fa-sign-in"></i>Inloggen</a></li>
        				@else
    					    <li><a id="welkom" href="/dashboard"><i class="fa fa-user"></i>{{ Auth::user()->name }}</a></li>
                            @if (!Auth::guest() && Auth::user()->role == 10)
                                <li><a href="/admin"><i class="fa fa-cog"></i>Admin panel</a></li>
                            @endif
                                <li class="afmelden"><a href="/auth/logout">Afmelden<i class="fa fa-sign-out"></i></a></li>
                		@endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container" id="content">
            @yield('content')
        </div>

        <!-- JQUERY & plugins -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkN_qoobIjk7OOThbtXZAP4axJuTZOZ4E&region=BE&language=nl&callback=window.initMap" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js"></script>

        <script src="/js/readmore.min.js"></script>
        <script src="/js/salvatorre.min.js" charset="utf-8"></script>
        <script src="/js/modernizr.js" charset="utf-8"></script>

        <script src="/js/bootstrap-datepicker.min.js" charset="utf-8"></script>
        <script src="/js/bootstrap-datepicker.nl-BE.min.js" charset="utf-8"></script>
        <script src="/js/datepicker.js" charset="utf-8"></script>

        <script src="/js/main.js" charset="utf-8"></script>
        <script src="/js/google-maps-main.js" charset="utf-8"></script>
        <script src="/js/basic-javascript-anim.js" charset="utf-8"></script>

    </body>
</html>
