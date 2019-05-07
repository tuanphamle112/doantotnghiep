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
                                        <div class="gdrts-stars-rating gdrts-font-star gdrts-stars-length-5 gdrts-with-fonticon gdrts-fonticon-font">
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
                                        <div class="gdrts-rating-text">{{ __('Rating:') }} <strong>4.3</strong>{{ __('') }}/5. From 93 votes. </div>
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

                            <dl class="user">
                                <dt>{{ __('Posted by') }}</dt>
                                <dd class="vcard author post-author"><span class="fn"><a href="#">{{ $recipe->user->name }}</a></span>
                                </dd>
                                <dt>{{ __('Posted on') }}</dt>
                                <dd class="post-date updated">{{ $createdAtRecipe }}
                                </dd>
                            </dl>
                            
                            <dl class="ingredients">
                                @foreach ($ingredientArray as $data)
                                @php  $ingredient = quantityIngredients($data); @endphp
                                <dt>{{ $ingredient['quantity'] }}</dt>
                                <dd>
                                    <a href="#">{{ $ingredient['name'] }}</a>
                                </dd>
                                @endforeach
                            </dl>
                            <div class="favorite">
                                <a href="javascript:void(0);"><i class="fa fa-fw fa-heart" aria-hidden="true"></i>
                                    <span>{{ __('Add to favorites') }}</span></a>
                            </div>
                            <div class="print">
                                <a href="#"><i class="fa fa-fw fa-print" aria-hidden="true"></i> <span>{{ __('Print recipe') }}</span></a>
                            </div>
                        </div>
                        <!--// one-third -->
                        <!--two-third-->
                        <div class="two-third">
                            <div class="image">
                                @if ($recipe->image != null)
                                <img src="{{ asset(config('manual.recipe_url') . $recipe->image) }}" alt="{{ $recipe->name }}">
                                @else
                                <img src="{{ config('manual.default_media.avatar.man') }}" alt="{{ $recipe->name }}">
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
                                            <span><b>{{ __('Time :') }}</b></span>{{ $step->time }} {{ __('minutes') }}<br>
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
                    <h2>{{ __('2 comments') }}</h2>
                    <ol class="comment-list">
                        <!--single comment-->
                        <li class="comment clearfix">
                            <div class="avatar">
                                <img alt="" src="#" class="avatar avatar-90 photo" height="90" width="90">
                            </div>
                            <div class="comment-box">
                                <div class="comment-author meta">
                                    <strong><a href="#" class="url">{{ __('admin') }}</a></strong> {{ __('said on December 10, 2014') }} <a class="comment-reply-link reply" href="#">Reply</a> </div>
                                <div class="comment-text">
                                    <p>{{ __('This is an awesome recipe. I cannot wait to try it out!') }}</p>
                                </div>
                            </div>
                            <ol class="children">
                                <!--single comment-->
                                <li class="comment byuser comment-author-admin bypostauthor odd alt depth-2 clearfix"
                                    id="article-comment-29">
                                    <div class="avatar">
                                        <img alt="" src="#" class="avatar avatar-90 photo" height="90" width="90">
                                        <div class="comment-meta commentmetadata"></div>
                                    </div>
                                    <div class="comment-box">
                                        <div class="comment-author meta">
                                            <strong><a href="#" class="url">{{ __('admin') }}</a></strong> {{ __('said on December 10, 2014 ') }}<a href="#">{{ __('Reply') }}</a></div>
                                        <div class="comment-text">
                                            <p>{{ __('I have made this for dinner last night and it tasted amazing!') }}</p>
                                        </div>
                                    </div>
                                </li>
                                <!--//single comment-->
                            </ol><!-- .children -->
                        </li>
                        <!--//single comment-->
                    </ol>
                    <div id="respond" class="comment-respond">
                        <h3 id="reply-title" class="comment-reply-title">{{ __('Leave a Reply ') }}<small><a id="cancel-comment-reply-link" href="#">{{ __('Cancel reply') }}</a></small></h3>
                        <form action="#" method="post" id="commentform" class="comment-form">
                            <div class="container">
                                <p>{{ __('Logged in as') }} <a href="#">{{ __('Pham Le Tuan') }}</a>.<a href="#">{{ __('Log out »') }}</a></p>
                                <div class="f-row">
                                    <textarea id="comment" name="comment" rows="10" cols="10"></textarea>
                                </div>
                                <p class="form-submit"><input name="submit" type="submit" class="submit" value="Post Comment">
                                    <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                                </p>
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

@endsection
