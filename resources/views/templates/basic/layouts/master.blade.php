<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ $general->sitename(__($pageTitle)) }}</title>
    @include('partials.seo')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/fontawesome-all.min.css')}}">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <!-- video css links -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/video-js.css')}}">
    <!-- swipper css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/swiper.min.css')}}">
    <!-- line-awesome-icon css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.css')}}">
    <!-- main style css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/style.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/color.php?color='.$general->base_color)}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap-fileinput.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    @stack('style-lib')

    @stack('style')
</head>
<body>

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="preloader">
    <div class="loader">
        <div class="camera__wrap">
            <div class="camera__body">
                <div class="camera__body-k7">
                    <div class="tape">
                        <div class="roll"></div>
                        <div class="roll"></div>
                        <div class="roll"></div>
                        <div class="roll"></div>
                        <div class="center"></div>
                    </div>
                    <div class="tape">
                        <div class="roll"></div>
                        <div class="roll"></div>
                        <div class="roll"></div>
                        <div class="roll"></div>
                        <div class="center"></div>
                    </div>
                </div>
                <div class="camera__body__stuff">
                    <div class="camera__body__stuff-bat"></div>
                    <div class="camera__body__stuff-pointer first"></div>
                    <div class="camera__body__stuff-pointer"></div>
                </div>
            </div>
            <div class="camera__body-optic"></div>
            <div class="camera__body-light"></div>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<header class="header-section">
    <div class="header">
        <div class="header-bottom-area">
            <div class="container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0">
                        <a class="site-logo site-title" href="{{route('home')}}"><img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="site-logo"></a>
                        <div class="search-bar d-block d-lg-none ml-auto">
                            <a href="#0"><i class="fas fa-search"></i></a>
                            <div class="header-top-search-area">
                                <form class="header-search-form" action="{{ route('search') }}">
                                    <input type="search" name="search" placeholder="@lang('Search here')...">
                                    <button class="header-search-btn" type="submit"><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu ml-auto mr-auto">
                                <li><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                                <li><a href="{{ route('user.deposit.history') }}">@lang('Payments')</a></li>
                                <li><a href="#0">@lang('Ticket') <i class="fas fa-caret-down"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="{{route('ticket.open')}}">@lang('Create New')</a></li>
                                        <li><a href="{{route('ticket')}}">@lang('My Ticket')</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="search-bar d-none d-lg-block">
                                <a href="#0"><i class="fas fa-search"></i></a>
                                <div class="header-top-search-area">
                                    <form class="header-search-form" action="{{ route('search') }}">
                                        <input type="search" name="search" placeholder="@lang('Search here')...">
                                        <button class="header-search-btn" type="submit"><i class="fas fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="header-bottom-right">
                                <div class="language-select-area">
                                    <select class="language-select langSel" id="langSel">
                                        @foreach($language as $lang)
                                            <option value="{{$lang->code}}" @if(Session::get('lang') === $lang->code) selected  @endif>{{ __($lang->code) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="header-right dropdown">
                                <button type="button" class="" data-toggle="dropdown" data-display="static" aria-haspopup="true"
                                        aria-expanded="false">
                                    <div class="header-user-area d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="header-user-content">
                                            <span>@lang('Account')</span>
                                        </div>
                                        <span class="header-user-icon"><i class="las la-chevron-circle-down"></i></span>
                                    </div>
                                </button>
                                <div class="dropdown-menu dropdown-menu--sm p-0 border-0 dropdown-menu-right">
                                    <a href="{{ route('user.profile.setting') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                        <i class="dropdown-menu__icon las la-user-circle"></i>
                                        <span class="dropdown-menu__caption">@lang('Profile Settings')</span>
                                    </a>
                                    <a href="{{ route('user.change.password') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                        <i class="dropdown-menu__icon las la-key"></i>
                                        <span class="dropdown-menu__caption">@lang('Change Password')</span>
                                    </a>
                                    <a href="{{ route('user.twofactor') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                        <i class="dropdown-menu__icon las la-lock"></i>
                                        <span class="dropdown-menu__caption">@lang('2FA Security')</span>
                                    </a>
                                    <a href="{{ route('user.logout') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                        <i class="dropdown-menu__icon las la-sign-out-alt"></i>
                                        <span class="dropdown-menu__caption">@lang('Logout')</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Scroll-To-Top
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<a href="#" class="scrollToTop"><i class="las la-angle-double-up"></i></a>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Scroll-To-Top
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@include($activeTemplate.'breadcrumb')


@yield('content')


@php
    $footer_content = getContent('footer.content', true);
    $footer_elements = getContent('footer.element');
    $extra_pages = getContent('extra.element');
    $short_links = getContent('short_links.element');
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Footer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<footer class="footer-section footer pt-80 bg-overlay-black bg_img @if(request()->routeIs('home') || request()->routeIs('category') || request()->routeIs('subCategory') || request()->routeIs('search')) d-none @endif" data-background="{{ getImage('assets/images/frontend/footer/' . @$footer_content->data_values->background_image, '1920x789') }}">
    <div class="container">
        <div class="footer-top-area d-flex flex-wrap align-items-center justify-content-between">
            <div class="footer-logo">
                <a href="{{ route('home') }}" class="site-logo"><img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="logo"></a>
            </div>
            <div class="social-area">
                <ul class="footer-social">
                    @forelse($footer_elements as $item)
                        <li><a href="{{ @$item->data_values->social_link }}" target="_blank">@php echo @$item->data_values->social_icon @endphp</a></li>
                    @empty
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="footer-bottom-area">
            <div class="row justify-content-center mb-30-none">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-30">
                    <div class="footer-widget">
                        <h3 class="widget-title">@lang('About Us')</h3>
                        <p>{{ __(@$footer_content->data_values->about_us) }}</p>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 mb-30">
                    <div class="footer-widget">
                        <h3 class="widget-title">@lang('Categories')</h3>
                        <ul class="footer-links">
                            @foreach($categories as $category)
                                <li><a href="{{ route('category',$category->id) }}">{{ __($category->name) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 mb-30">
                    <div class="footer-widget">
                        <h3 class="widget-title">@lang('Short Links')</h3>
                        <ul class="footer-links">

                            @forelse($short_links as $link)
                                <li><a href="{{ route('links',[$link->id,slug($link->data_values->title)]) }}">{{ __($link->data_values->title) }}</a></li>
                            @empty
                            @endforelse

                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-30">
                    <div class="footer-widget">
                        <h3 class="widget-title">@lang('Subscribe News Letter')</h3>
                        <p>{{ __(@$footer_content->data_values->subscribe_title) }}</p>
                        <form class="subscribe-form" method="post">
                            @csrf
                            <input type="email" name="email" placeholder="@lang('Email Address')" required>
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 text-center">
                    <div class="copyright-wrapper d-flex flex-wrap align-items-center justify-content-between">
                        <div class="copyright">
                            <p>@lang('Copyright') © <a href="{{ route('home') }}" class="text--base">{{ $general->sitename }}</a> {{ date('Y') }} @lang('All Rights Reserved')
                            </p>
                        </div>
                        <div class="copyright-link-area">
                            <ul class="copyright-link">

                                @forelse($extra_pages as $item)
                                    <li><a href="{{ route('policies',[$item->id,slug($item->data_values->title)]) }}">{{ __($item->data_values->title) }}</a></li>
                                @empty
                                @endforelse

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Footer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!-- jquery -->
<script src="{{asset($activeTemplateTrue.'js/jquery-3.6.0.min.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset($activeTemplateTrue.'js/bootstrap.min.js')}}"></script>
<!-- swipper js -->
<script src="{{asset($activeTemplateTrue.'js/swiper.min.js')}}"></script>
<!-- video js-->
<script src="{{asset($activeTemplateTrue.'js/videojs-ie8.min.js')}}"></script>
<!-- video js-->
<script src="{{asset($activeTemplateTrue.'js/video.js')}}"></script>
<script src="{{ asset($activeTemplateTrue.'js/jquery.syotimer.js') }}"></script>
<script src="{{ asset($activeTemplateTrue.'js/syotimer.lang.js') }}"></script>
<!-- wow js file -->
<script src="{{asset($activeTemplateTrue.'js/wow.min.js')}}"></script>
<!-- main -->
<script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>

<script src="{{asset($activeTemplateTrue.'js/bootstrap-fileinput.js')}}"></script>

<script src="{{ asset($activeTemplateTrue.'js/jquery.validate.js') }}"></script>

@stack('script-lib')

@include('partials.notify')

@include('partials.plugins')


@stack('script')


<script>

    (function ($) {
        "use strict";
        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });

    })(jQuery);

</script>


<script>
    (function($){
        "use strict";

        $("form").validate();
        $('form').on('submit',function () {
          if ($(this).valid()) {
            $(':submit', this).attr('disabled', 'disabled');
          }
        });

        $('.subscribe-form').on('submit',function(e){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                e.preventDefault();
                var email = $('input[name=email]').val();
                $.post('{{route('subscribe')}}',{email:email}, function(response){
                    if(response.errors){
                        for (var i = 0; i < response.errors.length; i++) {
                            iziToast.error({message: response.errors[i], position: "topRight"});
                        }
                    }else{
                        iziToast.success({message: response.success, position: "topRight"});
                    }
                });
            });

    })(jQuery);

</script>

</body>
</html>
