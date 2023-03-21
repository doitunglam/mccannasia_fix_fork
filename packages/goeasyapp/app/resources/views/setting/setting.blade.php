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

    <form action="{{ route('setting.store') }}" method="POST" class="form-submit" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <label class="form-label">Referral bonus</label>
                    <input type="text" class="form-control content-language" name="referral_bonus" value="{{$referral_bonus ? ($referral_bonus->value ?? 50000) : 50000 }}"/>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="d-flex flex-wrap gap-2">
                            <x-component::form.submit default="Lưu"  key="all.save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection()
