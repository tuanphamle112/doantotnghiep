@extends('admin.layouts.master')

@section('title', __('Manage Comment'))

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
                        <h3 class="box-title">{{ __('Recipe\'s Comment') }}</h3>
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
                        <table class="table table-hover">
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Owner') }}</th>
                                <th>{{ __('Recipe Number') }}</th>
                                <th>{{ __('Content') }}</th>
                                <th>{{ __('Comment At') }}</th>
                            </tr>

                            @foreach ($comments as $comment)
                            <tr>
                                <td>{{ $comment->id }}</td>
                                <td>{{ $comment->user->name }}</td>
                                <td><a
                                        href="{{ url('/recipe/' . changeLink($comment->commentable->name) . '/' . $comment->commentable->id) }}">{{ $comment->commentable->recipe_number }}</a>
                                </td>
                                <td width="65%">{{ $comment->content }}</td>
                                <td>{{ $comment->created_at }}</td>
                                <td class="wrap-delete-form">
                                    <a href="javascript:void(0)"
                                        data-text="{{ __('Do you want to delete this comment?') }}" class="delete">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    <form class="delete-form" action="{{ route('admin.comment.delete', $comment->id) }}"
                                        method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <div class="form-group">
                                            <input type="hidden" name="comment_type" value="recipe">
                                            <input type="submit" class="btn btn-danger" value="Delete comment">
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </table>
                        {{ $comments->links() }}
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
<script src="{{ asset('js/admin/users/index.js') }}"></script>
@endsection
