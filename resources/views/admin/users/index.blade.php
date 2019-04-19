@extends('admin.layouts.master')

@section('title', __('Manage Users'))

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
                    <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
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
                    <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
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
                    <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
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
                    <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

        <div class="row">
            <!-- content -->
            <div class="col-xs-12 col-sm-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('User list') }}</h3>
                        <div class="insert-button">
                            <button type="button" class="btn btn-success btn-insert" data-toggle="modal"
                                data-target="#createUser">{{ __('Create New User') }}</button>
                        </div>
                        <!-- Modal insert user -->
                        <div class="modal fade" id="createUser" role="dialog">
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
                                        <form id="create-form" action="{{ route('users.store') }}" method="post">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="name">{{ __('Name') }} <span class="require-star">*</span></label>
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">{{ __('Email address') }} <span class="require-star">*</span></label>
                                                <input type="email" class="form-control" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">{{ __('Phone') }}</label>
                                                <input type="text" class="form-control" name="phone">
                                            </div>
                                            <div class="form-group">
                                                <label for="gender">{{ __('Gender') }}</label>
                                                <select class="form-control" name="gender">
                                                    <option value="male">{{ __('Male') }}</option>
                                                    <option value="female">{{ __('Female') }}</option>
                                                    <option value="other">{{ __('Other') }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="address">{{ __('Address:') }}</label>
                                                <input type="text" class="form-control" name="address">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">{{ __('Permission') }}</label>
                                                <select class="form-control" name="permission">
                                                    <option value="1">{{ __('Admin') }}</option>
                                                    <option value="2">{{ __('User') }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="pwd">{{ __('Password') }} <span class="require-star">{{ __('') }}*</span></label>
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                            <div class="form-group">
                                                <label for="repwd">{{ __('Confirm password') }} <span class="require-star">*</span></label>
                                                <input type="password" class="form-control" name="password_confirmation">
                                            </div>
                                            <button type="submit" class="btn btn-success">{{ __('Create User') }}</button>
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
                        <table class="table table-hover">
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Address') }}</th>
                                <th>{{ __('Permission') }}</th>
                                <th>{{ __('Gender') }}</th>
                            </tr>

                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->address }}</td>
                                @if ($user->permission == config('manual.permission.admin'))
                                <td>{{ __('Admin') }}</td>
                                @else
                                <td>{{ __('User') }}</td>
                                @endif
                                <td>{{ $user->gender }}</td>
                                <td><a href="{{ route('users.edit', ['id'=> $user->id]) }}">{{ __('Edit') }}</a></td>
                                <td>
                                    <!-- <a href="#" class="delete-user">Delete</a> -->
                                    @if ($user->id != Auth::user()->id)
                                    <a href="javascript:void(0)" data-text="{{ __('Do you want to delete this user?') }}" class="delete">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    @endif
                                    <form class="delete-form" action="{{ route('users.destroy', $user->id) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-danger" value="Delete user">
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </table>
                        {{ $users->links() }}
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
