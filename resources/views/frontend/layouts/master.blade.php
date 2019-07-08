<!DOCTYPE html>
<html lang="en-US" class="wf-fontawesome-n4-active wf-active">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <title>{{ __('Tpl@ Cooking') }} - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('bower_components/SocialChef/css/icons.css') }}" type="text/css"
        media="screen">
    <link rel="stylesheet" href="{{ asset('bower_components/SocialChef/css/style.css') }}" type="text/css"
        media="screen,projection,print">
    <link rel="stylesheet" href="{{ asset('bower_components/SocialChef/css/theme-default.css') }}" type="text/css"
        media="screen,projection,print">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/custom.css') }}">

    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">
    @yield('custom_css')
</head>

<body>
    @section('sidebar')
    <header class="head" role="banner">
        <!--wrap-->
        <div class="wrap clearfix">
            <a href="{{ route('home') }}" class="logo"><img src="{{ asset(config('manual.default_media.logo')) }}"
                    alt="{{ __('Tpl@ Cooking') }}"></a>
            <!--primary navigation-->
            <nav id="nav" class="main-nav">
                <ul id="menu-primary">
                    <li>
                        <a href="{{ route('list-recipe.index') }}"><span>{{ __('Recipes') }}</span></a>
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
                                    <li><a
                                            href="{{ url($category->link . '/' . $child->link) }}"><span>{{ $child->name }}</span></a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{ route('posts.index') }}"><span>{{ __('Posts') }}</span></a>
                    </li>
                    <li><a href="{{ route('gift.list') }}"><span>{{ __('Gifts') }}</span></a>
                    </li>
                    @if (Auth::check())
                    <li class="wrap-noti">
                        <a href="javascript:void(0)" class="notification">
                            <span>Notifications</span>
                            <span class="badge">{{ $dataNoti['unreadNum'] }}</span>
                        </a>
                        <ul class="sub-menu notification-ul">
                            @if (count($dataNoti['notifications']) == 0) 
                                <li>You have no notifications</li>
                            @else
                                @foreach ($dataNoti['notifications'] as $noti)
                                    @if ($noti->type == 'App\Notifications\RecipeNotification')
                                    <li class="noti-item @if ($noti->read_at == null) unread @endif">
                                        <small style="padding-left: 10px; color: #999">Recipe</small>
                                        <a href="{{ route('notification.show', $noti->id) }}">
                                            <span style="margin-bottom: 15px;">Your recipes status has been changed to
                                                @if ($noti->data['status'] == config('manual.recipe_status.Pending'))
                                                    <b style="color: yellow !important">{{ __('Pending') }}</b>
                                                @elseif ($noti->data['status'] == config('manual.recipe_status.Actived'))
                                                    <b style="color: green !important">{{ __('Actived') }}</b>
                                                @else
                                                    <b  style="color: red !important">{{ __('Reject') }}</b>
                                                @endif
                                            </span>
                                            <span class="time-taken">{{ $noti->updated_at }}</span>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($noti->type == 'App\Notifications\PostNotification')
                                    <li class="noti-item @if ($noti->read_at == null) unread @endif">
                                        <small style="padding-left: 10px; color: #999">Post</small>
                                        <a href="{{ route('notification.show', $noti->id) }}">
                                            <span style="margin-bottom: 15px;">Your posts status has been changed to
                                                @if ($noti->data['status'] == config('manual.post_status.Pending'))
                                                    <b style="color: yellow !important">{{ __('Pending') }}</b>
                                                @elseif ($noti->data['status'] == config('manual.post_status.Actived'))
                                                    <b style="color: green !important">{{ __('Actived') }}</b>
                                                @else
                                                    <b  style="color: red !important">{{ __('Reject') }}</b>
                                                @endif
                                            </span>
                                            <span class="time-taken">{{ $noti->updated_at }}</span>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($noti->type == 'App\Notifications\GiftNotification')
                                    <li class="noti-item @if ($noti->read_at == null) unread @endif">
                                        <small style="padding-left: 10px; color: #999">Gift</small>
                                        <a href="{{ route('notification.show', $noti->id) }}">
                                            <span style="margin-bottom: 15px;">
                                                    You changed <b>{{ $noti->data['star_point'] }}</b>
                                                    <i class="fa fa-star"></i>
                                                    with <b>{{$noti->data['name']}}</b>. 
                                                    @if (isset($noti->data['status']))
                                                        We've shipped it already.
                                                    @else
                                                        Please wait while we processing your exchange!
                                                    @endif

                                            </span>
                                            <span class="time-taken">{{ $noti->updated_at }}</span>
                                        </a>
                                    </li>
                                    @endif
                                @endforeach
                                <li class="li-bottom"><a href="{{ route('notification.index') }}">See all notifications</a></li>
                            @endif
                            
                        </ul>
                    </li>
                    @endif
                    @if (Auth::check())
                    <li class="user-info">
                        @if (Auth::user()->avatar != null)
                        <a href="{{ route('profile.index', Auth::user()->id) }}"><img
                                src="{{ asset('uploads/avatars/' . Auth::user()->avatar) }}" alt="avatar" width="60px"
                                height="60px"></a>
                        @else
                        <a href="{{ route('profile.index', Auth::user()->id) }}"><img
                                src="{{ asset(config('manual.default_media.avatar.man')) }}" alt="avatar" width="60px"
                                height="60px"></a>
                        @endif
                        <ul class="sub-menu">
                        <i class="fa fa-medal"></i>
                            <li class="star-num">
                                <span>Your stars :</span> &nbsp;
                                  {{ Auth::user()->star_num }} <i class="fa fa-star"></i>
                            </li>
                            <li><a href="{{ route('profile.index', Auth::user()->id) }}">{{ __('Profile') }}</a></li>
                            <li><a href="{{ route('wishlist.index') }}">{{ __('Wish List') }}</a></li>
                            <li><a href="{{ route('posts.create') }}">{{ __('Create A Post') }}</a></li>
                            <li><a href="{{ route('my-posts.index') }}">{{ __('Manage My Posts') }}</a></li>
                            @if (Auth::user()->permission == config('manual.permission.admin'))
                            <li><a href="{{ route('users.index') }}"><span>{{ __('Go to Admin Page') }}</span></a></li>
                            @endif
                            <li><a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            </li>

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
                    <li class="light"><a href="{{ route('search.index') }}" title="Search for recipes"><i
                                class="icon icon-themeenergy_search"></i> <span>{{ __('Look for recipes') }}</span></a>
                    </li>
                    <li class="medium my-account">
                        @if (Auth::check())
                        <a href="{{ route('my-recipe.index') }}" title="My Recipe"><i
                                class="icon icon-themeenergy_chef-hat"></i>
                            <span>{{ __('Manage my recipes') }}</span>
                        </a>
                        @else
                        <a href="{{ route('login') }}" title="My account"><i class="icon icon-themeenergy_chef-hat"></i>
                            <span>{{ __('Sign Up') }}</span>
                        </a>
                        @endif
                    </li>
                    <li class="dark"><a href="{{ route('form.name') }}"><i class="icon icon-themeenergy_fork-spoon"></i>
                            <span>{{ __('Submit a recipe') }}</span></a></li>
                </ul>
            </nav>
        </div>
        <!--//wrap-->
    </header>
    @show
    <main class="main" role="main">
        @yield('content')
    </main>
    @yield('contact')
    @section('footer')

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
                                <p><em>{{ __('Tel:') }}</em>{{ __(' 1-555-555-5555') }}<br><a
                                        href="#">{{ __('info@tplchef.com') }}</a></p>
                            </article>
                        </li>
                        <li class="widget widget-sidebar">
                            <article class="one-fourth">
                                <h5>Follow us</h5>
                                <ul class="social">
                                    <li><a href="http://www.facebook.com/"><i class="fa fa-fw fa-facebook"
                                                aria-hidden="true"></i></a></li>
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
    <input type="hidden" class="toastr-session"
        data-session="{{ Session::has('message') . ',' . Session::get('alert-type', 'info') . ',' . Session::get('message') }}">
    <!--//footer-->
    @show

    @section('script')
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }} "></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/frontend/master.js') }}"></script>
    <script src="{{ asset('bower_components/toastr/toastr.js') }}"></script>
    @show
</body>

</html>
