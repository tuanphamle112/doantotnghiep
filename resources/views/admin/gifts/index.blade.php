@extends('admin.layouts.master')

@section('title', __('Manage Gifts'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/admin/gifts/index-gift.css') }}">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ __('Admin') }}
            <small>{{ __('Gifts List') }}</small>
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
                        <h3 class="box-title">{{ __('Gifts list') }}</h3>
                        <div class="insert-button">
                            <button type="button" class="btn btn-success btn-insert" data-toggle="modal"
                                data-target="#createGift">{{ __('Create New Gift') }}</button>
                        </div>
                        <!-- Modal insert user -->
                        <div class="modal fade" id="createGift" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        @if ($errors->any())
                                        <div class="filling-error error-exist">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                        <form id="create-form" action="{{ route('gifts.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="name">{{ __('Name') }} <span
                                                        class="require-star">*</span></label>
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                            <div class="form-group">
                                                <label for="description">{{ __('Description') }} <span
                                                        class="require-star">*</span></label>
                                                <textarea type="text" class="form-control" name="description"
                                                    placeholder="{{ __('Your short description here...') }}"
                                                    rows="6"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="star_point">{{ __('Star Point') }}</label>
                                                <input type="number" class="form-control" name="star_point">
                                            </div>
                                            <div class="form-group">
                                                <label for="address">{{ __('Quantity:') }}</label>
                                                <input type="number" class="form-control" name="quantity">
                                            </div>
                                            <div class="wrap-upload-image">
                                                <fieldset class="form-group">
                                                    <label class="fileContainer">
                                                        {{ __('Add pictures') }}
                                                        <input type="file" onchange="readImage(this)" class="pro-image"
                                                            name="image" class="form-control">
                                                    </label>
                                                </fieldset>
                                                <div class="wrap-preview">
                                                    <div class="preview-images-zone">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-success">{{ __('Create Gift') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End modal insert user -->
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
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-gift">
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th style="width:400px">{{ __('Image') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Star point (') }} <i class="fa fa-star"></i>)</th>
                                <th>{{ __('Quantity Left') }}</th>
                            </tr>

                            @foreach ($gifts as $gift)
                            <tr>
                                <td>{{ $gift->id }}</td>
                                <td>
                                    <img width="20%" data-enlargable width="100" style="cursor: zoom-in"
                                        class="image-gift" src="{{ asset('uploads/gifts/' . $gift->image) }}">
                                </td>
                                <td>{{ $gift->name }}</td>
                                <td>
                                    <p class="long-text-gift">{{ $gift->description }}</p>
                                </td>
                                <td>{{ $gift->star_point }}</td>
                                <td>{{ $gift->quantity }}</td>

                                <td><a href="{{ route('gifts.edit', ['id'=> $gift->id]) }}">{{ __('Edit') }}</a></td>
                                <td class="wrap-delete-form">
                                    <a href="javascript:void(0)"
                                        data-text="{{ __('Do you want to delete this gift?') }}" class="delete">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    <form class="delete-form" action="{{ route('gifts.destroy', $gift->id) }}"
                                        method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-danger" value="Delete gift">
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </table>
                        {{ $gifts->links() }}
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
<div class="control-sidebar-bg"></div>
<!-- ./wrapper -->
@endsection

@section('script')

@parent
<script src="{{ asset('js/admin/gifts/index-gift.js') }}"></script>
@endsection
