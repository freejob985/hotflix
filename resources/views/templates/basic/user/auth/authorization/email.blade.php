@extends($activeTemplate .'layouts.master')
@section('content')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Card
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="card-area section--bg ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="card custom--card">
                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                            <h4 class="card-title mb-0">
                                @lang('Please Verify Your Email to Get Access')
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="card-form-wrapper">
                                <form action="{{route('user.verify.email')}}" method="post" role="form">
                                    @csrf

                                    <div class="row justify-content-center mb-20-none">
                                        <div class="col-xl-12 form-group">
                                            <p class="text-center">@lang('Your Email'):  <strong>{{auth()->user()->email}}</strong></p>
                                        </div>
                                        <div class="col-xl-12 form-group">
                                            <label>@lang('Verification Code')</label>
                                            <input type="text" name="email_verified_code" class="form-control form--control" maxlength="7" id="code">
                                        </div>
                                        <div class="col-xl-12 form-group">
                                            <button type="submit" class="submit-btn w-100">@lang('Submit')</button>
                                        </div>
                                        <div class="col-xl-12 form-group text-center">
                                            <p>@lang('Please check including your Junk/Spam Folder. if not found, you can') <a href="{{route('user.send.verify.code')}}?type=email" class="forget-pass text--base"> @lang('Resend code')</a></p>
                                            @if ($errors->has('resend'))
                                                <br/>
                                                <small class="text-danger">{{ $errors->first('resend') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Card
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
