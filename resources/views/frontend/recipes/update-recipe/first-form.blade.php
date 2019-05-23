@extends('frontend.layouts.master')

@section('title', __('Create recipe'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/general.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/first-form.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/update-recipe/first-form.css') }}">
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
                    <li class="active"><a href="javascript:void(0)"><strong>{{ __('1. Recipe Information') }}</strong></a></li>
                    <li><a href="javascript:void(0)"><strong>{{ __('2. Ingredients') }}</strong></a>
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
                <form action="{{ route('update-recipe.info', $recipe->id) }}" enctype="multipart/form-data" class="wrap-create-form" method="post">
                    {{ csrf_field() }}
                    <div class="wrap-main-image">
                        <div class="input-group">
                            <label class="mainFileContainer">
                                <i class="fa fa-camera"></i>
                                <span>{{ __('Click to add a main picture') }}</span>
                                @if ($recipe->image != null)
                                <img id="img-upload" src="{{ asset(config('manual.recipe_url') . $recipe->image) }}" alt="{{ $recipe->name }}">
                                @else
                                <img id="img-upload" src="{{ asset(config('manual.default_media.recipe')) }}" alt="{{ $recipe->name }}">
                                @endif
                                <input type="file" id="imgInp" class="pro-image" name="main_image"
                                    class="form-control">
                                <input type="hidden" name="main_image_old" value="{{ $recipe->image }}">
                            </label>
                        </div>
                        
                        <div class="form-group recipe-name">
                            <label for="name">{{ __('Recipes name') }}</label>
                            <input type="text" class="form-control input-error" placeholder="{{ __('Recipes name') }}"
                                name="name" value="{{ $recipe->name }}">
                        </div>
                        <input type="hidden" name="recipe_number" value="{{ $recipe->recipe_number }}">
                        <div class="form-group recipe-description">
                            <label for="description">{{ __('Short description') }}</label>
                            <textarea type="text" class="form-control input-error" name="description"
                                placeholder="{{ __('Your short description here...') }}" rows="6">{{ $recipe->description }}</textarea>
                        </div>
                        <div class="form-group video-input">
                            <label for="video">{{ __('Video(Youtube code/link)') }}</label>
                            <input type="text" class="form-control" placeholder="{{ __('Youtube link here') }}"
                                name="video" value="{{ $recipe->video }}">
                        </div>
                        <div class="form-group recipe-estimate-number">
                            <label for="gender">{{ __('Level, estimate time and number of people') }}</label><br>
                            <select class="form-control" name="level">
                                @foreach ($levels as $level)
                                <option value='{{ $level->id }}' @if ($level->id == $recipe->level->id) selected @endif>{{ $level->name }}</option>
                                @endforeach
                            </select>

                            <input type="text" class="form-control" name="estimate_time" value="{{ $recipe->estimate_time }}">
                            <span>{{ __('hour') }}</span>
                            <input type="text" class="form-control" name="people_number" value="{{ $recipe->people_number }}">
                            <span>{{ __('people') }}</span>
                        </div>
                    </div>
                    <div class="f-row full center-input">
                        <input type="submit" value="{{ __('Next') }}" name="submitRecipe" id="submit_recipe" class="button">
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
<script src="{{ asset('js/frontend/recipes/create-edit.js') }}"></script>

@endsection
