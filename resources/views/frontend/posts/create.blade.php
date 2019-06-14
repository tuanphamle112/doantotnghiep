@extends('frontend.layouts.master')

@section('title', __('Create recipe'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/posts/create-post.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
@endsection

@section('content')

<div class="wrap clearfix">
    <!--breadcrumbs-->
    <nav role="navigation" class="breadcrumbs">
        <ul>
            <li><a href="{{ route('home') }}" title="Home">'{{ __('Home') }}</a></li>
            <li>{{ __('Create Post') }}</li>
        </ul>
    </nav>
    <div class="row">
        <section class="content full-width">
            <div class="container">
                <form action="{{ route('posts.store') }}" enctype="multipart/form-data" class="wrap-create-form" method="post">
                    {{ csrf_field() }}
                    <div class="wrap-main-image">
                        <div class="input-group">
                            <label class="mainFileContainer">
                                <i class="fa fa-camera"></i>
                                <span>{{ __('Click to add a main picture') }}</span>
                                <img id="img-upload" alt="">
                                <input type="file" id="imgInp" class="pro-image" name="main_image"
                                    class="form-control">
                            </label>
                        </div>
                        
                        <div class="form-group title">
                            <label for="name">{{ __('Post\'s title') }}</label>
                            <input type="text" class="form-control input-error" placeholder="{{ __('Post\'s title') }}"
                                name="title">
                        </div>
                        <div class="form-group description">
                            <label for="description">{{ __('Short description') }}</label>
                            <textarea type="text" class="form-control input-error" name="description"
                                placeholder="{{ __('Your short description here...') }}" rows="6"></textarea>
                        </div>
                        <textarea id="editor1" name="content" rows="10" cols="80">
                        </textarea>
                    </div>
                    <div class="f-row full center-input">
                        <input type="submit" value="{{ __('Submit') }}" name="submitPost" id="submit_post" class="button">
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
<script src="{{ asset('/bower_components/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/js/frontend/posts/create-post.js') }}"></script>
<script>
    CKEDITOR.replace( 'content' );
</script>
@endsection
