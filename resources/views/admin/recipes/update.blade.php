@extends('admin.layouts.master')

@section('title', __('Update a recipe'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/admin/recipes/create-recipe.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/recipes/update-recipe.css') }}">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ __('Admin') }}
            <small>{{ __('Total Report') }}</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ __('1500') }}</h3>

                        <p>{{ __('User') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">{{ __('More info') }} <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ __('53') }}</h3>

                        <p>{{ __('Likes') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">{{ __('More info') }} <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ __('44') }}</h3>

                        <p>{{ __('Register') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">{{ __('More info') }} <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ __('65') }}</h3>

                        <p>{{ __('Users') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">{{ __('More info') }} <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

        <div class="row">
            <!-- content -->
            <div class="col-xs-12 col-sm-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('Update a recipe') }}</h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm">
                                <input type="text" name="table_search" class="form-control pull-right"
                                    placeholder="{{ __('Search') }}">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action="{{ route('recipes.update', $recipe->id) }}" enctype="multipart/form-data"
                            class="wrap-create-form" method="post">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <div class="form-group wrap-main-image">
                                <div class="input-group">
                                    <label class="mainFileContainer">
                                        <i class="fa fa-camera"></i>
                                        <span>{{ __('Click to add a main picture') }}</span>
                                        <img id="img-upload" alt="" src="{{ asset(config('manual.recipe_url') . $recipe->image) }}">
                                        <input type="file" id="imgInp" class="pro-image" name="main_image" class="form-control">
                                        <input type="hidden" name="main_image_old" value="{{ $recipe->image }}">
                                    </label>
                                </div>
                                <div class="form-group recipe-name">
                                    <label for="name">{{ __('Recipes name') }}</label>
                                    <input type="text" class="form-control input-error" placeholder="{{ __('Recipes name') }}"
                                        name="name" value="{{ $recipe->name }}">
                                    <div class="filling-error"></div>
                                </div>
                                <input type="hidden" class="recipe-number" name="recipe_number" value="{{ $recipe->recipe_number }}">
                                <div class="form-group recipe-description">
                                    <label for="description">{{ __('Short description') }}</label>
                                    <textarea type="text" class="form-control input-error" name="description"
                                        placeholder="{{ __('Your short description here...') }}" rows="6">{{ $recipe->description }}</textarea>
                                    <div class="filling-error"></div>
                                </div>
                                <div class="form-group video-input">
                                    <label for="video">{{ __('Video(Youtube code/link)') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('Youtube link here') }}"
                                        name="video" value="{{ $recipe->video_link }}">
                                </div>
                                <div class="form-group">
                                    <label for="status">{{ __('Status') }}</label><br>
                                    <select class="form-control" name="status">
                                    @foreach (config("manual.recipe_status") as $key => $value)
                                        <option value="{{ $value }}" @if ($recipe->status == $value) selected @endif>{{ $key }}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group recipe-estimate-number">
                                    <label for="gender">{{ __('Level, estimate time and number of people') }}</label><br>
                                    <select class="form-control" name="level">
                                        @foreach ($levels as $level)
                                        <option value="{{ $level->id }}" @if ($level->id == $levelRecipe->id) selected @endif>{{ $level->name }}</option>
                                        @endforeach
                                    </select>

                                    <input type="number" class="form-control" name="estimate_time" value="0">
                                    <span>{{ __('hour') }}</span>
                                    <input type="text" class="form-control" name="people_number" value="1">
                                    <span>{{ __('people') }}</span>
                                </div>
                                <div class="form-group categories">
                                    <label for="gender">{{ __('Select Categories') }}</label><br>
                                    <select class="form-control categories-select" name="categories[]" multiple>
                                        @foreach ($categories as $category)
                                            <option value='{{ $category->id }}'
                                            @foreach ($categoriesSelected as $categorySelected)
                                                @if ($category->id == $categorySelected->id) selected @endif
                                            @endforeach
                                            >{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="filling-error">{{ __('Please take at least one category') }}</div>
                                </div>
                                <div class="ingredient-area form-group">
                                    <label for="phone">{{ __('Ingredients') }}:</label>
                                    <div class="all-ingredient">
                                    @foreach ($ingredients as $key => $ingredient)
                                        <div class="ingredient-item" data-ingre="{{ $ingredient }}">
                                            <i class="fa fa-check-circle"></i>
                                            <b>{{ $ingredient }}</b>
                                            <i class="fa fa-times-circle close-ingredient" onclick="removeIngredientDiv(this)"></i>
                                        </div>
                                    @endforeach
                                    </div>
                                    <div class="ingredient-input">
                                        <input type="text" class="form-control ingredient-field"
                                            placeholder="{{ __('For example: 300 gr xxx, 2 peace of beef') }}">
                                        <div class="filling-error">

                                            <!-- adding errors message -->
                                        </div>
                                        <span class="small-tips how-to-fill active">
                                            <i class="fa fa-question-circle"></i>
                                            {{ __('How to fill?') }}
                                        </span>
                                        <span class="small-tips understood">
                                            <i class="fa fa-check-circle"></i>
                                            {{ __('I understood') }}
                                        </span>
                                        <div class="filling-instruction">
                                            <div>
                                                <div>{{ __('Note') }}</div>
                                                <div>
                                                    <ul>
                                                        <li>{{ __('How to fill:') }} <span class="note-gray-highlight">{{ __('quantity(space)') }}</span> <span
                                                                class="note-gray-highlight">{{ __('unit(space)') }}</span> <span
                                                                class="note-gray-highlight">{{ __('ingredient_name') }}</span> <span
                                                                class="note-gray-highlight">{{ __('( note )') }}</span></li>
                                                        <li>
                                                            {{ __('Quantity: quantity of ingredient; unit: gram, litre, peace...; ingredient_name: the name of ingredient; note: this is an optional') }}
                                                        </li>
                                                        <li>
                                                            <span>{{ __('A ingredient must be write in one line') }}</span>
                                                            <ul>
                                                                <li>{{ __('Fill a ingredient and press ') }}<b>{{ __('Enter') }}</b></li>
                                                                <li>{{ __('For example: ') }}<span class="note-gray-highlight">{{ __('100 gr chicken(your note)') }}</span>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="all-ingredients" name="ingredients" value="{{ $ingredientsSet }}">
                                </div>
                                <!-- Step -->
                                <div class="wrap-step-box">
                                    <div class="step-box">
                                        <a href="javascript:void(0)" data-no="stepCount"
                                            class="btn btn-danger btn-close btn-delete-step"><span
                                                class="fa fa-trash"></span></a>
                                        <div class="step-count">stepCount</div>
                                        <input type="hidden" name="step_number" value="stepCount">
                                        <div class="step-direction">
                                            <textarea rows="4" cols="40" name="stepContent"
                                                class="form-control step-content-stepCount"
                                                placeholder="{{ __('') }}Nhập hướng dẫn cách làm cho bước 1"></textarea>
                                            <div class="filling-error">
                                                <span>{{ __('Please fill recipes step instruction') }}</span><br>
                                            </div>
                                        </div>
                                        <div class="step-acts">
                                            <a href="javascript:void(0)" class="btn-show-opts">
                                                <span class="fa fa-plus"></span> <strong>{{ __('More Information') }}</strong>
                                                <em>{{ __('(Cooking time, Step name, Tips,...)') }}</em>
                                            </a>
                                            <div class="step-opts">
                                                <div class="step-opt">
                                                    <span class="step-tip-ico fa fa-info-circle"></span>
                                                    <input type="text" name="stepName" placeholder="{{ __('Name of step') }}">
                                                </div>
                                                <div class="step-opt">
                                                    <span class="step-tip-ico fa fa-clock-o"></span>
                                                    <input class="step-time" name="stepTime" type="text" placeholder="{{ __('Time') }}"> {{ __('minute') }}
                                                </div>
                                                <div class="step-opt" class="tips-for-good">
                                                    <span class="step-tip" title="{{ __('Tips for the good') }}">
                                                        <span class="step-tip-ico fa fa-lightbulb-o"></span>
                                                    </span>
                                                    <input type="text" placeholder="{{ __('Tips for the good') }}" name="stepNote">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrap-upload-image">
                                            <fieldset class="form-group">
                                                <label class="fileContainer">
                                                {{ __('Add pictures') }}
                                                    <input type="file" data-type="new" onchange="readImageUpdate(this)" class="pro-image"
                                                        name="stepFile" class="form-control" multiple>
                                                    <input type="hidden" class="step-hidden-files" name="stepFileHidden" value="">
                                                </label>
                                                <div class="picture-overlay"></div>
                                                <div class="text-gray text-italic text-small">
                                                    ({{ __('Limit ') }}<span class="text-highlight">6</span> {{ __('images') }})
                                                </div>
                                                <div class="text-gray text-italic text-small">
                                                {{ __('Hold ') }}<span class="text-highlight ng-binding">{{ __('Ctrl') }}</span> {{ __('to choose more picture') }}</div>
                                            </fieldset>
                                            <div class="wrap-preview">
                                                <a href="javascript:void(0)" class="button-clear">
                                                    <i class="fa fa-times"></i> {{ __('Clear') }}
                                                </a>
                                                <input type="hidden" class="input-clear" name="{{ 'stepstepCount[clear]' }}" value="">
                                                <div class="preview-images-zone" data-type="new">
                                                    <input type="hidden" class="image-num" name="image_numstepCount" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($cookingSteps as $cookingStep)
                                    <div class="step-box">
                                        <a href="javascript:void(0)" data-no="{{ $cookingStep->step_number }}" class="btn btn-danger btn-close btn-delete-step"><span class="fa fa-trash"></span></a>
                                        <div class="step-count">{{ $cookingStep->step_number }}</div>
                                        <input type="hidden" name="step_number" value="{{ $cookingStep->step_number }}">
                                        <div class="step-direction">
                                            <textarea rows="4" cols="40" name="{{ 'step' . $cookingStep->step_number . '[content]' }}" class="form-control step-content-{{ $cookingStep->step_number }}" placeholder="{{ __('Fill the instruction for this step') }}">{{ $cookingStep->content }}</textarea>
                                            <div class="filling-error">
                                                <span>{{ __("Please fill recipe's step instruction") }}</span><br>
                                            </div>
                                        </div>
                                        <div class="step-acts">
                                            <a href="javascript:void(0)" class="btn-show-opts">
                                                <span class="fa fa-plus"></span> <strong>{{ __('More Information') }}</strong>
                                                <em>{{ __('(Cooking time, Step name, Tips,...)') }}</em>
                                            </a>
                                            <div class="step-opts">
                                                <div class="step-opt">
                                                    <span class="step-tip-ico fa fa-info-circle"></span> 
                                                    <input type="text" name="{{ 'step'.$cookingStep->step_number.'[name]' }}"
                                                        placeholder="{{ __('Name of step') }}" value="{{ $cookingStep->name }}">
                                                </div>
                                                <div class="step-opt">
                                                    <span class="step-tip-ico fa fa-clock-o"></span>
                                                    <input class="step-time" name="{{ 'step'.$cookingStep->step_number.'[time]'}}"
                                                        type="text" placeholder="{{ __('Time') }}" value="{{ $cookingStep->time }}"> {{ __('minute') }}
                                                </div>
                                                <div class="step-opt" class="tips-for-good">
                                                    <span class="step-tip" title="{{ __('Tips for the good') }}">
                                                        <span class="step-tip-ico fa fa-lightbulb-o"></span>
                                                    </span>
                                                    <input type="text" placeholder="{{ __('Tips for the good') }}"
                                                    name="{{ 'step'.$cookingStep->step_number.'[note]' }}" value="{{ $cookingStep->note }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrap-upload-image">
                                            <fieldset class="form-group">
                                                <label class="fileContainer">
                                                {{ __('Add pictures') }}
                                                    <input type="file" onchange="readImageUpdate(this)"
                                                    name="{{ 'step_files'.$cookingStep->step_number.'[]' }}" class="form-control pro-image" multiple>
                                                    <input type="hidden" class="step-hidden-files" 
                                                    name="{{ 'step_files_hidden'.$cookingStep->step_number }}" value="{{ $cookingStep->image }}">
                                                </label>
                                                <div class="picture-overlay"></div>
                                                <div class="text-gray text-italic text-small">
                                                    ({{ __('Limit ') }}<span class="text-highlight">6</span> {{ __('images') }})
                                                </div>
                                                <div class="text-gray text-italic text-small">
                                                {{ __('Hold ') }}<span class="text-highlight ng-binding">{{ __('Ctrl') }}</span> {{ __('to choose more picture') }}</div>
                                            </fieldset>

                                            <div class="wrap-preview">
                                                <a href="javascript:void(0)" class="button-clear">
                                                    <i class="fa fa-times"></i> {{ __('Clear') }}
                                                </a>     
                                                <input type="hidden" class="input-clear" name="{{ 'step' . $cookingStep->step_number . '[clear]' }}" value="">                 
                                                <div class="preview-images-zone">
                                                @php
                                                    if (!is_null($cookingStep->image)) {
                                                        $stepImages = explode(',', ltrim($cookingStep->image, ','));
                                                    }
                                                @endphp
                                                @if (!is_null($cookingStep->image))
                                                    @foreach ($stepImages as $stepImage)
                                                    @if ($stepImage != '')
                                                    <div class="preview-image">
                                                        <div class="image-zone"><img src="{{ asset(config('manual.recipe_url') . $stepImage) }}"></div>
                                                    </div>
                                                    @endif
                                                    @endforeach
                                                @endif
                                                <input type="hidden" class="image-num" name="{{ 'image_num' . $cookingStep->step_number }}" value="@if (!is_null($cookingStep->image)) {{ count($stepImages) }} @endif">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @if (count($cookingSteps) > 0)
                                <input type="hidden" class="step-num" name="step_num" value="{{ $cookingStep->step_number }}">
                                @endif
                                <input type="hidden" class="step_num_not_decrease" name="step_num_not_decrease" value="{{ $numberOfStep }}">
                                <!-- Add step button -->
                                <a class="addmore-ingredients add-more-btn" href="javascript:void(0)">{{ __('+ Add a step') }}</a>
                                <div class="filling-error no-step">{{ __('Please fill at least one step') }}</div>
                                <!-- End add step button -->
                                <!-- End Step -->
                                <div class="form-group submit-button">
                                    <input type="submit" class="btn btn-success form-control" value="{{ __('Update Recipe') }}">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- end content -->
        </div>

    </section>
    <!-- /.content -->
</div>

@endsection

@section('script')

@parent
<script src="{{ asset('messages.js') }}"></script>

<script src="{{ asset('js/admin/recipes/create-edit-recipe.js') }}"></script>
@endsection
