@extends('frontend.layouts.master')

@section('title', __('Detail Post'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/detail.css') }}">
@endsection

@section('content')

<div class="wrap clearfix">
    <!--breadcrumbs-->
    <nav role="navigation" class="breadcrumbs">
        <ul>
            <li><a href="{{ route('home') }}" title="Home">{{ __('Home') }}</a></li>
            <li>{{ $post->title }}</li>
        </ul>
    </nav>
    <div class="row">
        <header class="s-title">
            <h1 itemprop="name" class="entry-title">{{ $post->title }}</h1>
        </header>
        <!--content-->
        <section class="content three-fourth">
            <!--recipe-->
            <article class="recipe">
                <div class="row">
                    <!--two-third-->
                    <div class="two-third" style="width: 70%">
                        <div class="image">
                            @if ($post->image != null)
                            <img src="{{ asset(config('manual.posts_url') . $post->image) }}" class="main-img"
                                alt="{{ $post->name }}">
                            @else
                            <img src="{{ config('manual.default_media.recipe') }}" class="main-img"
                                alt="{{ $post->name }}">
                            @endif
                        </div>
                        <div class="intro">
                            <p><strong>{{ $post->description }}</strong></p>
                        </div>
                        <div class="wrap-post-content">
                            <p>{!! $post->content !!} </p>
                        </div>
                    </div>
                    <!--//two-third-->
                    <!-- right side -->
                    
                    <aside id="secondary-right" class="right-sidebar sidebar widget-area one-fourth"
                        role="complementary">
                        <dl class="basic user-data">
                            <dd class="vcard author post-author user-avt-post" style="width:100% !important">
                                <span class="fn">
                                    <a href="{{ route('profile.index', $post->user->id) }}">
                                        @if ($post->user->avatar != null)
                                        <img src="{{ asset('uploads/avatars/' . $post->user->avatar) }}">
                                        @else
                                        <img src="{{ asset(config('manual.default_media.avatar.man')) }}">
                                        @endif

                                        &nbsp;{{ $post->user->name }}&nbsp;{{ "(" . $post->user->star_num . ")" }}
                                    </a>
                                </span>
                            </dd>
                            <dd class="post-date updated" style="width:100% !important">{{ $createdAtPost }}
                            </dd>
                    </dl>
                        <ul>
                            <li class="widget widget-sidebar">
                                <!--cwrap-->
                                <div class="cwrap">
                                    <h5>{{ __('Popular Posts') }}</h5>
                                    <ul class="articles_latest">
                                        @foreach ($porpularPost as $rightPost)
                                        <li>
                                            <a href="{{ route('posts.show', $rightPost->id) }}">
                                                <img src="{{ asset(config('manual.posts_url') . $rightPost->image) }}"
                                                    alt="{{ $rightPost->title }}">
                                                <h6>{{ $rightPost->title }}</h6>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!--//cwrap-->
                            </li>
                            <li class="widget widget-sidebar">
                                <div class="textwidget"><a href="#" style="margin:0 -20px;float:left;"><img src=""></a>
                                </div>
                            </li>
                        </ul>
                    </aside>
                    <!-- End right side -->
                </div>
                <!--//row-->
            </article>
            <!--//recipe-->

            <!--comments-->
            <div class="comments" id="comments" itemprop="interactionCount" content="UserComments:2">
                @if ($comments->count() > 0)
                <h2> {{ $comments->count() . __(' comments') }}</h2>
                <ol class="comment-list">
                    <!--single comment-->
                    @foreach ($comments as $comment)
                    <li class="comment clearfix">
                        <div class="avatar">
                            <img alt="" src="{{ asset('uploads/avatars/' . $comment->user->avatar) }}"
                                class="avatar avatar-90 photo" height="90" width="90">
                        </div>
                        <div class="comment-box">
                            <div class="comment-author meta">
                                <strong><a href="{{ route('profile.index', $comment->user->id) }}"
                                        class="url">{{ $comment->user->name }}</a></strong><br>
                                {{ $comment->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a') }}
                                @if (Auth::check())
                                @if ($comment->user->id == Auth::user()->id);
                                <div class="wrap-delete-form">
                                    <div class="wrap-comment-button">
                                        <a class="comment-reply-link edit" href="#">Edit</a>
                                        <a class="comment-reply-link delete"
                                            data-text="{{ __('Do you want to delete this comment?') }}"
                                            href="#">Delete</a>
                                        <form class="delete-form" action="{{ route('comment.delete', $comment->id) }}"
                                            method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <div class="form-group">
                                                <input type="hidden" name="comment_type" id="comment-type" value="post">
                                                <input type="submit" class="btn btn-danger">
                                            </div>
                                        </form>
                                    </div>
                                    <!-- show when edit comment -->
                                    <div class="wrap-open-edit">
                                        <a class="comment-reply-link save-comment" href="#">Save</a>
                                        <a class="comment-reply-link cancel-comment" href="#">Cancel</a>
                                    </div>
                                </div>
                                @else
                                <a class="comment-reply-link reply" data-owner-comment="{{ $comment->user->name }}"
                                    href="#">Reply</a>
                                @endif
                                @endif
                            </div>
                            <div class="comment-text">
                                <p class="comment-view">{{ $comment->content }}</p>
                                @if (Auth::check() && Auth::user()->id == $comment->user->id)
                                <form action="{{ route('comment.edit', $comment->id) }}" name="edit_comment"
                                    class="edit-comment-form" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="f-row">
                                        <textarea name="content_edited" rows="10"
                                            cols="10">{{ $comment->content }}</textarea>
                                    </div>
                                    <button class="submit-edit-comment" style="display:none">Submit</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </li>
                    @endforeach
                    <!--//single comment-->
                </ol>
                @endif

                <div id="respond" class="comment-respond">
                    <h3 id="reply-title" class="comment-reply-title">{{ __('Leave a Reply ') }}</h3>
                    <form data-post="{{ route('comment.store', $post->id) }}" @if (Auth::check())
                        data-user-link="{{ route('profile.index', Auth::user()->id) }}" @endif id="commentform"
                        class="comment-form">
                        <div class="container">
                            @if (Auth::check())
                            <p>{{ __('Logged in as') }} <a
                                    href="{{ route('profile.index', Auth::user()->id) }}">{{ Auth::user()->name }}</a>
                            </p>
                            <div class="f-row">
                                <textarea id="comment" name="comment" rows="10" cols="10"></textarea>
                            </div>
                            <div class="filling-error">{{ __('Comment field are require') }}</div>
                            <p class="form-submit"><input name="submit" type="submit" class="submit"
                                    value="Post Comment">
                                
                            </p>
                            @else
                            <p>{{ __('You have to') }} <a href="{{ route('login') }}">{{ __('login') }}</a>
                                {{ __('to leave a comment') }}</p>
                            @endif
                        </div>
                    </form>
                </div><!-- #respond -->
                <!--//post comment form-->
            </div>
            <!--comments-->

        </section>
        <!--//hentry-->

    </div>
    <!--//row-->
</div>
<!--//wrap-->
@endsection

@section('script')
@parent
<script src="{{ asset('js/frontend/posts/detail.js') }}"></script>
@endsection
