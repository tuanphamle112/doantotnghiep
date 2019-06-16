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
            <li>{{ __('My Posts') }}</li>
        </ul>
    </nav>
    <div class="row">
        <header class="s-title">
            <h1>{{ __('My Posts') }}</h1>
        </header>
        <section class="content full-width">
            <div class="entries row">
                <!--item-->
                @foreach ($myPosts as $post)
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
                        <div class="actions">
                            <div>
                                <div class="difficulty">
                                    <a href="{{ route('my-posts.edit', $post->id) }}">{{ __('Update Post')}}</a>
                                </div>
                                @if ($post->status == config('manual.post_status.Pendding'))
                                <td><span class="label label-warning">{{ __('Pendding') }}</span></td>
                                @elseif ($post->status == config('manual.post_status.Actived'))
                                <td><span class="label label-success">{{ __('Actived') }}</span></td>
                                @else
                                <td><span class="label label-danger">{{ __('Reject') }}</span></td>
                                @endif
                                <div class="wrap-delete-form">
                                    <div class="comments">
                                        <a href="javascript:void(0)"
                                            data-text="{{ __('Do you want to delete this post?') }}" class="delete">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </div>
                                    <form class="delete-form" action="{{ route('my-posts.destroy', $post->id) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <input type="hidden" name="post_image" value="{{ $post->image }}">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-danger">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="excerpt">
                            <p>{{ $post->description }}</p>
                        </div>
                        {{ $myPosts->links() }}
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
<!-- <script src="{{ asset('js/frontend/recipes/categories.js') }}"></script> -->
<script src="{{ asset('bower_components/jquery-highlight/jquery.highlight.js') }}"></script>
@endsection
