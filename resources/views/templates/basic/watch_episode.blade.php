@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'breadcrumb')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Movie
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="movie-details-section section--bg ptb-80">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                <div class="col-xl-8 col-lg-8 mb-30">
                    <div class="movie-item">
                        <div class="movie-video">
                            @php
                                $firstVideo = @$episodes[0]->video;
                                if (@$firstVideo->server == 0) {
                                  @$fvideoPath = asset('assets/videos/'.$firstVideo->content);
                                }elseif($firstVideo->server == 1){
                                  @$storage = Storage::disk('custom-ftp');
                                  @$fvideoPath = $general->ftp->domain.'/'.Storage::disk('custom-ftp')->url($firstVideo->content);
                                }else{
                                  $fvideoPath = $firstVideo->content;
                                }
                            @endphp
                            <video id="my-video" class="video-js" controls preload="auto" height="264"
                                   poster="{{ getImage('assets/images/item/episode/'.@$episodes[0]->image) }}"
                                   data-setup="{}"
                                   controlsList="nodownload">
                                <source src="{{ $fvideoPath }}" type="video/mp4"/>
                            </video>
                        </div>
                        <div class="movie-content">
                            <div
                                class="movie-content-inner d-flex flex-wrap justify-content-between align-items-center">
                                <div class="movie-content-left">
                                    <h3 class="title">{{ __($item->title) }}</h3>
                                </div>
                                <div class="movie-content-right">
                                    <div class="movie-widget-area">
                                        <span class="movie-widget"><i class="lar la-star text--warning"></i> {{ getAmount($item->ratings) }}</span>
                                        <span class="movie-widget"><i
                                                class="lar la-eye text--danger"></i> {{ getAmount($item->view) }} @lang('views')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="movie-widget-area">
                            </div>
                            <p>{{ __($item->preview_text) }}</p>
                        </div>
                    </div>
                    <div class="product-tab mt-40">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="product-tab-desc" data-toggle="tab"
                                   href="#product-desc-content" role="tab"
                                   aria-controls="product-desc-content" aria-selected="true">@lang('Description')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-tab-team" data-toggle="tab" href="#product-team-content"
                                   role="tab" aria-controls="product-team-content"
                                   aria-selected="false">@lang('Team')</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel"
                                 aria-labelledby="product-tab-desc">
                                <div class="product-desc-content">
                                    {{ __($item->description) }}
                                </div>
                            </div>
                            <div class="tab-pane fade fade" id="product-team-content" role="tabpanel"
                                 aria-labelledby="product-tab-team">
                                <div class="product-desc-content">
                                    <ul class="team-list">
                                        <li><span>@lang('Director'):</span> {{ __($item->team->director) }}</li>
                                        <li><span>@lang('Producer'):</span> {{ __($item->team->producer) }}</li>
                                        <li><span>@lang('Cast'):</span> {{ __($item->team->casts) }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 mb-30">
                    <div class="widget-box">
                        <div class="widget-wrapper movie-small-list">

                            @forelse($episodes as $episode)
                                @php
                                    $className = '';
                                    $videoSrc = '';
                                      if ($episode->version == 1) {
                                        if (auth()->check() && auth()->user()->plan_id != 0 && auth()->user()->exp != null) {
                                          $className = 'video-item';
                                          $videoSrc = $episode->videoSrc();
                                        }
                                      }else{
                                        $className = 'video-item';
                                        $videoSrc = $episode->videoSrc();
                                      }
                                @endphp

                                <div class="widget-item d-flex flex-wrap align-items-center movie-small" data-src="{{ $videoSrc }}" data-img="{{ getImage('assets/images/item/episode/'.$episode->image) }}">
                                    <div class="widget-thumb">
                                        @if($episode->version == 1)
                                            @if(!auth()->check())
                                                <a href="{{ route('user.login') }}">
                                                    <img src="{{ getImage('assets/images/item/episode/'.$episode->image) }}" alt="movie">
                                                </a>
                                            @else
                                                @if(auth()->user()->plan_id == 0 && auth()->user()->exp == null)
                                                    <a href="{{ route('user.home') }}">
                                                        <img src="{{ getImage('assets/images/item/episode/'.$episode->image) }}" alt="movie">
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)">
                                                        <img src="{{ getImage('assets/images/item/episode/'.$episode->image) }}" alt="movie">
                                                    </a>
                                                @endif
                                            @endif
                                        @else
                                            <img src="{{ getImage('assets/images/item/episode/'.$episode->image) }}" alt="movie">
                                            <span class="movie-badge">@lang('Free')</span>
                                        @endif
                                    </div>
                                    <div class="widget-content">
                                        <h4 class="title">{{ __($episode->title) }}</h4>
                                        <div class="widget-btn">
                                            @if($episode->version == 1)
                                                @if(!auth()->check())
                                                    <a href="{{ route('user.login') }}" class="custom-btn">@lang('Login Now')</a>
                                                @else
                                                    @if(auth()->user()->plan_id == 0 && auth()->user()->exp == null)
                                                        <a href="{{ route('user.home') }}" class="custom-btn">@lang('Subscribe a plan')</a>
                                                    @else
                                                        <a href="javascript:void(0)" class="custom-btn">@lang('Play Now')</a>
                                                    @endif
                                                @endif
                                            @else
                                                <a href="javascript:void(0)" class="custom-btn">@lang('Play Now')</a>
                                            @endif
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



    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Movie
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="movie-section ptb-80">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section-header">
                        <h2 class="section-title">@lang('Related Episode')</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-30-none">

                @forelse($related_episodes as $related)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 mb-30">
                        <div class="movie-item">
                            <div class="movie-thumb">
                                <img src="{{ getImage('assets/images/item/portrait/'.$related->image->portrait) }}" alt="movie">
                                @if($related->item_type == 1 && $related->version == 0)
                                    <span class="movie-badge">@lang('Free')</span>
                                @elseif($related->item_type == 3)
                                    <span class="movie-badge">@lang('Trailer')</span>
                                @endif
                                <div class="movie-thumb-overlay">
                                    <a class="video-icon" href="{{ route('watch', $related->id) }}"><i class="fas fa-play"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Movie
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection

@push('script')
    <script type="text/javascript">
        "use strict";
        $( ".movie-small-list > .movie-small" ).each(function() {
            $(this).on('click', function(){
                var dataSrc = $(this).attr("data-src");
                var dataImg = $(this).attr("data-img");

                $('#my-video video').attr('src', dataSrc);
                $('.vjs-poster').css('background-image', 'url('+ dataImg +')');

                // add active class with "list-btn"
                var element = $(this).parent("li");
                if (element.hasClass("active")) {
                    element.find("li").removeClass("active");
                }
                else {
                    element.addClass("active");
                    element.siblings("li").removeClass("active");
                    element.siblings("li").find("li").removeClass("active");
                }
            });
        });
    </script>
@endpush

@push('context')
    oncontextmenu="return false"
@endpush
