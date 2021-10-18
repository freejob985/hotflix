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
                        <video id="my-video" class="video-js" controls preload="auto" height="264"
                               poster="{{ getImage('assets/images/item/landscape/'.$item->image->landscape) }}" data-setup="{}"
                               controlsList="nodownload">
                            <source src="{{ $videoFile }}" type="video/mp4" />
                        </video>
                    </div>
                    <div class="movie-content">
                        <div class="movie-content-inner d-flex flex-wrap justify-content-between align-items-center">
                            <div class="movie-content-left">
                                <h3 class="title">{{ __($item->title) }}</h3>
                                <span class="sub-title">@lang('Category') : <span class="cat">{{ @$item->category->name }}</span> @if($item->sub_category) @lang('Sub Category'): {{ @$item->sub_category->name }} @endif</span>
                            </div>
                            <div class="movie-content-right">
                                <div class="movie-widget-area">
                                    <span class="movie-widget"><i class="lar la-star text--warning"></i> {{ getAmount($item->ratings) }}</span>
                                    <span class="movie-widget"><i class="lar la-eye text--danger"></i> {{ getAmount($item->view) }} @lang('views')</span>
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
                            <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab"
                               aria-controls="product-desc-content" aria-selected="true">@lang('Description')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-team" data-toggle="tab" href="#product-team-content"
                               role="tab" aria-controls="product-team-content" aria-selected="false">@lang('Team')</a>
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
                    <h2 class="section-title">@lang('Related Items')</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-30-none">

            @forelse($related_items as $related)
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


