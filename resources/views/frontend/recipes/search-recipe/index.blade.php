@extends('frontend.layouts.master')

@section('title', __('My recipe'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/search-recipe.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/categories.css') }}"> -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
@endsection

@section('content')

<div class="wrap clearfix">
    <!--breadcrumbs-->
    <nav role="navigation" class="breadcrumbs">
        <ul>
            <li><a href="{{ route('home') }}">'{{ __('Home') }}</a></li>
            <li>{{ __('Search') }}</li>
        </ul>
    </nav>
    <div class="row">
        <section class="content full-width">
            <nav class="tabs">
                <ul>
                    <li class="nav-search active"><a data-tab="tab1" title="Search by ingredients">Search by
                            ingredients</a></li>
                    <li class="nav-search recipe"><a data-tab="tab2" title="Classic search">Classic search</a></li>
                </ul>
            </nav>
            <div class="tab-content" id="tab1" style="display: block;">
                <div class="center">
                    <h3>Search by ingredients</h3>
                    <p><b>{{ __('Note: Each ingredient separate by comma. For Example: meat, beef, union...') }}</b></p>
                    <form method="post" action="{{ route('search.ingredient') }}">
                        {{ csrf_field() }}
                        <div class="f-row">
                            <input id="ingredient_name" name="ingredient_name" type="text"
                                placeholder="{{ __('Ingredient name here') }}"><br>
                                <span class="text-danger">{{ $errors->first('ingredient_name') }}</span>
                            <ul class="suggest-results"></ul>
                        </div>
                        <div class="f-row">
                            <input type="submit" value="Search">
                        </div>
                    </form>

                </div>
            </div>
            <div class="tab-content" id="tab2">
                <div class="center">
                    <h3>Search by recipe</h3>
                    <p><b>{{ __('You can find anything you want. For Example: name, description...') }}</b></p>
                    <form method="post" action="{{ route('search.recipe') }}">
                        {{ csrf_field() }}
                        <div class="f-row">
                            <input id="recipe_name" name="recipe_name" type="text"
                                placeholder="{{ __('Recipe information here') }}"><br>
                                <span class="text-danger">{{ $errors->first('recipe_name') }}</span>
                            <ul class="suggest-results"></ul>
                        </div>
                        <div class="f-row">
                            <input type="submit" value="Search">
                        </div>
                    </form>
                </div>
            </div>
            @if (isset($recipes))
            <h1>{{ __('There is ') . count($recipes) . __(' results with "') .  $keyword. '"' }}</h1>
            @foreach ($recipes as $recipe)
            <div class="entry one-fourth recipe-item">
                <figure>
                    @if ($recipe->image != null)
                    <img src="{{ asset(config('manual.recipe_url') . $recipe->image) }}">
                    @else
                    <img src="{{ config('manual.default_media.recipe') }}" alt="{{ $recipe->name }}">
                    @endif
                    <figcaption><a href="{{ url('/recipe/' . changeLink($recipe->name) . '/' . $recipe->id) }}"><i
                                class="icon icon-themeenergy_eye2"></i><span>{{ __('View recipe') }}</span></a>
                    </figcaption>
                </figure>
                <div class="container">
                    <h2>
                        <a
                            href="{{ url('/recipe/' . changeLink($recipe->name) . '/' . $recipe->id) }}">{{ $recipe->name }}</a>
                    </h2>
                    <div class="actions">
                        <div>
                            <div class="date"><i class="fa fa-calendar"
                                    aria-hidden="true"></i>{{ $recipe->created_at->format('Y-m-d H:s') }}</div>
                        </div>
                    </div>
                    <div class="excerpt">
                        <p>{{ $recipe->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </section>
    </div>
    <!--//row-->
</div>

@endsection

@section('script')
@parent
<script src="{{ asset('messages.js') }}"></script>
<script src="{{ asset('js/frontend/recipes/search-recipe.js') }}"></script>
<script src="{{ asset('bower_components/jquery-highlight/jquery.highlight.js') }}"></script>
@endsection
