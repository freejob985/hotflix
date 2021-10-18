@extends($activeTemplate.'layouts.master')

@section('content')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Deposit
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
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
                                <button class="btn btn--base text-white btn-block btn-icon icon-left btn-custom2" id="btn-confirm" onClick="payWithRave()"><i class="las la-money-bill"></i>@lang('Pay Now')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Deposit
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection
@push('script')
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script>
        "use strict"
        var btn = document.querySelector("#btn-confirm");
        btn.setAttribute("type", "button");
        const API_publicKey = "{{$data->API_publicKey}}";

        function payWithRave() {
            var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: "{{$data->customer_email}}",
                amount: "{{$data->amount }}",
                customer_phone: "{{$data->customer_phone}}",
                currency: "{{$data->currency}}",
                txref: "{{$data->txref}}",
                onclose: function () {
                },
                callback: function (response) {
                    var txref = response.tx.txRef;
                    var status = response.tx.status;
                    var chargeResponse = response.tx.chargeResponseCode;
                    if (chargeResponse == "00" || chargeResponse == "0") {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    } else {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    }
                        // x.close(); // use this to close the modal immediately after payment.
                    }
                });
        }
    </script>
@endpush
