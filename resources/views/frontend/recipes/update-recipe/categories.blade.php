@extends('frontend.layouts.master')

@section('title', __('Detail recipe'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/general.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/categories.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
@endsection

@section('content')

<div class="wrap clearfix">
    <!--breadcrumbs-->
    <nav role="navigation" class="breadcrumbs">
        <ul>
            <li><a href="{{ route('home') }}">'{{ __('Home') }}</a></li>
            <li>{{ __('Submit Recipe') }}</li>
        </ul>
    </nav>
    <div class="row">
        <section class="content full-width">
            <div class="submit_recipe container">
                <ul class="nav nav-pills nav-justified checkout-steps push-bit">
                    <li><a href="javascript:void(0)"><strong>{{ __('1. Recipe Information') }}</strong></a></li>
                    <li><a href="javascript:void(0)"><strong>{{ __('2. Ingredients') }}</strong></a>
                    </li>
                    <li><a href="javascript:void(0)"><strong>{{ __('3. Cooking Steps') }}</strong></a>
                    </li>
                    <li class="active"><a href="javascript:void(0)"><strong>{{ __('4. Recipe Categories') }}</strong></a></li>
                </ul>
                @if ($errors->any())
                    <div class="filling-error error-exist">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('update-recipe.categories', $id) }}" class="wrap-create-form" method="post">
                    {{ csrf_field() }}
                    <div class="wrap-categories">
                        <div class="form-group search-categories">
                            <label for="categories">{{ __('Search For Categories') }}</label>
                            <input type="text" id="search" name="search" placeholder="{{ __('Search For Categories') }}">
                        </div>
                        <div class="categories-list">
                            @foreach ($allCategories as $category)
                            <label class="checkbox-item">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                @foreach ($recipeCategory as $cate)
                                    @if ($cate->id == $category->id) checked @endif
                                @endforeach
                                />
                                <span class="label-text">{{ $category->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="f-row full">
                        <a href="{{ route('form-update.step', [$id, $lastStepId]) }}" class="button back-form-1">{{ __('Back Step') }}</a>
                        <input type="submit" value="{{ __('Finish') }}" class="button next-form">
                    </div>
                </form>

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
