@extends($activeTemplate.'layouts.master')


@section('content')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Deposit
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="deposit-section section--bg ptb-80">
        <div class="container">
            <div class="row justify-content-center mb-30-none">

                @foreach($gatewayCurrency as $data)
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 mb-30">
                        <div class="deposit-item">
                            <div class="deposit-item-header bg--base text-white text-center">
                                <span class="title"> {{__($data->name)}}</span>
                            </div>
                            <div class="deposit-item-body">
                                <div class="deposit-thumb">
                                    <img src="{{$data->methodImage()}}" alt="payment">
                                </div>
                            </div>
                            <div class="deposit-item-footer bg--base">
                                <div class="deposit-btn">
                                    <a href="javascript:void(0)" data-id="{{$data->id}}"
                                       data-name="{{$data->name}}"
                                       data-currency="{{$data->currency}}"
                                       data-method_code="{{$data->method_code}}"
                                       data-min_amount="{{getAmount($data->min_amount)}}"
                                       data-max_amount="{{getAmount($data->max_amount)}}"
                                       data-base_symbol="{{$data->baseSymbol()}}"
                                       data-fix_charge="{{getAmount($data->fixed_charge)}}"
                                       data-percent_charge="{{getAmount($data->percent_charge)}}" class="btn btn--base text-white btn-block btn-icon icon-left custom-success deposit" data-toggle="modal" data-target="#depositModal">
                                        <i class="las la-money-bill"></i>
                                        @lang('Pay Now')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Deposit
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->



    <div class="modal fade" id="depositModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title method-name" id="depositModalLabel"></strong>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <form action="{{route('user.deposit.insert')}}" method="post">
                    @csrf

                    <div class="modal-body">
                        <h5 class="text-center base--color">@lang('Are you sure to pay '.getAmount($subscription->plan->pricing).' '.$general->cur_text.' to subscribe '.$subscription->plan->name.' ?')</h5>

                        <input type="hidden" name="currency" class="edit-currency">
                        <input type="hidden" name="method_code" class="edit-method-code">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                        <div class="prevent-double-click">
                            <button type="submit" class="btn btn--default confirm-btn">@lang('Confirm')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.deposit').on('click', function () {
                var name = $(this).data('name');
                var currency = $(this).data('currency');
                var method_code = $(this).data('method_code');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{$general->cur_text}}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Deposit Limit'): ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge'): ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${name}`);
                $('.currency-addon').text(baseSymbol);
                $('.edit-currency').val(currency);
                $('.edit-method-code').val(method_code);
            });
        })(jQuery);
    </script>
@endpush


@push('style')
<style type="text/css">

</style>
@endpush
