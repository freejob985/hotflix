@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'breadcrumb')

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Movie
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="movie-section section--bg ptb-80">
        <div class="container">
            <div class="row justify-content-center mb-30-none ajaxLoad">

                @forelse($items as $item)
                    @if($loop->last)
                        <span class="data_id" data-id="{{ $item->id }}"></span>
                        <span class="category_id" data-category_id="{{ @$category->id }}"></span>
                        <span class="sub_category_id" data-sub_category_id="{{ @$sub_category->id }}"></span>
                        <span class="search" data-search="{{ @$search }}"></span>
                    @endif

                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 mb-30">
                        <div class="movie-item">
                            <div class="movie-thumb">
                                <img src="{{ getImage('assets/images/item/portrait/'.$item->image->portrait) }}" alt="movie">
                                @if($item->item_type == 1 && $item->version == 0)
                                    <span class="movie-badge">@lang('Free')</span>
                                @elseif($item->item_type == 3)
                                    <span class="movie-badge">@lang('Trailer')</span>
                                @endif

                                <div class="movie-thumb-overlay">
                                    <a class="video-icon" href="{{ route('watch',$item->id) }}"><i class="fas fa-play"></i></a>
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
        "use strict"
        var send = 0;
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() > $(document).height() - 60) {
                if ($('.ajaxLoad').hasClass('loaded')) {
                    $('.custom_loading').removeClass('loader-area');
                    return false;
                }
                $('.custom_loading').addClass('loader-area');
                setTimeout(function () {
                    if (send == 0) {
                        send = 1;
                        var url = '{{ route('loadmore.load_data') }}';
                        var id = $('.data_id').last().data('id');
                        var category_id = $('.category_id').last().data('category_id');
                        var sub_category_id = $('.sub_category_id').last().data('sub_category_id');
                        var search = $('.search').last().data('search');
                        var data = {id: id, category_id: category_id, sub_category_id: sub_category_id, search: search};
                        $.get(url, data, function (response) {
                            if (response == 'end') {
                                $('.custom_loading').removeClass('loader-area');
                                $('.footer').removeClass('d-none');
                                $('.ajaxLoad').addClass('loaded');
                                return false;
                            }
                            $('.custom_loading').removeClass('loader-area');
                            $('.sections').append(response);
                            $('.ajaxLoad').append(response);
                            send = 0;

                        });
                    }
                }, 1000);
            }
        });
    </script>
@endpush
