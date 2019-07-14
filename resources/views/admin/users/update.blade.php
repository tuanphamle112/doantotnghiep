@extends('admin.layouts.master')

@section('title', __('Update Users'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/admin/users/update-user.css') }}">
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
                    <h5>{{ __('Update User Information :') }}</h5>
                    <div class="wrap-form-update">
                        @if ($errors->any())
                        <div class="filling-error error-exist">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form action="{{ route('users.update', $user->id) }}" method="post">
                            @method('PUT')
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email address') }}</label>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                            </div>
                            <div class="form-group">
                                <label for="gender">{{ __('Gender') }}</label>
                                <select class="form-control" name="gender">
                                    <option value="female" @if ($user->gender == "female") selected @endif>{{ __('Female') }}</option>
                                    <option value="male" @if ($user->gender == "male") selected @endif>{{ __('Male') }}</option>
                                    <option value="other" @if ($user->gender == "other") selected @endif>{{ __('Other') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">{{ __('Address') }}</label>
                                <input type="text" class="form-control" name="address" value="{{ $user->address }}">
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('Permission') }}</label>
                                <select class="form-control" name="permission">
                                    <option value="1" @if ($user->permission == 1) selected @endif>{{ __('Admin') }}</option>
                                    <option value="2" @if ($user->permission == 2) selected @endif>{{ __('User') }}</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">{{ __('Update User') }}</button>
                        </form>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- end content -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('script')

@parent
@endsection
