@extends('frontend.layouts.master')

@section('title', __('My recipe'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/general.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/categories.css') }}"> -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
@endsection

@section('content')

<div class="wrap clearfix">
    <!--breadcrumbs-->
    <nav role="navigation" class="breadcrumbs">
        <ul>
            <li><a href="{{ route('home') }}">'{{ __('Home') }}</a></li>
            <li>{{ __('My Recipes') }}</li>
        </ul>
    </nav>
    <div class="row">
        <header class="s-title">
            <h1>{{ __('My Recipes') }}</h1>
        </header>
        <section class="content full-width">
            <div class="entries row">
                <!--item-->
                @foreach ($recipes as $recipe)
                <div class="entry one-fourth recipe-item">
                    <figure>
                        @if ($recipe->image != null)
                        <img src="{{ asset(config('manual.recipe_url') . $recipe->image) }}">
                        @else
                        <img src="{{ config('manual.default_media.recipe') }}" alt="{{ $recipe->name }}">
                        @endif
                        <figcaption><a href="{{ url('/recipe/' . changeLink($recipe->name) . '/' . $recipe->id) }}"><i class="icon icon-themeenergy_eye2"></i><span>{{ __('View recipe') }}</span></a></figcaption>
                    </figure>
                    <div class="container">
                        <h2>
                            <a href="{{ url('/recipe/' . changeLink($recipe->name) . '/' . $recipe->id) }}">{{ $recipe->name }}</a>
                        </h2>
                        <div class="actions">
                            <div>
                                <div class="difficulty">
                                    <a href="{{ route('my-recipe.edit', $recipe->id) }}">{{ __('Update Recipe')}}</a>
                                </div>
                                @if ($recipe->status == config('manual.recipe_status.Pendding'))
                                <td><span class="label label-warning">{{ __('Pendding') }}</span></td>
                                @elseif ($recipe->status == config('manual.recipe_status.Actived'))
                                <td><span class="label label-success">{{ __('Actived') }}</span></td>
                                @else
                                <td><span class="label label-danger">{{ __('Reject') }}</span></td>
                                @endif
                                <div class="comments"><i class="fa fa-comment" aria-hidden="true"></i><a href="#">0</a>
                                </div>
                            </div>
                        </div>
                        {{ $recipes->links() }}
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
