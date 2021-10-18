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
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/fontawesome-all.min.css') }}">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/bootstrap.min.css') }}">
    <!-- video css links -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/video-js.css') }}">
    <!-- swipper css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/swiper.min.css') }}">
    <!-- line-awesome-icon css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/line-awesome.min.css') }}">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/animate.css') }}">
    <!-- main style css link -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/style.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/color.php?color=' . $general->base_color) }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/bootstrap-fileinput.css') }}">

    
    <style>
        body {
            min-height: calc(100vh + 30px);
        }

    </style>

    @if (Session::get('lang') == 'ar')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet">
        
        <style>
            * {
                font-family: 'Almarai', sans-serif;
            }

        </style>
    @endif

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css">
    <link media="all" rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    @stack('style-lib')

    @stack('style')
</head>

<body @stack('context')>

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
                            <a class="site-logo site-title mr-auto" href="{{ route('home') }}"><img
                                    src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="site-logo"></a>
                            <div class="search-bar d-block d-lg-none">
                                <a href="#0"><i class="fas fa-search"></i></a>
                                <div class="header-top-search-area">
                                    <form class="header-search-form" action="{{ route('search') }}">
                                        <input type="search" name="search" placeholder="@lang('Search here')...">
                                        <button class="header-search-btn" type="submit"><i
                                                class="fas fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="fas fa-bars"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav main-menu ml-auto mr-auto">

                                    <li><a href="{{ route('home') }}">@lang('Home')</a></li>
                                    @forelse($categories as $category)
                                        @if ($category->subcategory()->where('status', 1)->count() > 0)
                                            <li><a href="{{ route('category', $category->id) }}">{{ __($category->name) }}
                                                    <i class="fas fa-caret-down"></i></a>
                                                <ul class="sub-menu">
                                                    @forelse($category->subcategory as $subcategory)
                                                        <li><a
                                                                href="{{ route('subCategory', $subcategory->id) }}">{{ __($subcategory->name) }}</a>
                                                        </li>
                                                    @empty
                                                    @endforelse
                                                </ul>
                                            </li>
                                        @else
                                            <li><a
                                                    href="{{ route('category', $category->id) }}">{{ __($category->name) }}</a>
                                            </li>
                                        @endif
                                        @empty
                                        @endforelse
                                    </ul>
                                    <div class="search-bar d-none d-lg-block">
                                        <a href="#0"><i class="fas fa-search"></i></a>
                                        <div class="header-top-search-area">
                                            <form class="header-search-form" action="{{ route('search') }}">
                                                <input type="search" name="search" placeholder="@lang('Search here')...">
                                                <button class="header-search-btn" type="submit"><i
                                                        class="fas fa-search"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="header-bottom-right">
                                        <div class="language-select-area">
                                            <select class="language-select langSel" id="langSel">
                                                @foreach ($language as $lang)
                                                    <option value="{{ $lang->code }}" @if (Session::get('lang') === $lang->code) selected  @endif>
                                                        {{ __($lang->code) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="header-action">
                                        @auth
                                            <a href="{{ route('user.home') }}" class="btn--base"><i
                                                    class="las la-home"></i>@lang('Dashboard')</a>
                                        @else
                                            <a href="{{ route('user.register') }}" class="btn--base"><i
                                                    class="las la-user-circle"></i>@lang('Register')</a>
                                        @endauth
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

        @yield('content')


        <div class="custom_loading"></div>


        @php
            $footer_content = getContent('footer.content', true);
            $footer_elements = getContent('footer.element');
            $extra_pages = getContent('extra.element');
            $short_links = getContent('short_links.element');
        @endphp

        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Footer
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <footer class="footer-section footer pt-80 bg-overlay-black bg_img @if (request()->routeIs('home') || request()->routeIs('category') || request()->routeIs('subCategory') || request()->routeIs('search')) d-none @endif"
            data-background="{{ getImage('assets/images/frontend/footer/' . @$footer_content->data_values->background_image, '1920x789') }}">
            <div class="container">
                <div class="footer-top-area d-flex flex-wrap align-items-center justify-content-between">
                    <div class="footer-logo">
                        <a href="{{ route('home') }}" class="site-logo"><img
                                src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="logo"></a>
                    </div>
                    <div class="social-area">
                        <ul class="footer-social">
                            @forelse($footer_elements as $item)
                                <li><a href="{{ @$item->data_values->social_link }}"
                                        target="_blank">@php echo @$item->data_values->social_icon @endphp</a></li>
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
                                    @foreach ($categories as $category)
                                        <li><a
                                                href="{{ route('category', $category->id) }}">{{ __($category->name) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 mb-30">
                            <div class="footer-widget">
                                <h3 class="widget-title">@lang('Short Links')</h3>
                                <ul class="footer-links">

                                    @forelse($short_links as $link)
                                        <li><a
                                                href="{{ route('links', [$link->id, slug($link->data_values->title)]) }}">{{ __($link->data_values->title) }}</a>
                                        </li>
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
                                    <p>@lang('Copyright') © <a href="{{ route('home') }}"
                                            class="text--base">{{ $general->sitename }}</a> {{ date('Y') }}
                                        @lang('All Rights Reserved')
                                    </p>
                                </div>
                                <div class="copyright-link-area">
                                    <ul class="copyright-link">

                                        @forelse($extra_pages as $item)
                                            <li><a
                                                    href="{{ route('policies', [$item->id, slug($item->data_values->title)]) }}">{{ __($item->data_values->title) }}</a>
                                            </li>
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


        @php
            $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
        @endphp

        @if (@$cookie->data_values->status && !session('cookie_accepted'))
            <div class="cookie__wrapper">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <p class="txt my-2">
                            @php echo @$cookie->data_values->description @endphp
                            <br>
                            <a href="{{ @$cookie->data_values->link }}" target="_blank"
                                class="text--base">@lang('Read Policy')</a>
                        </p>
                        <button class="btn--base btn-md my-2 acceptPolicy">@lang('Accept')</button>
                    </div>
                </div>
            </div>
        @endif


        <!-- jquery -->
        <script src="{{ asset($activeTemplateTrue . 'js/jquery-3.6.0.min.js') }}"></script>
        <!-- bootstrap js -->
        <script src="{{ asset($activeTemplateTrue . 'js/bootstrap.min.js') }}"></script>
        <!-- swipper js -->
        <script src="{{ asset($activeTemplateTrue . 'js/swiper.min.js') }}"></script>
        <!-- video js-->
        <script src="{{ asset($activeTemplateTrue . 'js/videojs-ie8.min.js') }}"></script>
        <!-- video js-->
        <script src="{{ asset($activeTemplateTrue . 'js/video.js') }}"></script>
        <!-- wow js file -->
        <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
        <!-- main -->
        <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

        @stack('script-lib')

        @stack('script')

        @include('partials.plugins')

        @include('partials.notify')


        <script>
            (function($) {
                "use strict";
                $(".langSel").on("change", function() {
                    window.location.href = "{{ route('home') }}/change/" + $(this).val();
                });

                //Cookie
                $(document).on('click', '.acceptPolicy', function() {
                    $.ajax({
                        url: "{{ route('cookie.accept') }}",
                        method: 'GET',
                        success: function(data) {
                            if (data.success) {
                                $('.cookie__wrapper').addClass('d-none');
                                notify('success', data.success)
                            }
                        },
                    });
                });

                $('.subscribe-form').on('submit', function(e) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    e.preventDefault();
                    var email = $('input[name=email]').val();
                    $.post('{{ route('subscribe') }}', {
                        email: email
                    }, function(response) {
                        if (response.errors) {
                            for (var i = 0; i < response.errors.length; i++) {
                                iziToast.error({
                                    message: response.errors[i],
                                    position: "topRight"
                                });
                            }
                        } else {
                            iziToast.success({
                                message: response.success,
                                position: "topRight"
                            });
                        }
                    });
                });

                $(document).on("click", ".advertise", function() {
                    var id = $(this).data('id');
                    var url = "{{ route('addclick') }}";

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        method: 'POST',
                        data: {
                            'id': id
                        },
                        success: function(data) {

                        },
                    });
                });
            })(jQuery);
        </script>

    </body>

    </html>
