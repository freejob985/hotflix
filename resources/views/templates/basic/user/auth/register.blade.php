@extends($activeTemplate.'layouts.auth')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    @php
        $account = getContent('account.content',true);
        $extra_pages = getContent('extra.element');
    @endphp
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="account-section bg-overlay-black bg_img"
             data-background="{{ getImage('assets/images/frontend/account/'.@$account->data_values->background_image, '1778x755') }}">
        <div class="container">
            <div class="row account-area align-items-center justify-content-center">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8">
                    <div class="account-form-area">
                        <div class="account-logo-area text-center">
                            <div class="account-logo">
                                <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logoIcon/logo.png') }}"
                                                                   alt="logo"></a>
                            </div>
                        </div>
                        <div class="account-header text-center">
                            <h3 class="title">@lang('Register form')</h3>
                        </div>
                        <form class="account-form" action="{{ route('user.register') }}" method="POST"
                              onsubmit="return submitUserForm();">
                            @csrf

                            <div class="row ml-b-20">
                                @if(session()->get('reference') != null)
                                    <div class="col-lg-6 form-group">
                                        <label>@lang('Reference By')</label>
                                        <input type="text" name="referBy" id="referenceBy"
                                               class="form-control form--control"
                                               value="{{session()->get('reference')}}" readonly>
                                    </div>
                                @endif

                                <div class="col-lg-6 form-group">
                                    <label>@lang('First Name')*</label>
                                    <input id="firstname" type="text" class="form-control form--control"
                                           name="firstname" value="{{ old('firstname') }}" required>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>@lang('Last Name')*</label>
                                    <input id="lastname" type="text" class="form-control form--control" name="lastname"
                                           value="{{ old('lastname') }}" required>
                                </div>

                                <div class="col-lg-6 form-group">
                                    <label>@lang('Country')*</label>
                                    <select name="country" id="country" class="form-control form--control">
                                        @foreach($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                    value="{{ $country->country }}" data-code="{{ $key }}"
                                                    class="text-dark">{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-6 form-group">
                                    <label>@lang('Mobile')*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text mobile-code">

                                                </span>
                                            <input type="hidden" name="mobile_code">
                                            <input type="hidden" name="country_code">
                                        </div>
                                        <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"
                                               class="form-control form--control checkUser">
                                    </div>
                                    <small class="text-danger mobileExist"></small>
                                </div>

                                <div class="col-lg-6 form-group">
                                    <label>{{ __('Username') }}*</label>
                                    <input id="username" type="text" class="form-control form--control checkUser"
                                           name="username" value="{{ old('username') }}" required>
                                    <small class="text-danger usernameExist"></small>
                                </div>

                                <div class="col-lg-6 form-group">
                                    <label>@lang('E-Mail Address')*</label>
                                    <input id="email" type="email" class="form-control form--control checkUser"
                                           name="email" value="{{ old('email') }}" required>
                                </div>

                                <div class="col-lg-6 form-group hover-input-popup">
                                    <label>@lang('Password')*</label>
                                    <input id="password" type="password" class="form-control form--control"
                                           name="password" required>
                                    @if($general->secure_password)
                                        <div class="input-popup">
                                            <p class="error lower">@lang('1 small letter minimum')</p>
                                            <p class="error capital">@lang('1 capital letter minimum')</p>
                                            <p class="error number">@lang('1 number minimum')</p>
                                            <p class="error special">@lang('1 special character minimum')</p>
                                            <p class="error minimum">@lang('6 character password')</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>@lang('Confirm Password')*</label>
                                    <input id="password-confirm" type="password" class="form-control form--control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>

                                <div class="col-lg-12 form-group">
                                    @php echo loadReCaptcha() @endphp
                                </div>
                                @include($activeTemplate.'partials.custom_captcha')

                                    @if($general->agree)
                                        <div class="col-lg-12 form-group">
                                            <div class="checkbox-wrapper d-flex flex-wrap align-items-center">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="agree" name="agree">
                                                    <label for="agree">
                                                        @lang('I agree with')
                                                        @forelse($extra_pages as $item)
                                                            <a href="{{ route('policies',[$item->id,slug($item->data_values->title)]) }}">{{ __($item->data_values->title) }}</a>
                                                            {{ $loop->last ? '' : ',' }}
                                                        @empty
                                                        @endforelse
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                <div class="col-lg-12 form-group text-center">
                                    <button type="submit" id="recaptcha" class="submit-btn">
                                        @lang('Register')
                                    </button>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <div class="account-item mt-10">
                                        <label>@lang('Already Have An Account?') <a href="{{route('user.login')}}" class="text--base">@lang('Login Now')</a></label>
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


    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Sign in ')</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="btn btn-primary">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .country-code .input-group-prepend .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }

        .hover-input-popup {
            position: relative;
        }

        .hover-input-popup:hover .input-popup {
            opacity: 1;
            visibility: visible;
        }

        .input-popup {
            position: absolute;
            bottom: 66%;
            left: 76%;
            width: 280px;
            background-color: #1a1a1a;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
            transform: translateX(-50%);
            opacity: 0;
            visibility: hidden;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        .input-popup::after {
            position: absolute;
            content: '';
            bottom: -19px;
            left: 50%;
            margin-left: -5px;
            border-width: 10px 10px 10px 10px;
            border-style: solid;
            border-color: transparent transparent #1a1a1a transparent;
            -webkit-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .input-popup p {
            padding-left: 20px;
            position: relative;
        }

        .input-popup p::before {
            position: absolute;
            content: '';
            font-family: 'Line Awesome Free';
            font-weight: 900;
            left: 0;
            top: 4px;
            line-height: 1;
            font-size: 18px;
        }

        .input-popup p.error {
            text-decoration: line-through;
        }

        .input-popup p.error::before {
            content: "\f057";
            color: #ea5455;
        }

        .input-popup p.success::before {
            content: "\f058";
            color: #28c76f;
        }
    </style>
@endpush
@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
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

        (function ($) {
            @if($mobile_code)
            $(`option[data-code={{ $mobile_code }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function () {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            @if($general->secure_password)
            $('input[name=password]').on('input', function () {
                secure_password($(this));
            });
            @endif

            $('.checkUser').on('focusout', function (e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {mobile: mobile, _token: token}
                }
                if ($(this).attr('name') == 'email') {
                    var data = {email: value, _token: token}
                }
                if ($(this).attr('name') == 'username') {
                    var data = {username: value, _token: token}
                }
                $.post(url, data, function (response) {
                    if (response['data'] && response['type'] == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response['data'] != null) {
                        $(`.${response['type']}Exist`).text(`${response['type']} already exist`);
                    } else {
                        $(`.${response['type']}Exist`).text('');
                    }
                });
            });

        })(jQuery);

    </script>
@endpush
