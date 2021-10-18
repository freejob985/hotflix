@extends($activeTemplate.'layouts.master')

@section('content')
    <section class="deposit-preview-section deposit-section section--bg ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-6">
                    <div class="deposit-item">
                        <div class="deposit-item-header bg--base text-white text-center">
                            <span class="title">@lang('Payment Preview')</span>
                        </div>
                        <div class="deposit-item-body">
                            <div class="deposit-thumb-area">
                                <div class="deposit-thumb">
                                    <img src="{{$data->img}}" alt="payment">
                                </div>
                            </div>
                            <div class="deposit-content text-center">
                                <ul class="deposit-list">
                                    <li>@lang('PLEASE SEND EXACTLY') <span>{{ $data->amount }}</span> {{__($data->currency)}}</li>
                                    <li>@lang('To') {{ $data->sendto }}</li>
                                    <li>@lang('SCAN TO SEND')</li>
                                </ul>
                            </div>
                        </div>
                        <div class="deposit-item-footer bg--base">
                            <div class="deposit-btn">
                                <button class="btn btn--base text-white btn-block btn-icon icon-left btn-custom2" id="btn-confirm" onClick="payWithRave()"><i class="las la-money-bill"></i>@lang('Pay Now')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
