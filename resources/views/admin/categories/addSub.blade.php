@extends('admin.layouts.master')

@section('title', __('Manage Categories'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/admin/categories/index-category.css') }}">
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
                        <h3>{{ count($recipes) }}</h3>
                        <p>{{ __('Recipes') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('recipes.index') }}" class="small-box-footer">{{ __('More info') }} <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ count($wishlist) }}</h3>

                        <p>{{ __('Loves') }}</p>
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
                        <h3>{{ count($users) }}</h3>

                        <p>{{ __('Register') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('users.index') }}" class="small-box-footer">{{ __('More info') }} <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ count($posts) }}</h3>

                        <p>{{ __('Posts') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('manage-post.index') }}" class="small-box-footer">{{ __('More info') }} <i
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
                        <div class="col-md-10">
                            <h3 class="box-title">{{ __('Add New Sub Category') }}</h3>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body row">
                        <div class="col-sm-1"></div>
                        <form method="POST" action="{{ route('categories.store') }}" id="add-new-category" class="col-sm-10 col-sx-12">
                            {{ csrf_field() }}    
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}">
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="link">{{ __('Link') }}</label>
                                <input type="text" name="link" class="form-control" placeholder="{{ __('Link') }}">
                                <span class="text-danger">{{ $errors->first('link') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="link">{{ __('Parent Categories') }}</label>
                                <select class="form-control" name="parent_id" id="parent_id">
                                    @foreach ($optionParentCategory as $key => $value)
                                    <option value='{{ $key }}' @if ($parentCategory->id == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                            </div>
                            <div class="form-group ">
                                <div class="margin-top-10px">
                                    <label for="description">{{ __('Short description') }}</label>
                                    <textarea type="text" class="form-control" name="description"
                                        placeholder="{{ __('Your short description here...') }}" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="wrap-insert-button">
                                <button type="submit" class="btn btn-success btn-category-insert">{{ __('Create Category') }}</button>
                            </div>
                        </form>
                        <div class="col-sm-1"></div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div><!-- /.col -->
            <!-- end content -->
        </div>

    </section>
    <!-- /.content -->
</div>

@endsection


@section('script')

@parent
<script src="{{ asset('js/admin/categories/index-category.js') }}"></script>
@endsection
