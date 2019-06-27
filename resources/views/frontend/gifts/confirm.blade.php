@extends('frontend.layouts.master')

@section('title', __('My recipe'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/gifts/confirm.css') }}">  
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
@endsection

@section('content')

<div class="wrap clearfix">
    <!--breadcrumbs-->
    <nav role="navigation" class="breadcrumbs">
        <ul>
            <li><a href="{{ route('home') }}">'{{ __('Home') }}</a></li>
            <li>{{ __('Gifts Confirm') }}</li>
        </ul>
    </nav>
    <div class="row">
        <section class="content full-width">
            <div class="submit_recipe container">
                @if ($errors->any())
                    <div class="filling-error error-exist">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="#" class="wrap-create-form" method="post">
                    {{ csrf_field() }}
                    <div class="wrap-main-image">
                        <div class="wrap-note">
                            <label for="note" style="margin-bottom:20px; margin:auto;">
                                <b style="color:red">Note:</b> You are try to change <span style="color: red">{{ $gift->star_point }}</span>  
                                <i class="fa fa-star" style="color:#e68609"></i> to take this. Make sure all these information below are correct!
                            </label>
                        </div>

                        <div class="wrap-item-confirm">
                            <div class="confirm-item confirm-gift">
                                <img src="{{ asset('uploads/gifts/' . $gift->image) }}" alt="{{ $gift->name }}">
                                <div class="gift-info">
                                    <span><b>{{ $gift->name }}</b></span>
                                    <p>{{ $gift->description }}</p>
                                </div>
                            </div>
                            <div class="confirm-item confirm-user">
                                <div class="user-info-gift">
                                    @if ($user->avatar !== null)
                                    <img src="{{ asset('uploads/avatars/' . $user->avatar) }}"
                                        width="270"
                                        height="270"
                                        alt="{{ __('Profile Photo') }}">
                                    <a href="{{ route('profile.index', $user->id) }}">{{ $user->name }}</a>
                                    @else
                                    <img src="{{ config('manual.default_media.avatar.man') }}"
                                        width="270"
                                        height="270"
                                        alt="{{ __('Profile Photo') }}">
                                    <a href="{{ route('profile.index', $user->id) }}">{{ $user->name }}</a>
                                    @endif
                                </div>
                                
                            </div>

                            
                        </div>
                        <div class="form-group recipe-description">
                            <label for="description">{{ __('Your Phone Number') }}</label>
                            <input type="number" name="phone"  placeholder="Your phone here..." value="{{ $user->phone }}">
                        </div>
                        <div class="form-group recipe-description">
                            <label for="description">{{ __('Your Address') }}</label>
                            <input type="text" name="address" value="{{ $user->address }}">
                        </div>
                    </div>
                    <div class="f-row full center-input">
                        <input type="submit" class="button">
                    </div>
                </form>
            </div>
        </section>
        </div>
    <!--//row-->
</div>

@endsection

@section('script')
@parent
<script src="{{ asset('messages.js') }}"></script>
@endsection
