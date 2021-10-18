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
                            <h3 class="title">@lang('Login form')</h3>
                        </div>
                        <form class="account-form" method="POST" action="{{ route('user.login')}}" onsubmit="return submitUserForm();">
                            @csrf

                            <div class="row ml-b-20">
                                <div class="col-lg-12 form-group">
                                    <label>@lang('Username & Email')*</label>
                                    <input type="text" name="username" value="{{ old('username') }}" placeholder="@lang('Username & Email')" class="form-control form--control" required>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label>{{ __('Password') }}*</label>
                                    <input id="password" type="password" class="form-control form--control" name="password" placeholder="@lang('Password')" required>
                                </div>

                                <div class="col-lg-12 form-group">
                                    @php echo loadReCaptcha() @endphp
                                </div>
                                @include($activeTemplate.'partials.custom_captcha')

                                <div class="col-lg-12 form-group">
                                    <div class="checkbox-wrapper d-flex flex-wrap align-items-center">
                                        <div class="checkbox-item">
                                            <label><a href="{{route('user.password.request')}}">@lang('Forgot Your Password?')</a></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group text-center">
                                    <button type="submit" id="recaptcha" class="submit-btn">
                                        @lang('Login')
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
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
    </script>
@endpush
