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
        <div>
            <header class="s-title">
                <h1 itemprop="name" class="entry-title">{{ $post->name }}</h1>
            </header>
            <!--content-->
            <section class="content three-fourth">
                <!--recipe-->
                <article class="recipe">
                    <div class="row">
                        <!--two-third-->
                        <div class="two-third">
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
                    </div>
                    <!--//row-->
                </article>
                <!--//recipe-->

                <!--comments-->

                <!--comments-->
                <!--//recipe entry-->
            </section>
        </div>
        <!--//hentry-->
    </div>
    <!--//row-->
</div>
<!--//wrap-->
@endsection

@section('script')
@parent

@endsection
