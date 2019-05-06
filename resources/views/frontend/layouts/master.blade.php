<!DOCTYPE html>
<html lang="en-US" class="wf-fontawesome-n4-active wf-active">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>{{ __('Tpl@ Cooking') }} - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('bower_components/SocialChef/css/icons.css') }}" type="text/css" media="screen">
    <link rel="stylesheet"  href="{{ asset('bower_components/SocialChef/css/style.css') }}" type="text/css" media="screen,projection,print">
    <link rel="stylesheet" href="{{ asset('bower_components/SocialChef/css/theme-default.css') }}" type="text/css" media="screen,projection,print">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/custom.css') }}">
    @yield('custom_css')
</head>

<body>
    @section('sidebar')
    <header class="head" role="banner">
        <!--wrap-->
        <div class="wrap clearfix">
            <a href="#" class="logo"><img src="{{ asset(config('manual.default_media.logo')) }}" alt="{{ __('Tpl@ Cooking') }}"></a>
            <!--primary navigation-->
            <nav id="nav" class="main-nav">
                <ul id="menu-primary">
                    <li>
                        <a href="#"><span>{{ __('Recipes') }}</span></a>
                    </li>
                    <li>
                        <a href="#"><span>{{ __('Categories') }}</span></a>
                        <ul class="sub-menu">
                            @foreach ($categories as $category)
                            <li>
                                <a href="{{ url($category->link) }}"><span>{{ $category->name }}</span></a>
                                @if (count($category->children) > 0)
                                <ul class="sub-menu">
                                    @foreach ($category->children as $child)
                                    <li><a href="{{ url($category->link . '/' . $child->link) }}"><span>{{ $child->name }}</span></a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="#"><span>{{ __('Community') }}</span></a>
                    </li>
                    <li><a href="#"><span>{{ __('Blog') }}</span></a>
                    </li>
                    <li><a href="#"><span>{{ __('Videos') }}</span></a>
                    </li>
                    @if (Auth::check())
                    <li class="user-info">
                        <a href=""><img src="{{ asset(config('manual.default_media.avatar.man')) }}" alt="avatar" width="60px" height="60px"></a>
                        <ul class="sub-menu">
                            <li><a href="">{{ __('Profile') }}</a></li>
                            <li><a href="">{{ __('Wish List') }}</a></li>
                            @if (Auth::user()->permission == config('manual.permission.admin'))
                            <li><a href="{{ route('users.index') }}"><span>{{ __('Go to Admin Page') }}</span></a></li>
                            @endif
                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a></li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </ul>
                    </li>
                    @endif
                </ul>
            </nav>
            <nav class="user-nav" role="navigation">
                <ul id="menu-primary">
                    <li class="light"><a href="#" title="Search for recipes"><i
                                class="icon icon-themeenergy_search"></i> <span>{{ __('Look for recipes') }}</span></a></li>
                    <li class="medium my-account">
                        @if (Auth::check())
                        <a href="#" title="My account"><i class="icon icon-themeenergy_chef-hat"></i>
                            <span>{{ __('Manage my recipes') }}</span>
                        </a>
                        @else
                        <a href="{{ route('login') }}" title="My account"><i class="icon icon-themeenergy_chef-hat"></i>
                            <span>{{ __('Sign Up') }}</span>
                        </a>
                        @endif
                    </li>
                    <li class="dark"><a href="#" title="Submit a recipe"><i class="icon icon-themeenergy_fork-spoon"></i> <span>{{ __('Submit a recipe') }}</span></a></li>
                </ul>
            </nav>
        </div>
        <!--//wrap-->
    </header>
    @show
    <main class="main" role="main">
        @yield('content')
    </main>
    @section('footer')
    <section class="cta">
        <div class="wrap clearfix">
            <a href="#"
                class="button big white right">{{ __('Contact Us') }}</a>
            <h2>{{ __('If you have any problems. Feel free to contact us. Tpl@ Cooking support 24/24') }}</h2>
        </div>
    </section>
    <!--//call to action-->
    <!--footer-->
    <footer class="foot" role="contentinfo">
        <div class="wrap clearfix">
            <div class="row">
                <div id="footer-sidebar" class="footer-sidebar widget-area clearfix" role="complementary">
                    <ul>
                        <li class="widget widget-sidebar">
                            <article class="about_widget clearfix one-half">
                                <h5>{{ __('About Tpl@ Cooking Community') }}</h5>
                            </article>
                        </li>
                        <li class="widget widget-sidebar">
                            <article class="sc_contact_widget one-fourth">
                                <h5>{{ __('Need help?') }}</h5>
                                <p>{{ __('Contact us via phone or email') }}</p>
                                <p><em>{{ __('Tel:') }}</em>{{ __(' 1-555-555-5555') }}<br><a href="#">{{ __('info@tplchef.com') }}</a></p>
                            </article>
                        </li>
                        <li class="widget widget-sidebar">
                            <article class="one-fourth">
                                <h5>Follow us</h5>
                                <ul class="social">
                                    <li><a href="http://www.facebook.com/"><i
                                                class="fa fa-fw fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="http://twitter.com/twitter" title="twitter"><i
                                                class="fa fa-fw fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="http://linkedin/" title="linkedin"><i class="fa fa-fw fa-linkedin"
                                                aria-hidden="true"></i></a></li>
                                    <li><a href="http://youtube/" title="youtube"><i class="fa fa-fw fa-youtube"
                                                aria-hidden="true"></i></a></li>
                            </article>
                        </li>
                    </ul>
                </div><!-- #secondary -->
                <div class="bottom">
                    <p class="copy">{{ __('© Tpl.com 2016. All rights reserved.') }}</p>
                    <!--footer navigation-->
                    <nav class="foot-nav">
                        <ul id="menu-footer" class="menu">
                            <li><a href="#">{{ __('Contact Us') }}</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!--//row-->
        </div>
        <!--//wrap-->
    </footer>
    <!--//footer-->
    @show

    @section('script')
    <!-- jQuery 3 -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }} "></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/toastr/toastr.js') }}"></script>
    @show
</body>

</html>
