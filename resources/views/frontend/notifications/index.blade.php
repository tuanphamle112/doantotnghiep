@extends('frontend.layouts.master')

@section('title', __('Notifications'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/profile/custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/notifications/custom.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
@endsection

@section('content')

<div class="wrap clearfix">
    <!--breadcrumbs-->
    <nav role="navigation" class="breadcrumbs">
        <ul>
            <li><a href="{{ route('home') }}">'{{ __('Home') }}</a></li>
            <li>{{ __('Notifications') }}</li>
        </ul>
    </nav>
    <div class="row">
        <header class="s-title">
            <h1>{{ __('Notifications') }}</h1>
        </header>

        <!-- profile content -->
        <section class="content full-width">
            <!--container-->
            <article id="page-0">
                <div id="item-header" role="complementary">
                    <div id="cover-image-container">
                        <a id="header-cover-image" href="#"></a>
                        <div id="item-header-cover-image">
                            <div id="item-header-avatar">
                                <a href="#">
                                </a>
                            </div><!-- #item-header-avatar -->

                            <div id="item-header-content">
                                <div class="wrap-avatar">
                                    @if ($user->avatar != null)
                                    <img src="{{ asset('uploads/avatars/' . $user->avatar) }}" class="avatar-round">
                                    @else
                                    <img src="{{ asset(config('manual.default_media.avatar.man')) }}"
                                        class="avatar-round">
                                    @endif
                                    @if (Auth::user()->id == $user->id)
                                    <div class="edit-icon">
                                        <a href="#" data-toggle="modal" data-target="#modalAvatar">
                                            <i class="fa fa-pencil" aria-hidden="true"></i> {{ __('Edit') }}
                                        </a>
                                    </div>
                                    @endif
                                    <div class="star-num">
                                        <h2 class="user-nicename">{{ $user->name . ' (' . $user->star_num }} <i
                                                class="fa fa-star"></i>)</h2>
                                    </div>
                                </div>

                            </div><!-- #item-header-content -->

                        </div><!-- #item-header-cover-image -->
                    </div><!-- #cover-image-container -->
                    <div id="template-notices" role="alert" aria-atomic="true">
                    </div>
                </div><!-- #item-header -->
                <div id="item-nav">
                    <div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
                        <ul>
                            <li id="xprofile-personal-li"><a id="user-xprofile"
                                    href="{{ route('profile.index', $user->id) }}">{{ __('Profile') }}</a></li>
                            @if (Auth::user()->id == $user->id)
                            <li id="notifications-personal-li" class="current selected"><a id="user-notifications"
                                    href="{{ route('notification.index') }}">{{ __('Notifications') }} <span
                                        class="no-count">{{ $notificationsNum }}</span></a></li>
                            @endif
                            <li id="friends-personal-li"><a id="user-friends" href="#">{{ __('Following') }} <span
                                        class="no-count">0</span></a>
                            </li>
                            <li id="groups-personal-li"><a id="user-groups" href="#">{{ __('Follower') }}
                                    <span class="no-count">0</span></a></li>
                        </ul>
                    </div>
                </div><!-- #item-nav -->

                <div id="item-body" role="main">
                    <div class="item-list-tabs no-ajax" id="subnav" aria-label="Member secondary navigation">
                        <ul class="tab">
                            <li id="public-personal-li"><a href="#unread">{{ __('Unread') }}</a>
                            </li>
                            <li id="edit-personal-li"><a id="edit" href="#all">{{ __('All') }}</a>
                            </li>
                        </ul>
                    </div><!-- .item-list-tabs -->
                    <div class="tab-content">

                        <div class="profile tab-item" id="unread">
                            @if ($notificationsNum <= 0)
                            <div id="message" class="info">
                                <p>You have no unread notifications.</p>
                            </div>
                            @else
                                @foreach ($unreadNotifications as $notification)
                                    <div class="confirm-item confirm-gift">
                                        <img src="{{ asset('uploads/recipes/' . $notification->data['image']) }}">
                                        <div class="gift-info">
                                            <span><b>Your recipes status has been changed to
                                                @if ($notification->data['status'] == config('manual.recipe_status.Pending'))
                                                    <span class="label label-warning">{{ __('Pending') }}</span>
                                                @elseif ($notification->data['status'] == config('manual.recipe_status.Actived'))
                                                    <td><span class="label label-success">{{ __('Actived') }}</span></td>
                                                @else
                                                    <td><span class="label label-danger">{{ __('Reject') }}</span></td>
                                                @endif
                                            </b></span>
                                            <p>This notification let you know that admin has been taken an action on your recipes.</p>
                                            <a href="{{ url('/recipe/' . changeLink($notification->data['name']) . '/' . $notification->data['id']) }}">Let's check it out</a>
                                            <span class="time-taken">Action taken at: <b>{{ $notification->updated_at }}</b></span>
                                        </div>
                                    </div>
                                @endforeach
                                {{ $unreadNotifications->links() }}

                            @endif
                        </div><!-- .profile -->
                        <div class="tab-item" id="all">
                            @if (count($notifications) <= 0)
                            <div id="message" class="info">
                                <p>You have no notifications.</p>
                            </div>
                            @else
                                @foreach ($notifications as $notification)
                                <div class="confirm-item confirm-gift">
                                    <img src="{{ asset('uploads/recipes/' . $notification->data['image']) }}">
                                    <div class="gift-info">
                                        <span><b>Your recipes status has been changed to
                                            @if ($notification->data['status'] == config('manual.recipe_status.Pending'))
                                                <span class="label label-warning">{{ __('Pending') }}</span>
                                            @elseif ($notification->data['status'] == config('manual.recipe_status.Actived'))
                                                <td><span class="label label-success">{{ __('Actived') }}</span></td>
                                            @else
                                                <td><span class="label label-danger">{{ __('Reject') }}</span></td>
                                            @endif
                                        </b></span>
                                        <p><a href="{{ url('/recipe/' . changeLink($notification->data['name']) . '/' . $notification->data['id']) }}">Let's check it out</a></p>
                                        <span>Action taken at: <b>{{ $notification->updated_at }}</b></span>
                                    </div>
                                </div>
                                @endforeach
                                {{ $notifications->links() }}

                            @endif

                        </div>
                    </div>

                </div>
            </article>
            <!--//container-->
        </section>
        <!-- end profile content -->
    </div>
    <!--//row-->
</div>

@endsection

@section('script')
@parent
<script src="{{ asset('messages.js') }}"></script>
<script src="{{ asset('js/frontend/profile/my-profile.js') }}"></script>
<script src="{{ asset('bower_components/jquery-highlight/jquery.highlight.js') }}"></script>
@endsection
