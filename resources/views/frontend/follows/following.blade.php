@extends('frontend.layouts.master')

@section('title', __('Following'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/general.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/profile/custom.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
@endsection

@section('content')

<div class="wrap clearfix">
    <!--breadcrumbs-->
    <nav role="navigation" class="breadcrumbs">
        <ul>
            <li><a href="{{ route('home') }}">'{{ __('Home') }}</a></li>
            <li>{{ __('Following') }}</li>
        </ul>
    </nav>
    <div class="row">
        <header class="s-title">
            <h1>{{ __('Following') }}</h1>
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
                                    <div class="wrap-follow-button">
                                        @if (Auth::user()->id !==  $user->id)
                                            @if ($followStatus != null)
                                            <form action="{{ route('follow.destroy', $followStatus->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="unfollow-button"><i class="fa fa-plus"></i> Unfollow</button>
                                            </form>
                                            @else
                                            <form action="{{ route('follow.store') }}" method="POST">
                                                {{ csrf_field() }}
                                                @if (Auth::check())
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <input type="hidden" name="user_id_follow" value="{{ Auth::user()->id }}">
                                                @endif
                                                <button class="follow-button"><i class="fa fa-plus"></i> Follow</button>
                                            </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                            </div><!-- #item-header-content -->

                        </div><!-- #item-header-cover-image -->
                    </div><!-- #cover-image-container -->
                    <div id="template-notices" role="alert" aria-atomic="true">
                    </div>
                    @if (Auth::user()->id == $user->id)
                    <!-- Modal edit avatar -->
                    <div class="modal fade in" id="modalAvatar" role="dialog">
                        <div class=" modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                    <h4 class="modal-title">
                                        {{ __('Update Avatar') }}
                                    </h4>
                                </div>
                                <div class="modal-body upload-avatar-form">
                                    <div class="wrap-upload">
                                        <div class="row">
                                            <a href="javascript:void(0)" id="attachfile">
                                                <div class="col-md-12 col-sm-12 col-sx-12 button-upload-avatar">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                    <span>{{ __('Upload Image') }}</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="row">
                                            <div class="wrap-image-upload">
                                                <div class="col-md-3 col-lg-3">
                                                </div>
                                                <div class="col-md-6 col-lg-6 image-upload">
                                                    @if (Auth::user()->avatar != null)
                                                    <img src="{{ asset('uploads/avatars/' . Auth::user()->avatar) }}"
                                                        class="avatar-round">
                                                    @else
                                                    <img src="{{ asset(config('manual.default_media.avatar.man')) }}"
                                                        class="avatar-round">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrap-upload-note">
                                            <span><b>{{ __('Note : ') }}</b>{{ __('Recommend picture size for image: height and width should be greater than 350px') }}</span>
                                        </div>
                                        <div class="form-upload-avatar">
                                            <form method="POST" action="{{ route('profile.avatar', Auth::user()->id) }}"
                                                enctype="multipart/form-data">
                                                {{ method_field('PUT') }}
                                                {{ csrf_field() }}
                                                <input id="edit_photo" name="avatar" type="file"
                                                    onchange="readImage(this)">
                                                <input type="hidden" name="avatar_old"
                                                    value="{{ Auth::user()->avatar }}">
                                                <input id="submit_photo" class="btn btn-success" type="submit"
                                                    value="Save">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end modal -->
                    @endif
                </div><!-- #item-header -->
                <div id="item-nav">
                    <div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
                        <ul>
                            <li id="xprofile-personal-li"><a id="user-xprofile"
                                    href="{{ route('profile.index', $user->id) }}">{{ __('Profile') }}</a></li>
                            @if (Auth::user()->id == $user->id)
                            <li id="notifications-personal-li"><a id="user-notifications"
                                    href="{{ route('notification.index') }}">{{ __('Notifications') }} <span
                                        class="no-count">{{ $notificationsNum }}</span></a></li>
                            @endif
                            <li id="friends-personal-li" class="current selected"><a id="user-friends" href="{{ route('following', $user->id) }}">{{ __('Following') }} <span
                                        class="no-count">{{ count($following) }}</span></a>
                            </li>
                            <li id="groups-personal-li"><a id="user-groups" href="{{ route('follower', $user->id) }}">{{ __('Follower') }}
                                    <span class="no-count">{{ count($follower) }}</span></a></li>
                        </ul>
                    </div>
                </div><!-- #item-nav -->

                <div id="item-body" role="main">
                    @foreach ($following as $follow)
                    <div class="follow-item">
                        @if ($follow->getUserBeFollow->avatar != null)
                        <a href="{{ route('profile.index', $follow->getUserBeFollow->id) }}">
                        <img src="{{ asset('uploads/avatars/' . $follow->getUserBeFollow->avatar) }}" class="avatar-round" alt="{{ $follow->getUserBeFollow->name }}">
                        </a>
                        
                        @else
                        <a href="{{ route('profile.index', $follow->getUserBeFollow->id) }}">
                            <img src="{{ asset(config('manual.default_media.avatar.man')) }}"
                                class="avatar-round">   
                        </a>
                        @endif
                        <span><a href="{{ route('profile.index', $follow->getUserBeFollow->id) }}">{{ $follow->getUserBeFollow->name }}</a></span><br>
                        @if (Auth::user()->id == $user->id)
                        <form action="{{ route('follow.destroy', $follow->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="unfollow-button" style="border: none !important;"></i> Unfollow</button>
                        </form>
                        @endif
                    </div>
                    @endforeach
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
