@extends('frontend.layouts.master')

@section('title', __('Edit Post'))

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
            <li>{{ __('Edit Post') }}</li>
        </ul>
    </nav>
    <div class="row">
        <section class="content full-width">
            <div class="container">
                <form action="{{ route('my-posts.update', $post->id) }}" enctype="multipart/form-data" class="wrap-create-form"
                    method="post">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="wrap-main-image">
                        <div class="input-group">
                            <label class="mainFileContainer">
                                <i class="fa fa-camera"></i>
                                <span class="main-pic">{{ __('Click to add a main picture') }}</span>
                                @if ($post->image != null)
                                <img id="img-upload" src="{{ asset(config('manual.posts_url') . $post->image) }}" alt="{{ $post->title }}" style="width:100%; height:300px !important;">
                                @else
                                <img id="img-upload" src="{{ asset(config('manual.default_media.recipe')) }}" alt="{{ $post->title }}">
                                @endif
                                <input type="file" id="imgInp" class="pro-image" name="main_image" class="form-control">
                                <input type="hidden" name="post_image_old" value="{{ $post->image }}">
                            </label>
                        </div>

                        <div class="form-group title">
                            <label for="name">{{ __('Post\'s title') }}</label>
                            <input type="text" class="form-control input-error" placeholder="{{ __('Post\'s title') }}"
                                name="title" value="{{ $post->title }}">
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        </div>
                        <div class="form-group description">
                            <label for="description">{{ __('Short description') }}</label>
                            <textarea type="text" class="form-control input-error" name="description"
                                placeholder="{{ __('Your short description here...') }}" rows="6">{{ $post->description }}</textarea>
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        </div>
                        <div class="form-group wrap-categories">
                            <label for="description">{{ __('Select Categories') }}</label>
                            <div class="categories-list">
                                @foreach ($allCategories as $category)
                                <label class="checkbox-item">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                    @foreach ($postCategories as $cate)
                                        @if ($cate->id == $category->id) checked @endif
                                    @endforeach
                                    />
                                    <span class="label-text">{{ $category->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <span class="text-danger">{{ $errors->first('categories') }}</span>
                        <textarea id="editor1" name="content" rows="10" cols="80">
                        {{ $post->content }}
                        </textarea>
                        <span class="text-danger">{{ $errors->first('content') }}</span>
                    </div>
                    <div class="f-row full center-input">
                        <input type="submit" value="{{ __('Submit') }}" name="submitPost" id="submit_post"
                            class="button">
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
    CKEDITOR.replace('content');

</script>
@endsection
