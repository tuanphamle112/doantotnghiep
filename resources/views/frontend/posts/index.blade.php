@extends('frontend.layouts.master')

@section('title', __('My recipe'))

@section('custom_css')
<!-- <link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/categories.css') }}"> -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
@endsection

@section('content')

<div class="wrap clearfix">
    <!--breadcrumbs-->
    <nav role="navigation" class="breadcrumbs">
        <ul>
            <li><a href="{{ route('home') }}">'{{ __('Home') }}</a></li>
            <li>{{ __('Posts') }}</li>
        </ul>
    </nav>
    <div class="row">
        <header class="s-title">
            <h1>{{ __('Posts') }}</h1>
        </header>
        <section class="content full-width">
            <div class="entries row">
                <!--item-->
                @foreach ($allPostActive as $post)
                <div class="entry one-fourth recipe-item">
                    <figure>
                        @if ($post->image != null)
                        <img src="{{ asset(config('manual.posts_url') . $post->image) }}">
                        @else
                        <img src="{{ config('manual.default_media.recipe') }}" alt="{{ $post->title }}">
                        @endif
                        <figcaption><a href="{{ route('posts.show', $post->id) }}"><i
                                    class="icon icon-themeenergy_eye2"></i><span>{{ __('View post') }}</span></a>
                        </figcaption>
                    </figure>
                    <div class="container">
                        <h2>
                            <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                        </h2>
                        <div class=" actions">
                            <div>
                                <div class="date"><i class="fa fa-calendar"
                                        aria-hidden="true"></i>{{ $post->created_at->format('Y-m-d H:s') }}</div>
                                <div class="comments"><i class="fa fa-comment" aria-hidden="true"></i><a
                                        href="">{{ count($post->comments) }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="excerpt">
                            <p>{{ $post->description }}</p>
                        </div>
                        {{ $allPostActive->links() }}
                    </div>
                </div>
                @endforeach
                <!--item-->
            </div>

        </section>
    </div>
    <!--//row-->
</div>

@endsection

@section('script')
@parent
<script src="{{ asset('messages.js') }}"></script>
<script src="{{ asset('js/frontend/recipes/categories.js') }}"></script>
<script src="{{ asset('bower_components/jquery-highlight/jquery.highlight.js') }}"></script>
@endsection
