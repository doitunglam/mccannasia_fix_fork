@extends('core::layout.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Setting</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-2">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">{{ trans('Referral Bonus') }}</h3>
                    <p class="card-text">{{ trans('To configuration the referral bonus') }}</p>
                    <a href="{{route('setting.edit')}}"
                       class="btn btn-success">{{ trans('Go to config') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
