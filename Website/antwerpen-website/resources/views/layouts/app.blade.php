<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Welkom | Project | Antwerpen.be</title>

        <!-- BOOTSTRAP & FONT-AWESOME -->
        <link rel="shortcut icon" href="/pictures/favicon/favicon-32x32.png" type="image/png">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css">
        <!-- FONTS -->
        <link rel="stylesheet" href="/fonts/Antwerpen-Regular.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="/fonts/Sun-Antwerpen.css" media="screen" title="no title" charset="utf-8">
        <!-- PAGE LAYOUT -->
        <link rel="stylesheet" href="/css/master.css" media="screen" title="no title" charset="utf-8">
    </head>
    <body>

        <nav class="navbar navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#inlog-field">
                        <span class="fa fa-bars burger-menu"></span>
                    </button>
                    <a href="/" class="navbar-brand">
                        <img src="/pictures/a-logo.svg" alt="a-logo" />
                    </a>
                    <ul class="nav navbar-nav navbar-left">
                        <li><a id="page-title" href="/"><h1> Projecten</h1></a></li>
                    </ul>
                </div>

                <div class="collapse navbar-collapse" id="inlog-field">
                    <ul class="nav navbar-nav navbar-right" id="navbar-login">
                            <li class="speel-app"><a href="/applicatie-uitleg">Ontdek de app! <img id="mascot-styling" src="/pictures/mascot.png" alt="mascot-van-de-website" /></a></li>
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
        <script src="/js/jquery-2.2.4.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>

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
