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
                                <button type="button" class="btn btn--base text-white btn-block custom-success" id="btn-confirm">@lang('Pay Now')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="//pay.voguepay.com/js/voguepay.js"></script>
    <script>
        "use strict";
        var closedFunction = function() {
        }
        var successFunction = function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}';
        }
        var failedFunction=function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}' ;
        }

        function pay(item, price) {
            //Initiate voguepay inline payment
            Voguepay.init({
                v_merchant_id: "{{ $data->v_merchant_id}}",
                total: price,
                notify_url: "{{ $data->notify_url }}",
                cur: "{{$data->cur}}",
                merchant_ref: "{{ $data->merchant_ref }}",
                memo:"{{$data->memo}}",
                recurrent: true,
                frequency: 10,
                developer_code: '60a4ecd9bbc77',
                custom: "{{ $data->custom }}",
                customer: {
                  name: 'Customer name',
                  country: 'Country',
                  address: 'Customer address',
                  city: 'Customer city',
                  state: 'Customer state',
                  zipcode: 'Customer zip/post code',
                  email: 'example@example.com',
                  phone: 'Customer phone'
                },
                closed:closedFunction,
                success:successFunction,
                failed:failedFunction
            });
        }

        (function ($) {

            $('#btn-confirm').on('click', function (e) {
                e.preventDefault();
                pay('Buy', {{ $data->Buy }});
            });

        })(jQuery);
    </script>
@endpush
