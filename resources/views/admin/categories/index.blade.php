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
                    <a href="{{ route('recipes.index') }}" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
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
                    <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
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
                    <a href="{{ route('users.index') }}" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
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
                    <a href="{{ route('manage-post.index') }}" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

        <div class="row">
            <!-- content -->
            <div class="box">
                <div class="box-header">
                    <div class="col-md-10">
                        <h3 class="box-title">{{ __('Category List') }}</h3>
                    </div>
                    <div class="col-md-1 text-right">
                        <a data-toggle="modal" data-target="#createCategory" class="btn btn-primary btn-insert"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="col-md-1">
                        <a data-toggle="tooltip" class="btn btn-default refresh-page"><i class="fa fa-refresh"></i></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    @php $categories = $data['categories']; @endphp
                    @foreach ($categories as $category)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <a href="{{ url($category->link) }}" target="_blank">
                                            <span class="label label-info">
                                                {{ $category->name }}
                                            </span>
                                            <span class="padding-left-10px">
                                            &nbsp;{{ url($category->link) }}
                                            </span>
                                        </a>
                                    </div>
                                    <div class="col-sm-3 text-right wrap-delete-form">
                                        <span class="text-right">
                                            <a href="{{ route('category.subCreate', $category->id) }}" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                                        </span>
                                        <span class="text-right">
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </span>
                                        <a href="javascript:void(0)" data-text="{{ __('Do you want to delete this category ?') }}"  class="delete btn btn-danger">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        <form class="delete-form" action="{{ route('categories.destroy', $category->id) }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-danger">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <ul class="list-group">
                                    @foreach ($category->children as $children)
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <a href="{{ url($category->link . '/' . $children->link) }}" target="_blank">
                                                        <span class="label label-warning">
                                                            {{ $children->name }}
                                                        </span>
                                                        <span class="padding-left-10px">
                                                        &nbsp;{{ url($category->link . '/' . $children->link) }}
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="col-sm-3 text-right wrap-delete-form">
                                                        <span class="text-right">
                                                            <a href="{{ route('categories.edit', $children->id) }}" class="btn btn-primary">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                        </span>
                                                        <a href="javascript:void(0)" data-text="{{ __('Do you want to delete this category ?') }}"  class="delete btn btn-danger">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                        <form class="delete-form" action="{{ route('categories.destroy', $children->id) }}" method="post">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <div class="form-group">
                                                                <input type="submit" class="btn btn-danger">
                                                            </div>
                                                        </form>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    @if (count($category->children) == 0)
                                        <div class="text-center">
                                            {{ __('No sub category') }}
                                        </div>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endforeach
                    {{ $data['categoryParents']->links() }}
                </div>
                <!-- Modal create category -->
                <div class="modal fade" id="createCategory" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <label for="">{{ __('Create Category') }}</label>
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
                                <form id="create-form" action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label for="name">{{ __('Name') }}</label>
                                            <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="link">{{ __('Link') }}</label>
                                            <input type="text" name="link" class="form-control" placeholder="{{ __('Link') }}">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="col-sm-12 margin-top-10px">
                                            <label for="description">{{ __('Short description') }}</label>
                                            <textarea type="text" class="form-control" name="description"
                                                placeholder="{{ __('Your short description here...') }}" rows="6"></textarea>
                                        </div>
                                    </div>
                                    <div class="wrap-upload-image">
                                        <fieldset class="form-group">
                                            <label class="fileContainer">
                                            {{ __('Add pictures') }}
                                                <input type="file" onchange="readImage(this)" class="pro-image"
                                                    name="icon" class="form-control">
                                            </label>
                                        </fieldset>
                                        <div class="wrap-preview">
                                            <div class="preview-images-zone">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="wrap-insert-button">
                                        <button type="submit" class="btn btn-success btn-category-insert">{{ __('Create Category') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ENd modal create category -->
            </div><!-- /.box -->
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
