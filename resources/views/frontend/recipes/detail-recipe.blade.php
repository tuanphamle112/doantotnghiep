@extends('frontend.layouts.master')

@section('title', __('Detail recipe'))

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/frontend/detail.css') }}">
@endsection

@section('content')

<div class="wrap clearfix">
    <!--breadcrumbs-->
    <nav role="navigation" class="breadcrumbs">
        <ul>
            <li><a href="{{ route('home') }}" title="Home">{{ __('Home') }}</a></li>
            <li>{{ $recipe->name }}</li>
        </ul>
    </nav>
    <div class="row">
        <div>
            <header class="s-title">
                <h1 itemprop="name" class="entry-title">{{ $recipe->name }}</h1>
            </header>
            <!--content-->
            <section class="content three-fourth">
                <!--recipe-->
                <article class="recipe">
                    <div class="row">
                        <!--one-third-->
                        <div class="one-third entry-header">
                            <div class="rating">
                                <div class="gdrts-rating-block" id="gdrts-unique-id-1">
                                    <div class="gdrts-inner-wrapper">
                                        <div
                                            class="gdrts-stars-rating gdrts-font-star gdrts-stars-length-5 gdrts-with-fonticon gdrts-fonticon-font">
                                            <div class="gdrts-sr-only">
                                                <label>{{ __('Rate this item:') }}
                                                    <div class="selector">
                                                        <span>1.00</span>
                                                        <select class="gdrts-sr-rating">
                                                            <option value="1.00">1.00</option>
                                                            <option value="2.00">2.00</option>
                                                            <option value="3.00">3.00</option>
                                                            <option value="4.00">4.00</option>
                                                            <option value="5.00">5.00</option>
                                                        </select>
                                                    </div>
                                                </label>
                                                <button class="gdrts-sr-button">{{ __('Submit Rating') }}</button>
                                            </div>
                                            <input type="hidden" value="0" name="">
                                            <span class="gdrts-stars-empty">
                                                <span class="gdrts-stars-active"></span>
                                                <span class="gdrts-stars-current"></span>
                                            </span>
                                        </div>
                                        <div class="gdrts-rating-text">{{ __('Rating:') }}
                                            <strong>4.3</strong>{{ __('') }}/5. From 93 votes. </div>
                                    </div>
                                </div>
                            </div>
                            <dl class="basic">
                                <dt>{{ __('Estimate time') }}</dt>
                                <dd>{{ $recipe->estimate_time }}</dd>
                                <dt>{{ __('Difficulty') }}</dt>
                                <dd>
                                    <a href="#">{{ $recipe->level->name }}</a>
                                </dd>
                                <dt>{{ __('Serves') }}</dt>
                                <dd>{{ $recipe->people_number }}</dd>
                            </dl>

                            <dl class="basic user-data">
                                <dt class="first-dt">
                                    {{ __('Posted by') }}
                                </dt>
                                <dd class="vcard author post-author user-avt-post">
                                    <span class="fn">
                                        <a href="{{ route('profile.index', $recipe->user->id) }}">
                                            @if ($recipe->user->avatar != null)
                                            <img src="{{ asset('uploads/avatars/' . $recipe->user->avatar) }}">
                                            @else
                                            <img src="{{ asset(config('manual.default_media.avatar.man')) }}">
                                            @endif

                                            &nbsp;{{ $recipe->user->name }}&nbsp;{{ "(" . $recipe->user->star_num . ")" }}
                                        </a>
                                    </span>
                                </dd>
                                <dt>{{ __('Posted on') }}</dt>
                                <dd class="post-date updated">{{ $createdAtRecipe }}
                                </dd>
                            </dl>

                            <dl class="basic ingredients-data">
                                @foreach ($ingredientArray as $data)
                                @php $ingredient = quantityIngredients($data); @endphp
                                <dt>{{ $ingredient['quantity'] }}</dt>
                                <dd>
                                    <a href="#">{{ $ingredient['name'] }}</a>
                                </dd>
                                @endforeach
                            </dl>
                            @if (Auth::check())
                                @if ($wishlist == null)
                                    <form id="wishlist_form" style="display: none;" data-wishlist="{{ route('wishlist.store') }}" data-method="POST">
                                        {{csrf_field()}}
                                        <input name="user_id" type="text" value="{{Auth::user()->id}}" />
                                        <input name="recipe_id" type="text" value="{{$recipe->id}}" />
                                        <input type="submit" id="submit_heart">
                                    </form>
                                @else
                                    <form id="wishlist_form" style="display: none;" data-wishlist="{{ route('wishlist.destroy', $wishlist->id) }}" data-method="DELETE">
                                        {{ csrf_field() }}
                                        <input name="user_id" type="text" value="{{Auth::user()->id}}" />
                                        <input type="submit" id="submit_heart">
                                    </form>
                                @endif
                            @endif
                            <div class="favorite">
                                <a href="#" id="heart-link"><i class="fa fa-fw fa-heart" @if ($wishlist != null) style="color: red !important" @endif aria-hidden="true"></i>
                                    <span>{{ __('Add to favorites') }}</span></a>
                            </div>
                            
                        
                            <div class="print">
                                <a href="#"><i class="fa fa-fw fa-print" aria-hidden="true"></i>
                                    <span>{{ __('Print recipe') }}</span></a>
                            </div>
                        </div>
                        <!--// one-third -->
                        <!--two-third-->
                        <div class="two-third">
                            <div class="image">
                                @if ($recipe->image != null)
                                <img src="{{ asset(config('manual.recipe_url') . $recipe->image) }}" class="main-img"
                                    alt="{{ $recipe->name }}">
                                @else
                                <img src="{{ config('manual.default_media.recipe') }}" class="main-img"
                                    alt="{{ $recipe->name }}">
                                @endif
                            </div>
                            <div class="intro">
                                <p><strong>{{ $recipe->description }}</strong></p>
                            </div>
                            <div class="instructions">
                                <ol>
                                    @foreach ($cookingSteps as $step)
                                    @if ($step->image != null)
                                    @php $images = explodeComma($step->image); @endphp
                                    @endif
                                    <li>
                                        @if ($step->name != null)
                                        <div class="text"><b>{{ $step->name }}</b></div>
                                        @endif
                                        <div class="text">{{ $step->content }}</div>
                                        <div class="step-info">
                                            @if ($step->time != null)
                                            <span><b>{{ __('Time :') }}</b></span>{{ $step->time }}
                                            {{ __('minutes') }}<br>
                                            @endif
                                            @if ($step->note != null)
                                            <span><b>{{ __('Tips :') }}</b></span>{{ $step->note }} <br>
                                            @endif
                                        </div>
                                        <div class="wrap-step-images">
                                            @if ($step->image != null)
                                            @foreach ($images as $image)
                                            @if (count($images) == 2 || count($images) == 4)
                                            <div class="wrap-single-image step-image-2">
                                                @elseif (count($images) >= 3)
                                                <div class="wrap-single-image step-image-more">
                                                    @else
                                                    <div class="wrap-single-image">
                                                        @endif
                                                        @if ($image != "")
                                                        <img src="{{ asset(config('manual.recipe_url') . $image) }}">
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                    </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                        <!--//two-third-->
                    </div>
                    <!--//row-->
                </article>
                <!--//recipe-->

                <!--comments-->
                <div class="comments" id="comments" itemprop="interactionCount" content="UserComments:2">
                    @if ($comments->count() > 0)
                    <h2> {{ $comments->count() . __(' comments') }}</h2>
                    <ol class="comment-list">
                        <!--single comment-->
                        @foreach ($comments as $comment)
                        <li class="comment clearfix">
                            <div class="avatar">
                                <img alt="" src="{{ asset('uploads/avatars/' . $comment->user->avatar) }}"
                                    class="avatar avatar-90 photo" height="90" width="90">
                            </div>
                            <div class="comment-box">
                                <div class="comment-author meta">
                                    <strong><a href="{{ route('profile.index', $comment->user->id) }}"
                                            class="url">{{ $comment->user->name }}</a></strong><br>
                                    {{ $comment->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a') }}
                                    @if (Auth::check())
                                    @if ($comment->user->id == Auth::user()->id);
                                    <div class="wrap-delete-form">
                                        <div class="wrap-comment-button">
                                            <a class="comment-reply-link edit" href="#">Edit</a>
                                            <a class="comment-reply-link delete"
                                                data-text="{{ __('Do you want to delete this comment?') }}"
                                                href="#">Delete</a>
                                            <form class="delete-form" action="{{ route('comment.delete', $comment->id) }}"
                                                method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <div class="form-group">
                                                    <input type="hidden" name="comment_type" value="recipe">
                                                    <input type="submit" class="btn btn-danger">
                                                </div>
                                            </form>
                                        </div>
                                        <!-- show when edit comment -->
                                        <div class="wrap-open-edit">
                                            <a class="comment-reply-link save-comment" href="#">Save</a>
                                            <a class="comment-reply-link delete cancel-comment" href="#">Cancel</a>
                                        </div>
                                    </div>
                                    @else
                                    <a class="comment-reply-link reply" data-owner-comment="{{ $comment->user->name }}"
                                        href="#">Reply</a>
                                    @endif
                                    @endif
                                </div>
                                <div class="comment-text">
                                    <p class="comment-view">{{ $comment->content }}</p>
                                    @if (Auth::check() && Auth::user()->id == $comment->user->id)
                                        <form action="{{ route('comment.edit', $comment->id) }}" name="edit_comment" class="edit-comment-form" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <div class="f-row">
                                                <textarea name="content_edited" rows="10" cols="10">{{ $comment->content }}</textarea>
                                            </div>
                                            <button class="submit-edit-comment" style="display:none">Submit</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </li>
                        @endforeach
                        <!--//single comment-->
                    </ol>
                    @endif

                    <div id="respond" class="comment-respond">
                        <h3 id="reply-title" class="comment-reply-title">{{ __('Leave a Reply ') }}</h3>
                        <form data-recipe="{{ route('comment.store', $recipe->id) }}" @if (Auth::check())
                            data-user-link="{{ route('profile.index', Auth::user()->id) }}" @endif id="commentform"
                            class="comment-form">
                            <div class="container">
                                @if (Auth::check())
                                <p>{{ __('Logged in as') }} <a
                                        href="{{ route('profile.index', Auth::user()->id) }}">{{ Auth::user()->name }}</a>
                                </p>
                                <div class="f-row">
                                    <textarea id="comment" name="comment" rows="10" cols="10"></textarea>
                                </div>
                                <div class="filling-error">{{ __('Comment field are require') }}</div>
                                <p class="form-submit"><input name="submit" type="submit" class="submit"
                                        value="Post Comment">
                                </p>
                                @else
                                <p>{{ __('You have to') }} <a href="{{ route('login') }}">{{ __('login') }}</a>
                                    {{ __('to leave a comment') }}</p>
                                @endif
                            </div>
                        </form>
                    </div><!-- #respond -->
                    <!--//post comment form-->
                </div>
                <!--comments-->
                <!--//recipe entry-->
            </section>
        </div>
        <!--//hentry-->
    </div>
    <!--//row-->
</div>
<!--//wrap-->
@endsection

@section('script')
@parent
<script src="{{ asset('js/frontend/recipes/detail.js') }}"></script>
@endsection
