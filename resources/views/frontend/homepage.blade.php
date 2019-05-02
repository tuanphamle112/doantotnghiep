@extends('frontend.layouts.master')

@section('title', __('Home page'))

@section('content')
<!--intro-->
<div class="intro">
    <!--wrap-->
    <div class="wrap clearfix">
        <!--row-->
        <div class="row">
            <div id="socialchef_home_intro_widget-2" class="socialchef_home_intro_widget three-fourth text">
                <h1>{{ __('Welcome to Tpl@ Cooking') }}!</h1>
                <p>{{ __('custom.home_intro') }}</p>
                <p>{{ __('You will also get a chance to win awesome prizes, make new friends and share delicious recipes.') }}
                </p><a href="{{ route('register') }}"
                    class="button white more medium">{{ __('Explore our community') }}<i class="fa fa-chevron-right"
                        aria-hidden="true"></i></a>
                <p>{{ __('Already a member? Click') }} <a
                        href="{{ route('login') }}">{{ __('here') }}</a>{{ __(' to login.') }}
                </p>
            </div>
            <div id="socialchef_search_widget-3" class="socialchef_search_widget one-fourth">
                <div class="container">
                    <div class="textwrap">
                        <h5>{{ __('Refine search results') }}</h5>
                        <p>{{ __('custom.search_term') }}</p>
                        <p>{{ __('Enjoy!') }}</p>
                    </div>
                    <form method="get" action="#">
                        <div class="f-row">
                            <input type="text" name="term" placeholder="{{ __('Enter your search term') }}">
                        </div>
                        <div class="f-row">
                            <div class="selector"><span>{{ __('Select category') }}</span>
                                <select name="cat">
                                    <option value="0">{{ __('Select category') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="selector"><span>{{ __('Select difficulty') }}</span>
                            <select name="diff">
                                <option value="0">{{ __('Select difficulty') }}</option>
                            </select>
                        </div>
                </div>
                <div class="f-row bwrap">
                    <input type="submit" value="{{ __('Start cooking!') }}">
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<div class="wrap clearfix">
    <!--row-->
    <div class="row">
        <!--content-->
        <section class="content full-width">
            <div class="icons dynamic-numbers">
                <header class="s-title">
                    <div class="ribbon large">
                        <div>
                            <h2>{{ __('Tpl@ Cooking in numbers') }}</h2>
                        </div>
                    </div>
                </header>

                <!--row-->
                <div class="row">
                    <!--item-->
                    <div class="one-sixth">
                        <div class="container">
                            <i class="icon icon-themeenergy_chef-hat"></i>
                            <span class="title dynamic-number" data-dnumber="494">494</span>
                            <span class="subtitle">{{ __('Members') }}</span>
                        </div>
                    </div>
                    <!--//item-->

                    <!--item-->
                    <div class="one-sixth">
                        <div class="container">
                            <i class="icon icon-themeenergy_pan"></i>
                            <span class="title dynamic-number" data-dnumber="16">16</span>
                            <span class="subtitle">{{ __('Recipes') }}</span>
                        </div>
                    </div>
                    <!--//item-->

                    <!--item-->
                    <div class="one-sixth">
                        <div class="container">
                            <i class="icon icon-themeenergy_image"></i>
                            <span class="title dynamic-number" data-dnumber="284">284</span>
                            <span class="subtitle">{{ __('photos') }}</span>
                        </div>
                    </div>
                    <!--//item-->

                    <!--item-->
                    <div class="one-sixth">
                        <div class="container">
                            <i class="icon icon-themeenergy_pencil"></i>
                            <span class="title dynamic-number" data-dnumber="13">13</span>
                            <span class="subtitle">{{ __('forum posts') }}</span>
                        </div>
                    </div>
                    <!--//item-->

                    <!--item-->
                    <div class="one-sixth">
                        <div class="container">
                            <i class="icon icon-themeenergy_chat-bubbles"></i>
                            <span class="title dynamic-number" data-dnumber="56">56</span>
                            <span class="subtitle">{{ __('comments') }}</span>
                        </div>
                    </div>
                    <!--//item-->

                    <!--item-->
                    <div class="one-sixth">
                        <div class="container">
                            <i class="icon icon-themeenergy_stars"></i>
                            <span class="title dynamic-number" data-dnumber="10">10</span>
                            <span class="subtitle">{{ __('articles') }}</span>
                        </div>
                    </div>
                    <!--//item-->
                    <div class="cta">
                        <a href="{{ route('register') }}" class="button big">{{ __('Join us!') }}</a>
                    </div>
                </div>
                <!--//row-->
            </div>
        </section>
        <!--//content-->
        <section class="content three-fourth">
            <!--cwrap-->
            <div class="cwrap">
                <!--entries-->
                <div class="entries row">
                    <div class="featured two-third">
                        <header class="s-title">
                            <div class="ribbon bright">
                                <div>
                                    <h2>{{ __('Featured recipe') }}</h2>
                                </div>
                            </div>
                        </header>
                        <article class="entry">
                            <figure>
                                <img src="{{ asset('uploads/recipes/' . $featureRecipe->image) }}"
                                    alt="{{ $featureRecipe->name }}">
                                <figcaption><a href="#"><i class="icon icon-themeenergy_eye2"></i>
                                        <span>{{ __('View recipe') }}</span></a>
                                </figcaption>
                            </figure>

                            <div class="container">
                                <h2><a href="#">{{ $featureRecipe->name }}</a></h2>
                                <p>{{ $featureRecipe->description }}</p>
                                <div class="actions">
                                    <div>
                                        <a href="#" class="button">{{ __('See the full recipe') }}</a>
                                        <div class="more"><a href="#">{{ __('See past featured recipes') }}</a></div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <!--/featured-->
                    <div class="featured one-third">
                        <header class="s-title">
                            <div class="ribbon bright">
                                <div>
                                    <h2>{{ __('Featured member') }}</h2>
                                </div>
                            </div>
                        </header>
                        <article class="entry">
                            <figure>
                                <a href="#"><img src="{{ config('manual.default_media.avatar.man') }}"
                                        class="avatar user-1-avatar avatar-270 photo" width="270" height="270"
                                        alt="{{ __('Profile Photo') }}"></a>
                                <figcaption><a href="#"><i class="icon icon-themeenergy_eye2"></i>
                                        <span>{{ __('View member') }}</span></a>
                                </figcaption>
                            </figure>
                            <div class="container">
                                <h2>
                                    <a href="#">{{ $featureMember->name }}</a>
                                </h2>
                                <blockquote>
                                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                                    {{ __('custom.member_quote') }}
                                </blockquote>
                                <div class="actions">
                                    <div>
                                        <a href="#" class="button">{{ __('Recipes by this user') }}</a>
                                        <div class="more"><a href="#">{{ __('See past featured members') }}</a></div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <!--/featured-->

                </div>
                <!--//entries-->
            </div>
            <!--//cwrap-->
            <!--cwrap-->
            <div class="cwrap">
                <header class="s-title">
                    <div class="ribbon bright">
                        <div>
                            <h2>{{ __('Latest recipes') }}</h2>
                        </div>
                    </div>
                </header>
                <!--entries-->
                <div class="entries row">
                    <!--item-->
                    @foreach ($allActiveRecipes as $activeRecipe)
                    <div class="entry one-third recipe-item">
                        <figure>
                            <img src="{{ asset('uploads/recipes/' . $activeRecipe->image) }}">
                            <figcaption>
                                <a href="#"><i class="icon icon-themeenergy_eye2"></i>
                                    <span>{{ __('View recipe') }}</span></a>
                            </figcaption>
                        </figure>
                        <div class="container">
                            <h2>
                                <a href="#">{{ $activeRecipe->name }}</a>
                            </h2>
                            <div class="actions">
                                <div>
                                    @if ($activeRecipe->level->name == "Easy")
                                    <div class="difficulty"><i class="ico i-easy"></i> {{ $activeRecipe->level->name }}
                                    </div>
                                    @elseif ($activeRecipe->level->name == "Normal")
                                    <div class="difficulty"><i class="ico i-moderate"></i>
                                        {{ $activeRecipe->level->name }}</div>
                                    @else
                                    <div class="difficulty"><i class="ico i-hard"></i> {{ $activeRecipe->level->name }}
                                    </div>
                                    @endif
                                    <div class="comments"><i class="fa fa-comment" aria-hidden="true"></i><a
                                            href="">0</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="quicklinks">
                        <a href="#" class="button show-more-recipes">{{ __('More recipes') }}</a>
                        <a href="javascript:void(0)" class="button scroll-to-top">{{ __('Back to top') }}</a>
                    </div>
                </div>
            </div>
            <!--//cwrap-->
            <!--cwrap-->
            <div class="cwrap">
                <header class="s-title">
                    <div class="ribbon bright">
                        <div>
                            <h2>{{ __('Latest posts') }}</h2>
                        </div>
                    </div>
                </header>
                <!--entries-->
                <div class="entries row">
                    <!--item-->
                    @foreach ($allActiveRecipes as $activeRecipe)
                    <div class="entry one-third post-item">
                        <figure>
                            <img src="{{ asset('uploads/recipes/' . $activeRecipe->image) }}"
                                alt="{{ $activeRecipe->name }}">
                            <figcaption><a href="#"><i class="icon icon-themeenergy_eye2"></i>
                                    <span>{{ __('View post') }}</span></a>
                            </figcaption>
                        </figure>
                        <div class="container">
                            <h2><a href="#">{{ $activeRecipe->name }}</a></h2>
                            <div class="actions">
                                <div>
                                    <div class="date"><i class="fa fa-calendar"
                                            aria-hidden="true"></i>{{ __('December 13, 2014') }}</div>
                                    <div class="comments"><i class="fa fa-comment" aria-hidden="true"></i><a
                                            href="#">0</a>
                                    </div>
                                </div>
                            </div>
                            <div class="excerpt">
                                <p>{{ $activeRecipe->description }}</p>
                            </div>
                        </div>
                    </div>
                    <!--item-->
                    @endforeach
                    <div class="quicklinks">
                        <a href="#" class="button">{{ __('More posts') }}</a>
                        <a href="javascript:void(0)" class="button scroll-to-top">{{ __('Back to top') }}</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--//row-->
</div>
<!--//wrap-->
@endsection

@section('script')

@parent

@endsection
