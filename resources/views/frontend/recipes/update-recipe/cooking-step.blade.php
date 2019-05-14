@extends('frontend.layouts.master')

@section('title', __('Create recipe'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/general.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/cooking-step.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-fileinput/css/fileinput.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-fileinput/css/fileinput-rtl.min.css') }}">
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
                    <li class="active"><a href="javascript:void(0)"><strong>{{ __('3. Cooking Steps') }}</strong></a>
                    </li>
                    <li><a href="javascript:void(0)"><strong>{{ __('4. Recipe Categories') }}</strong></a></li>
                </ul>
                @if ($stepInfo != null)
                    <form action="{{ route('update-recipe.step', [$id, $stepNumber]) }}" class="wrap-create-form" method="post">
                        {{ csrf_field() }}

                        <div class="wrap-step-box form-group">
                            <div class="step-banner">
                                <span>{{ __('Step') }} {{ $stepNumber }}</span>
                            </div>
                            <div class="wrap-step-content form-group">
                                <div class="form-group recipe-description">
                                    <label for="description">{{ __('Short description') }}</label>
                                    <textarea type="text" class="form-control input-error" name="content"
                                        placeholder="{{ __('Your short description here...') }}" rows="6">{{ $stepInfo->content }}</textarea>
                                </div>
                                @if ($errors->any())
                                    <div class="filling-error error-exist">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-group step-name">
                                    <label for="name">{{ __('Name of step') }}</label>
                                    <input type="text" name="name" class="form-control" placeholder="{{ __('Name of step') }}" value="{{ $stepInfo->name }}">
                                </div>
                                <div class="form-group step-time">
                                    <label for="time">{{ __('Time') }}</label>
                                    <input class="form-control" name="time" type="number" placeholder="{{ __('Time') }}" value="{{ $stepInfo->time }}">
                                </div>
                                <div class="form-group step-tips" class="tips-for-good">
                                    <label for="tips">{{ __('Tips for the good') }}</label>
                                    <textarea type="text" class="form-control" name="note" placeholder="{{ __('Tips for the good') }}" rows="4">{{ $stepInfo->note }}</textarea>
                                </div>
                            </div>
                            <div class="wrap-file-input">
                                <div class="file-loading">
                                    <input id="input-702" class="step-update" name="step_file[]" type="file" multiple>
                                </div>
                            </div>
                            <input type="hidden" name="recipe_number" value="{{ $recipe->recipe_number }}">
                            <input type="hidden" name="step_number" value="{{ $stepNumber }}">
                            <input type="hidden" name="recipe_id" value="{{ $id }}">
                            <input type="hidden" class="step-image" value="{{ $stepInfo->image }}">
                            <div class="step-button">
                                @if ($stepNumber > 1)
                                <a href="{{ route('form-update.step', [$id, $stepNumber-1]) }}" class="button back-step">{{ __('Back Step') }}</a>
                                @endif
                                <button type="submit" name="submit_step" value="next_step" class="button next-step">{{ __('Next Step') }}</button>
                            </div>
                        </div>
                        
                        <div class="f-row full">
                            <a href="{{ route('form-update.ingredient', $id) }}" class="button back-form-1">{{ __('Back') }}</a>
                            <button type="submit" name="submit_step" value="next_form" class="button next-form">{{ __('Next') }}</button>
                        </div>
                    </form>
                @else 
                    <form action="{{ route('form.step', [$id, $stepNumber]) }}" class="wrap-create-form" method="post">
                        {{ csrf_field() }}

                        <div class="wrap-step-box form-group">
                            <div class="step-banner">
                                <span>{{ __('Step') }} {{ $stepNumber }}</span>
                            </div>
                            <div class="wrap-step-content form-group">
                                <div class="form-group recipe-description">
                                    <label for="description">{{ __('Short description') }}</label>
                                    <textarea type="text" class="form-control input-error" name="content"
                                        placeholder="{{ __('Your short description here...') }}" rows="6"></textarea>
                                </div>
                                @if ($errors->any())
                                    <div class="filling-error error-exist">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-group step-name">
                                    <label for="name">{{ __('Name of step') }}</label>
                                    <input type="text" name="name" class="form-control" placeholder="{{ __('Name of step') }}">
                                </div>
                                <div class="form-group step-time">
                                    <label for="time">{{ __('Time') }}</label>
                                    <input class="form-control" name="time" type="number" placeholder="{{ __('Time') }}">
                                </div>
                                <div class="form-group step-tips" class="tips-for-good">
                                    <label for="tips">{{ __('Tips for the good') }}</label>
                                    <textarea type="text" class="form-control" name="note" placeholder="{{ __('Tips for the good') }}" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="wrap-file-input">
                                <div class="file-loading">
                                    <input id="input-701" class="step-update" name="step_file[]" type="file" multiple>
                                </div>
                            </div>
                            <input type="hidden" name="recipe_number" value="{{ $recipe->recipe_number }}">
                            <input type="hidden" name="step_number" value="{{ $stepNumber }}">
                            <input type="hidden" name="recipe_id" value="{{ $id }}">
                            <input type="hidden" class="step-image">
                            <div class="step-button">
                                @if ($stepNumber > 1)
                                <a href="{{ route('form-update.step', [$id, $stepNumber-1]) }}" class="button back-step">{{ __('Back Step') }}</a>
                                @endif
                                <button type="submit" name="submit_step" value="next_step" class="button next-step">{{ __('Next Step') }}</button>
                            </div>
                        </div>
                        
                        <div class="f-row full">
                            <a href="#" class="button back-form-1">{{ __('Back') }}</a>
                            <button type="submit" name="submit_step" value="next_form" class="button next-form">{{ __('Next') }}</button>
                        </div>
                    </form>
                @endif
            </div>
        </section>

    </div>
    <!--//row-->
</div>

@endsection

@section('script')
@parent
<script src="{{ asset('messages.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-fileinput/themes/fa/theme.min.js') }}"></script>
<script src="{{ asset('js/frontend/recipes/create-edit.js') }}"></script>
@endsection
