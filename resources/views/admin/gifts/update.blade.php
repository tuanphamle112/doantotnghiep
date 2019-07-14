@extends('admin.layouts.master')

@section('title', __('Update Categories'))

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
            <div class="col-xs-12 col-sm-12"">
                <div class="box">
                    <div class="box-header">
                        <div class="col-md-10">
                            <h3 class="box-title">{{ __('Edit Gift') }}</h3>
                        </div>
                    </div><!-- /.box-header -->
                    @if ($errors->any())
                    <div class="filling-error error-exist">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="box-body row">
                        <div class="col-sm-1"></div>
                        <form id="create-form" style="width:75%; margin:auto" action="{{ route('gifts.update', $gift->id) }}" method="post"
                            enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name">{{ __('Name') }} <span class="require-star">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{ $gift->name }}">
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Description') }} <span
                                        class="require-star">*</span></label>
                                <textarea type="text" class="form-control" name="description"
                                    placeholder="{{ __('Your short description here...') }}"
                                    rows="6">{{ $gift->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="star_point">{{ __('Star Point') }}<span
                                        class="require-star">*</span></label>
                                <input type="number" class="form-control" name="star_point"
                                    value="{{ $gift->star_point }}">
                            </div>
                            <div class="form-group">
                                <label for="address">{{ __('Quantity:') }}<span
                                        class="require-star">*</span></label>
                                <input type="number" class="form-control" name="quantity" value="{{ $gift->quantity }}">
                            </div>
                            <div class="wrap-upload-image">
                                <fieldset class="form-group">
                                    <label class="fileContainer">
                                        {{ __('Add pictures') }}
                                        <input type="file" onchange="readImage(this)" class="pro-image" name="image"
                                            class="form-control">
                                    </label>
                                </fieldset>
                                <div class="wrap-preview">
                                    <div class="preview-images-zone">
                                        <img id="img-cate" src="{{ asset('uploads/gifts/' . $gift->image) }}">
                                    </div>
                                </div>
                            </div>
                            <button type=" submit" class="btn btn-success">{{ __('Update Gift') }}</button>
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
<script src="{{ asset('js/admin/gifts/index-gift.js') }}"></script>
@endsection
