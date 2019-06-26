@extends('admin.layouts.master')

@section('title', __('Manage Posts'))

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
                        <h3 class="box-title">{{ __('Posts list') }}</h3>
                        <div class="insert-button">
                            <a class="btn btn-success btn-insert"
                                href="{{ route('posts.create') }}">{{ __('Create new post') }}</a>
                        </div>
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
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Image link') }}</th>
                                <th>{{ __('Posts by') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>

                            @foreach ($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>
                                    <p class="long-text">{{ $post->description }}</p>
                                </td>
                                <td>
                                    <p class="long-text">{{ $post->image }}</p>
                                </td>
                                <td>{{ $post->user->name }}</td>

                                @if ($post->status == config('manual.post_status.Pendding'))
                                <td><span class="label label-warning">{{ __('Pendding') }}</span></td>
                                <td class="wrap-status-form">
                                    <a href="javascript:void(0)" class="change-status"
                                        data-text="{{ __('Do you want to accept this post?') }}">
                                        {{ __('Accept') }}
                                    </a>
                                    <form class="change-status-form"
                                        action="{{ route('posts.update-status', $post->id) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <div class="form-group">
                                            <input type="submit" style="display:none;" class="btn btn-success">
                                        </div>
                                    </form>
                                </td>
                                @elseif ($post->status == config('manual.post_status.Actived'))
                                <td><span class="label label-success">{{ __('Actived') }}</span></td>
                                @else
                                <td><span class="label label-danger">{{ __('Reject') }}</span></td>
                                @endif

                                <td><a href="{{ route('posts.show', $post->id) }}">{{ __('Detail') }}</a></td>
                                <td><a href="{{ route('posts.edit', $post->id) }}">{{ __('Edit') }}</a></td>
                                <td class="wrap-delete-form">
                                    <a href="javascript:void(0)"
                                        data-text="{{ __('Do you want to delete this post?') }}" class="delete">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    <form class="delete-form" action="{{ route('posts.destroy', $post->id) }}"
                                        method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-danger">
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        {{ $posts->links() }}
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
<script src="{{ asset('js/admin/recipes/index.js') }}"></script>
@endsection
