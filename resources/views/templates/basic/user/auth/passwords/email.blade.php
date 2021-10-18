@extends($activeTemplate.'layouts.auth')

@section('content')
    @php
        $account = getContent('account.content',true);
    @endphp

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <section class="account-section bg-overlay-black bg_img"
             data-background="{{ getImage('assets/images/frontend/account/'.@$account->data_values->background_image, '1778x755') }}">
        <div class="container">
            <div class="row account-area align-items-center justify-content-center">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8">
                    <div class="account-form-area">
                        <div class="account-logo-area text-center">
                            <div class="account-logo">
                                <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="logo"></a>
                            </div>
                        </div>
                        <div class="account-header text-center">
                            <h3 class="title">@lang('Reset Password')</h3>
                        </div>
                        <form class="account-form" method="POST" action="{{ route('user.password.email') }}">
                            @csrf

                            <div class="row ml-b-20">
                                <div class="col-lg-12 form-group">
                                    <label>@lang('Select One')</label>
                                    <select class="form-control form--control" name="type">
                                        <option value="email" class="text-dark">@lang('E-Mail Address')</option>
                                        <option value="username" class="text-dark">@lang('Username')</option>
                                    </select>
                                </div>

                                <div class="col-lg-12 form-group">
                                    <label class="my_value"></label>
                                    <input type="text" class="form-control form--control" name="value" value="{{ old('value') }}" required autofocus="off">
                                </div>

                                <div class="col-lg-12 form-group text-center">
                                    <button type="submit" class="submit-btn">
                                        @lang('Send Password Code')
                                    </button>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <div class="account-item mt-10">
                                        <label>@lang("Don't Have An Account?") <a href="{{ route('user.register') }}" class="text--base">@lang('Register Now')</a></label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Account
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection

@push('script')
<script>

    (function($){
        "use strict";

        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }
    })(jQuery)
</script>
@endpush
