<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Movie
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="movie-section section--bg ptb-80 section" data-section="latest_series">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-header">
                    <h2 class="section-title">@lang('Recently Added')</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-30-none">

            @forelse($recent_added as $latest)
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 mb-30">
                    <div class="movie-item">
                        <div class="movie-thumb">
                            <img src="{{ getImage('assets/images/item/portrait/'.$latest->image->portrait) }}" alt="movie">
                            @if($latest->item_type == 1 && $latest->version == 0)
                                <span class="movie-badge">@lang('Free')</span>
                            @elseif($latest->item_type == 3)
                                <span class="movie-badge">@lang('Trailer')</span>
                            @endif
                            <div class="movie-thumb-overlay">
                                <a class="video-icon" href="{{ route('watch', $latest->id) }}"><i class="fas fa-play"></i></a>
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
