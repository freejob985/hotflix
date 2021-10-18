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
                        <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST">
                            @csrf

                            <div class="deposit-item-body">
                                <div class="deposit-thumb-area">
                                    <div class="deposit-thumb">
                                        <img src="{{$deposit->gatewayCurrency()->methodImage()}}" alt="payment">
                                    </div>
                                </div>
                                <div class="deposit-content text-center">
                                    <ul class="deposit-list">
                                        <li>@lang('Please Pay'): <span>{{getAmount($deposit->final_amo)}}</span> {{__($deposit->method_currency)}}</li>
                                        <li>@lang('To Get'): <span>{{getAmount($deposit->amount)}}</span> {{__($general->cur_text)}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="deposit-item-footer bg--base">
                                <div class="deposit-btn">
                                    <button type="button" class="btn btn--base text-white btn-block custom-success" id="btn-confirm"><i class="las la-money-bill"></i> @lang('Pay Now')</button>
                                </div>
                            </div>

                            <script
                                src="//js.paystack.co/v1/inline.js"
                                data-key="{{ $data->key }}"
                                data-email="{{ $data->email }}"
                                data-amount="{{$data->amount}}"
                                data-currency="{{$data->currency}}"
                                data-ref="{{ $data->ref }}"
                                data-custom-button="btn-confirm"
                            >
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
