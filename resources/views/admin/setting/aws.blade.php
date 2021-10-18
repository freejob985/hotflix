@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">


        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">

                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf


                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Access Key')</label>
                                    <input class="form-control form-control-lg" type="text" name="aws[access_key]" value="{{@$setting->aws->access_key}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Secret Access Key')</label>
                                    <input class="form-control form-control-lg" type="text" name="aws[secret_access_key]" value="{{@$setting->aws->secret_access_key}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Regeion')</label>
                                    <input class="form-control form-control-lg" type="text" name="aws[regeion]" value="{{@$setting->aws->regeion}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Bucket')</label>
                                    <input class="form-control form-control-lg" type="text" name="aws[bucket]" value="{{@$setting->aws->bucket}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('URL')</label>
                                    <input class="form-control form-control-lg" type="text" name="aws[url]" value="{{@$setting->aws->url}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Endpoint')</label>
                                    <input class="form-control form-control-lg" type="text" name="aws[endpoint]" value="{{@$setting->aws->endpoint}}">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

