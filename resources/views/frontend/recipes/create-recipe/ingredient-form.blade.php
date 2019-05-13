@extends('frontend.layouts.master')

@section('title', __('Detail recipe'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/general.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/ingredient.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
@endsection

@section('content')

<div class="wrap clearfix">
    <!--breadcrumbs-->
    <nav role="navigation" class="breadcrumbs">
        <ul>
            <li><a href="{{ route('home') }}" title="Home">'{{ __('Home') }}</a></li>
            <li>{{ __('Submit Recipe') }}</li>
        </ul>
    </nav>
    <div class="row">
        <section class="content full-width">
            <div class="submit_recipe container">
                <ul class="nav nav-pills nav-justified checkout-steps push-bit">
                    <li><a href="javascript:void(0)"><strong>{{ __('1. Recipe Information') }}</strong></a></li>
                    <li class="active"><a href="javascript:void(0)"><strong>{{ __('2. Ingredients') }}</strong></a>
                    </li>
                    <li><a href="javascript:void(0)"><strong>{{ __('3. Cooking Steps') }}</strong></a>
                    </li>
                    <li><a href="javascript:void(0)"><strong>{{ __('4. Recipe Categories') }}</strong></a></li>
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
                <form action="{{ route('recipe.ingredient', $id) }}" class="wrap-create-form" method="post">
                    {{ csrf_field() }}
                    <div class="wrap-ingredient">
                        <div class="form-group ingredient-small">
                            <label for="name">{{ __('Quantity') }}</label>
                            <input type="number" class="form-control ingredient-quantity" placeholder="{{ __('Ingredient Quantity') }}">
                        </div>
                        <div class="form-group ingredient-small">
                            <label for="name">{{ __('Unit') }}</label>
                            <input type="text" class="form-control ingredient-unit" placeholder="{{ __('Ingredient Unit') }}">
                        </div>
                        <div class="form-group ingredient-name">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" class="form-control input-ingredient-name" placeholder="{{ __('Ingredient Name') }}">
                        </div>
                        <div class="wrap-add-button">
                            <button class="btn-default add-ingredient">{{ __('Add') }}</button>
                        </div>
                        <div class="filling-error ingredient-error"></div>
                        <div class="ingredient-container">
                            <!-- append ingredient item here -->
                        </div>
                        <br class="clearBoth" />
                    </div>
                    <input type="hidden" class="ingredients" name="ingredients">
                    <div class="f-row full">
                        <a href="#" class="button back-form-1">{{ __('Back Step') }}</a>
                        <input type="submit" value="{{ __('Next Step') }}" class="button next-form">
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
<script src="{{ asset('js/frontend/recipes/create-edit.js') }}"></script>
@endsection
