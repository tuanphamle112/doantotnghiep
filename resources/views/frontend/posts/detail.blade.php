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

        </section>
        <!--//hentry-->

    </div>
    <!--//row-->
</div>
<!--//wrap-->
@endsection

@section('script')
@parent

@endsection
