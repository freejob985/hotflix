@extends($activeTemplate.'layouts.auth')
@section('content')
    @php
        $account = getContent('account.content',true);
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
                                <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="logo"></a>
                            </div>
                        </div>
                        <form class="account-form" method="POST" action="{{ route('user.password.verify.code') }}">
                            @csrf

                            <input type="hidden" name="email" value="{{ $email }}">

                            <div class="row ml-b-20">
                                <div class="col-lg-12 form-group">
                                    <label>@lang('Verification Code')</label>
                                    <input type="text" name="code" id="code" class="form-control form--control">
                                </div>

                                <div class="col-lg-12 form-group text-center">
                                    <button type="submit" class="submit-btn">
                                        @lang('Verify Code') <i class="las la-sign-in-alt"></i>
                                    </button>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <div class="account-item mt-10">
                                        <label>@lang("Please check including your Junk/Spam Folder. if not found, you can") <a href="{{ route('user.password.request') }}" class="text--base">@lang('Try to send again')</a></label>
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
        $('#code').on('input change', function () {
          var xx = document.getElementById('code').value;
          $(this).val(function (index, value) {
             value = value.substr(0,7);
              return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
          });
      });
    })(jQuery)
</script>
@endpush
