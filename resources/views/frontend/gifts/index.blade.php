@extends('frontend.layouts.master')

@section('title', __('My recipe'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/create-recipe/general.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/gifts/custom.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
@endsection

@section('content')

<div class="wrap clearfix">
    <!--breadcrumbs-->
    <nav role="navigation" class="breadcrumbs">
        <ul>
            <li><a href="{{ route('home') }}">'{{ __('Home') }}</a></li>
            <li>{{ __('Gifts List') }}</li>
        </ul>
    </nav>
    <div class="row">
        <header class="s-title">
            <h1>{{ __('Gifts') }}</h1>
        </header>
        <section class="content full-width">
            <div class="entries row">
                <!--item-->
                @foreach ($gifts as $gift)
                <div class="entry one-fourth recipe-item">
                    <figure>
                        @if ($gift->image != null)
                        <img src="{{ asset('uploads/gifts/' . $gift->image) }}">
                        @else
                        <img src="{{ config('manual.default_media.recipe') }}" alt="{{ $gift->name }}">
                        @endif
                    </figure>
                    <div class="container">
                        <h2>
                            <p>{{ $gift->name }}</p>
                        </h2>
                        <div class="actions">
                            <div>
                                <div>
                                    <div class="date">Get with {{ $gift->star_point }} <i class="fa fa-star" style="#e68609"></i></div>
                                </div>
                                <div class="comments">
                                    {{ $gift->quantity }} left
                                </div>
                            </div>
                        </div>
                        <div class="excerpt">
                            <p>{{ $gift->description }}</p>
                        </div>
                        <div class="actions">
                            <div class="gift-choose" style="text-align:center">
                                <a href="{{ route('gift.confirm', $gift->id) }}" style="width:100%">I take this</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!--item-->
            </div>
        </section>
    </div>
    <!--//row-->
</div>
{{ $gifts->links() }}

@endsection

@section('script')
@parent
<script src="{{ asset('messages.js') }}"></script>
<script src="{{ asset('bower_components/jquery-highlight/jquery.highlight.js') }}"></script>
@endsection
