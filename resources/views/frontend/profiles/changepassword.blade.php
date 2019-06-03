@extends('frontend.layouts.master')

@section('title', __('Profile'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/general.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/profile/custom.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
@endsection

@section('content')

<div class="wrap clearfix">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ __('Change password') }}</div>
                <div class="panel-body" style="padding: 40px !important">
                    @if (session('error'))
                    <div class="filling-error active">
                        {{ session('error') }}
                    </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                            <label for="new-password" class="control-label">{{ __('Current Password') }}</label>
                            <input id="current-password" type="password" class="form-control" name="current-password"
                                required>
                            @if ($errors->has('current-password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('current-password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                            <label for="new-password" class="control-label">{{ __('New Password') }}</label>

                            <input id="new-password" type="password" class="form-control" name="new-password" required>

                            @if ($errors->has('new-password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('new-password') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="new-password-confirm"
                                class="control-label">{{ __('Confirm New Password') }}</label>

                            <input id="new-password-confirm" type="password" class="form-control"
                                name="new-password_confirmation" required>
                        </div>

                        <div class="f-row full center-input update-user" style="margin-left:-60px">
                            <input type="submit" value="{{ __('Change Password') }}" name="updateInfo" id="submit-user"
                                class="button">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
@parent
<script src="{{ asset('messages.js') }}"></script>
<script src="{{ asset('js/frontend/profile/my-profile.js') }}"></script>
<script src="{{ asset('bower_components/jquery-highlight/jquery.highlight.js') }}"></script>
@endsection
