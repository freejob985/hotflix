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
                            <span class="title"> {{ $data->gatewayCurrency()->name }}</span>
                        </div>
                        <div class="deposit-item-body">
                            <div class="deposit-thumb-area">
                                <div class="deposit-thumb">
                                    <img src="{{ $data->gatewayCurrency()->methodImage() }}" alt="payment">
                                </div>
                            </div>
                            <div class="deposit-content text-center">
                                <ul class="deposit-list">
                                    <li>@lang('Amount'): <span>{{getAmount($data->amount)}}</span> {{__($general->cur_text)}}</li>
                                    <li>@lang('Charge'): <span>{{getAmount($data->charge)}}</span> {{__($general->cur_text)}}</li>
                                    <li>@lang('Payable'): <span>{{getAmount($data->amount + $data->charge)}}</span> {{__($general->cur_text)}}</li>
                                    <li>@lang('Conversion Rate'): <span>1 {{__($general->cur_text)}} = {{getAmount($data->rate)}}  {{__($data->baseCurrency())}}</span></li>
                                    <li>@lang('In') {{$data->baseCurrency()}}: <span>{{getAmount($data->final_amo)}}</span></li>

                                    @if($data->gateway->crypto==1)
                                        <li>@lang('Conversion with') <b> {{ __($data->method_currency) }}</b> @lang('and final value will Show on next step')</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="deposit-item-footer bg--base">
                            <div class="deposit-btn">
                                @if( 1000 >$data->method_code)
                                    <a href="{{route('user.deposit.confirm')}}" class="btn btn--base text-white btn-block btn-icon icon-left"><i class="las la-money-bill"></i> @lang('Pay Now')</a>
                                @else
                                    <a href="{{route('user.deposit.manual.confirm')}}" class="btn btn--base text-white btn-block btn-icon icon-left"><i class="las la-money-bill"></i> @lang('Pay Now')</a>
                                @endif
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


