@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="card-area section--bg ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="card custom--card">
                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                            <h4 class="card-title mb-0">
                                @lang('Profile Settings')
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="card-form-wrapper">
                                <form action="" method="post" role="form" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row justify-content-center mb-20-none">
                                        <div class="col-xl-6 col-lg-6 form-group">
                                            <label>@lang('First Name')</label>
                                            <input type="text" class="form--control" id="InputFirstname" name="firstname" placeholder="@lang('First Name')" value="{{$user->firstname}}" minlength="3">
                                        </div>
                                        <div class="col-xl-6 col-lg-6 form-group">
                                            <label>@lang('Last Name')</label>
                                            <input type="text" class="form--control" id="lastname" name="lastname" placeholder="@lang('Last Name')" value="{{$user->lastname}}" required>
                                        </div>
                                        <div class="col-xl-6 form-group">
                                            <label>@lang('E-mail Address')</label>
                                            <input class="form--control" id="email" placeholder="@lang('E-mail Address')" value="{{$user->email}}" readonly>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 form-group">
                                            <label>@lang('Mobile Number')</label>
                                            <input class="form--control" id="phone" value="{{$user->mobile}}" readonly>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 form-group">
                                            <label>@lang('Address')</label>
                                            <input type="text" class="form--control" id="address" name="address" placeholder="@lang('Address')" value="{{@$user->address->address}}" required>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 form-group">
                                            <label>@lang('State')</label>
                                            <input type="text" class="form--control" id="state" name="state" placeholder="@lang('state')" value="{{@$user->address->state}}" required="">
                                        </div>
                                        <div class="col-xl-4 col-lg-6 form-group">
                                            <label>@lang('Zip Code')</label>
                                            <input type="text" class="form--control" id="zip" name="zip" placeholder="@lang('Zip Code')" value="{{@$user->address->zip}}" required="">
                                        </div>
                                        <div class="col-xl-4 col-lg-6 form-group">
                                            <label>@lang('City')</label>
                                            <input type="text" class="form--control" id="city" name="city" placeholder="@lang('City')" value="{{@$user->address->city}}" required="">
                                        </div>
                                        <div class="col-xl-4 col-lg-6 form-group">
                                            <label>@lang('Country')</label>
                                            <input class="form--control" value="{{@$user->address->country}}" disabled>
                                        </div>
                                        <div class="col-xl-12 form-group">
                                            <button type="submit" class="submit-btn w-100">@lang('UPDATE PROFILE')</button>
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

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue.'css/bootstrap-fileinput.css') }}" rel="stylesheet">
@endpush
@push('style')
    <link rel="stylesheet" href="{{asset('assets/admin/build/css/intlTelInput.css')}}">
    <style>
        .intl-tel-input {
            position: relative;
            display: inline-block;
            width: 100%;!important;
        }
    </style>
@endpush
