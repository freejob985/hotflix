@extends($activeTemplate.'layouts.master')
@section('content')

    @if(auth()->user()->plan_id != 0)
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Countdown
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div class="card-area section--bg ptb-80">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="card custom--card">
                            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                                <h4 class="card-title mb-0">
                                    @lang('Current subscription plan is '.@auth()->user()->plan->name)
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="card-body-content text-center">
                                    <h3 class="title">@lang('Subscription will be expired')</h3>
                                </div>
                                <div class="draw-countdown"
                                     data-year="{{ \Carbon\Carbon::parse(auth()->user()->exp)->format('Y') }}"
                                     data-month="{{ \Carbon\Carbon::parse(auth()->user()->exp)->format('m') }}"
                                     data-day="{{ \Carbon\Carbon::parse(auth()->user()->exp)->format('d') }}"
                                     data-hour="{{ \Carbon\Carbon::parse(auth()->user()->exp)->format('H') }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            End Card
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @else
        @if(auth()->user()->deposits()->where('status',2)->count() > 0)
            <div class="card-area section--bg pt-80">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-6">
                            <div class="card custom--card">
                                <div class="card-body">
                                    <div class="card-body-content text-center">
                                        <h3 class="title">@lang('Your payment is now in pending, please wait for admin response')</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Plan
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <section class="plan-section section--bg ptb-80">
            <div class="container">
                <div class="row justify-content-center mb-30-none">

                    @forelse($plans as $plan)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-30">
                            <div class="plan-item text-center">
                                <div class="plan-icon">
                                    @php echo $plan->icon @endphp
                                </div>
                                <div class="plan-content">
                                    <span class="sub-title">{{ __($plan->name) }}</span>
                                    <h2 class="amount">{{ $general->cur_sym }}{{ getAmount($plan->pricing) }}</h2>
                                    <p>@lang('Get '.$plan->duration.' days subscription')</p>
                                    <div class="plan-btn mt-30">
                                        @if(auth()->user()->deposits()->where('status',2)->count() > 0)
                                            <button class="btn--base w-100" disabled>@lang('Subscribe Now')</button>
                                        @else
                                            <button class="btn--base w-100 buyBtn" data-id="{{ $plan->id }}">@lang('Subscribe Now')</button>
                                        @endif
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
            End Plan
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @endif


    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Modal
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Subscribe Plan')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.subscribePlan') }}" method="post">
                    @csrf

                    <input type="hidden" name="id">

                    <div class="modal-body text-center">
                        <h4 class="base--color">@lang('Are you sure to subscribe this plan?')</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--default">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Modal
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection

@push('script')
    <script type="text/javascript">
        "use strict";
        $('.buyBtn').click(function () {
            var modal = $('#buyModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });
    </script>
@endpush
