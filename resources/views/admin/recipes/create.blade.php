@extends('admin.layouts.master')

@section('title', __('Create a recipe'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/admin/recipes/create-recipe.css') }}">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ __('Page Header') }}
            <small>{{ __('Optional description') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>{{ __('Level') }}</a></li>
            <li class="active">{{ __('Here') }}</li>
        </ol>
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
                        <h3 class="box-title">{{ __('Create a recipe') }}</h3>
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
                        <form action="{{ route('recipes.store') }}" enctype="multipart/form-data"
                            class="wrap-create-form" method="post">
                            {{ csrf_field() }}
                            <div class="form-group wrap-main-image">
                                <div class="input-group">
                                    <label class="mainFileContainer">
                                        <i class="fa fa-camera"></i>
                                        <span>{{ __('Click to add a main picture') }}</span>
                                        <img id="img-upload" alt="">
                                        <input type="file" id="imgInp" class="pro-image" name="main_image"
                                            class="form-control">
                                    </label>
                                </div>
                                <div class="form-group recipe-name">
                                    <label for="name">{{ __('Recipes name') }}</label>
                                    <input type="text" class="form-control input-error" placeholder="{{ __('Recipes name') }}"
                                        name="name">
                                    <div class="filling-error"></div>
                                </div>
                                <input type="hidden" name="recipe_number" value="{{ time() }}">
                                <div class="form-group recipe-description">
                                    <label for="description">{{ __('Short description') }}</label>
                                    <textarea type="text" class="form-control input-error" name="description"
                                        placeholder="{{ __('Your short description here...') }}" rows="6"></textarea>
                                    <div class="filling-error"></div>
                                </div>
                                <div class="form-group video-input">
                                    <label for="video">{{ __('Video(Youtube code/link)') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('Youtube link here') }}"
                                        name="video">
                                </div>
                                <div class="form-group recipe-estimate-number">
                                    <label for="gender">{{ __('Level, estimate time and number of people') }}</label><br>
                                    <select class="form-control" name="level">
                                        @foreach ($levels as $level)
                                        <option value='{{ $level->id }}'>{{ $level->name }}</option>
                                        @endforeach
                                    </select>

                                    <input type="text" class="form-control" name="estimate_time" value="0">
                                    <span>{{ __('hour') }}</span>
                                    <input type="text" class="form-control" name="people_number" value="1">
                                    <span>{{ __('people') }}</span>
                                </div>
                                <div class="ingredient-area form-group">
                                    <label for="phone">{{ __('Ingredients') }}:</label>
                                    <div class="all-ingredient">
                                        <!-- adding ingredient item section -->
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
                                    <input type="hidden" class="all-ingredients" name="ingredients" value="">
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
                                                    <input type="text" name="stepName"
                                                        placeholder="{{ __('Name of step') }}"
                                                        class="ng-pristine ng-untouched ng-valid ng-empty">
                                                </div>
                                                <div class="step-opt">
                                                    <span class="step-tip-ico fa fa-clock-o"></span>
                                                    <input class="step-time" name="stepTime"
                                                        type="text" placeholder="{{ __('Time') }}"
                                                        class="ng-pristine ng-untouched ng-valid ng-empty"> {{ __('minute') }}
                                                </div>
                                                <div class="step-opt" class="tips-for-good">
                                                    <span class="step-tip" title="{{ __('Tips for the good') }}">
                                                        <span class="step-tip-ico fa fa-lightbulb-o"></span>
                                                    </span>
                                                    <input type="text" placeholder="{{ __('Tips for the good') }}"
                                                        name="stepNote"
                                                        class="ng-pristine ng-untouched ng-valid ng-empty">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrap-upload-image">
                                            <fieldset class="form-group">
                                                <label class="fileContainer">
                                                {{ __('Add pictures') }}
                                                    <input type="file" onchange="readImage(this)" class="pro-image"
                                                        name="stepFile" class="form-control" multiple>
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
                                                    <i class="fa fa-times"></i> Clear
                                                </a>
                                                <input type="hidden" name="{{ 'stepstepCount[clear]' }}" value="">
                                                <div class="preview-images-zone">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="step-num" name="step_num">
                                <input type="hidden" class="step_num_not_decrease" name="step_num_not_decrease"
                                    value="0">
                                <!-- Add step button -->
                                <a class="addmore-ingredients add-more-btn" href="javascript:void(0)">{{ __('+ Add a step') }}</a>
                                <div class="filling-error no-step">{{ __('Please fill at least one step') }}</div>
                                <!-- End add step button -->
                                <!-- End Step -->
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success form-control" value="{{ __('Create Recipe') }}">
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
