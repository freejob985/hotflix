@extends($activeTemplate.'layouts.frontend')
@section('content')

    @php
        $banner_content = getContent('banner.content', true);
    @endphp
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<style>
h1.title.text-white {
    color:white #d50f55 !important;
}
span.sp {
    color: #d50f55 !important;
}
</style>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css">
<link media="all" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <section class="banner-section bg-overlay-black bg_img"
             data-background="{{ getImage('assets/images/frontend/banner/' . @$banner_content->data_values->background_image, '1778x755') }}">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6">
                    <div class="banner-content">

                        <span class="sub-title">{{ __(@$banner_content->data_values->heading) }}</span>
                        <!-- <h1 class="title text-white">{{ __(@$banner_content->data_values->sub_heading) }}</h1> -->
                        <h1 class="title text-white"><span class="sp">MOVIES</span> OF THE WEEK</h1>
                        <div class="banner-btn">
                            <a href="{{ @$banner_content->data_values->button_1_link }}"
                               class="btn--base">{{ __(@$banner_content->data_values->button_1) }}</a>
                            <a href="{{ @$banner_content->data_values->button_2_link }}" class="btn--base active"><i
                                    class="las la-plus"></i> {{ __(@$banner_content->data_values->button_2) }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="banner-slider">
                        <div class="swiper-wrapper">

                            @forelse($sliders as $slider)
                                <div class="swiper-slide">
                                    <div class="movie-item">
                                        <div class="movie-thumb">
                                            <img src="{{ getImage('assets/images/slider/'.$slider->image) }}"
                                                 alt="movie">
                                            <div class="movie-thumb-overlay">
                                                <a class="video-icon" href="{{ route('watch',$slider->item->id) }}"><i
                                                        class="fas fa-play"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse

                        </div>
<!--                        <div class="swiper-pagination"></div>-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Banner
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Movie
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="movie-section ptb-80 section"  data-section="recent_added">
        <div class="container">
            <div class="row justify-content-center align-items-center mb-30-none">
                <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-30">
                    <div class="movie-section-header-wrapper">
                        <div class="movie-section-header">
                            <h2 class="title">@lang('Featured Movies to Watch Now')</h2>
                            <p>@lang('Most watched movies by days')</p>
                        </div>
                        <div class="movie-slider-arrow">
                            <div class="slider-prev">
                                <i class="fas fa-angle-left"></i>
                            </div>
                            <div class="slider-next">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 mb-30">
                    <div class="movie-slider">
                        <div class="swiper-wrapper">

                            @forelse($featured_movies as $featured)
                                <div class="swiper-slide">
                                    <div class="movie-item">
                                        <div class="movie-thumb">
                                            <img src="{{ getImage('assets/images/item/portrait/'.$featured->image->portrait) }}" alt="movie">
                                            @if($featured->item_type == 1 && $featured->version == 0)
                                                <span class="movie-badge">@lang('Free')</span>
                                            @elseif($featured->item_type == 3)
                                                <span class="movie-badge">@lang('Trailer')</span>
                                            @endif
                                            <div class="movie-thumb-overlay">
                                                <a class="video-icon" href="{{ route('watch',$featured->id) }}"><i class="fas fa-play"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Movie
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    <div class="sections">

    </div>
@endsection

@push('script')
    <script type="text/javascript">
        "use strict";
        var send = 0;
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() > $(document).height() - 60) {
                if ($('.section').hasClass('last-item')) {
                    $('.custom_loading').removeClass('loader-area');
                    return false;
                }
                $('.custom_loading').addClass('loader-area');
                setTimeout(function () {
                    if (send == 0) {
                        send = 1;
                        var sec = $('.section').last().data('section');
                        var url = '{{ route('getSection') }}';
                        var data = {sectionname: sec};
                        $.get(url, data, function (response) {
                            if (response == 'end') {
                                $('.section').last().addClass('last-item');
                                $('.custom_loading').removeClass('loader-area');
                                $('.footer').removeClass('d-none');
                                return false;
                            }
                            $('.custom_loading').removeClass('loader-area');
                            $('.sections').append(response);
                            send = 0;
                        });
                    }
                }, 1000)
            }
        });
    </script>
@endpush
