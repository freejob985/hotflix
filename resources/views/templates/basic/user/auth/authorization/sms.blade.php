@extends($activeTemplate .'layouts.master')
@section('content')
    <div class="card-area section--bg ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="card custom--card">
                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                            <h4 class="card-title mb-0">
                                @lang('Please Verify Your Mobile to Get Access')
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="card-form-wrapper">
                                <form action="{{route('user.verify.sms')}}" method="post" role="form">
                                    @csrf

                                    <div class="row justify-content-center mb-20-none">
                                        <div class="col-xl-12 form-group">
                                            <p class="text-center">@lang('Your Mobile Number'):  <strong>{{auth()->user()->mobile}}</strong></p>
                                        </div>
                                        <div class="col-xl-12 form-group">
                                            <label>@lang('Verification Code')</label>
                                            <input type="text" name="sms_verified_code" id="code" class="form-control form--control">
                                        </div>
                                        <div class="col-xl-12 form-group">
                                            <button type="submit" class="submit-btn w-100">@lang('Submit')</button>
                                        </div>
                                        <div class="col-xl-12 form-group text-center">
                                            <p>@lang('If you don\'t get any code'), <a href="{{route('user.send.verify.code')}}?type=phone" class="forget-pass text--base"> @lang('Try again')</a></p>
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
