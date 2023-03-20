@extends('core::layout.admin')
@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{$title}}</h4>



            </div>

        </div>

    </div>



    <form action="{{ route($route, 0) }}" method="POST" class="form-submit" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <div class="col-12">
                        <div class="row show-html">
                            <div class="col-9">
                                <x-component::form.text name="name[name]" default="Name" value="" id="link" key="all.name" placeholder="All.enter_name" defaultplaceholder="Nhập tên"/>
                                <div class="form-group mb-3">
                                    <label for="name_bank">Tên ngân hàng</label>
                                    <select name="name[bank]" class="select2 form-control" id="name_bank">
                                        <option value="">-- Chọn Ngân Hàng --</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank['shortName'] }}">{{ $bank['shortName'] }} - {{ $bank['vn_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-component::form.text name="value" default="Bank Account" value="" id="link" key="all.bank_account" placeholder="All.enter_bank_account" defaultplaceholder="Nhập tài khoản"/>
                            </div>
                            <div class="col-3">
                                <x-component::input.ckfinder name="image" value="" key="all.image" default="Image" id="ckfinder"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="d-flex flex-wrap gap-2">
                            <x-component::form.submit default="Save" key="all.save"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection()
@section('script')
@stack('c-script')
<script>
$(document).ready(function(){

})
</script>
@endsection()
