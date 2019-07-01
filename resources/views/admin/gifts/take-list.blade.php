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
                        <h3 class="box-title">{{ __('Gift Exchange List') }}</h3>
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
                                <th>{{ __('Take By') }}</th>
                                <th>{{ __('Take at') }}</th>
                                <th>{{ __('Quantity Left') }}</th>
                                <th>{{  __('Status')}}</th>
                            </tr>

                            @foreach ($takeList as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    <img width="20%" data-enlargable width="100" style="cursor: zoom-in"
                                        class="image-gift" src="{{ asset('uploads/gifts/' . $item->gift->image) }}">
                                </td>
                                <td>{{ $item->gift->name }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->gift->quantity }}</td>
                                @if ($item->status == config('manual.gift_status.Pendding'))
                                <td><span class="label label-warning">{{ __('Pendding') }}</span></td>
                                <td class="wrap-status-form">
                                    <a href="javascript:void(0)" class="change-status"
                                        data-text="{{ __('Are you sure that you shipped?') }}">
                                        {{ __('Mask as shipped') }}
                                    </a>
                                    <form class="change-status-form"
                                        action="{{ route('gift.update-status', $item->id) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <div class="form-group">
                                            <input type="submit" style="display:none;" class="btn btn-success">
                                        </div>
                                    </form>
                                </td>
                                @else
                                <td><span class="label label-success">{{ __('Shipped') }}</span></td>
                                @endif
                            </tr>
                            @endforeach

                        </table>
                        {{ $takeList->links() }}
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
