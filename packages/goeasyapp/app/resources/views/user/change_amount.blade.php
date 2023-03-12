<?php

use App\Models\Language;
use App\Models\Type;
use App\Models\Nation;
use App\Models\User;

$lang = (session('locale') ? session('locale') : 'en');
$ln   = Language::where('code', $lang)->first();
$ln   = json_decode($ln->label_, TRUE);
?>@extends('core::layout.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{$title}}</h4>
                    <div class="page-title-right">

                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route($store, $model->id) }}" method="POST" class="form-submit" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="group mb-4">
                        <div class="mb-4">
                            <h4>{{__trans($language, 'All.add_amount', 'Cộng tiền cho ')}}{{$model->name}}</h4>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="productname">{{__trans($language, 'All.amount', 'Số dư')}}</label>
                            </div>
                            <div class="col-md-10">
                                {{$model->amount}}
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-2">
                                <label for="productname">{{__trans($language, 'All.increase_money', 'Cộng thêm')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input id="plus_amount" name="plus_amount" type="number" value="" class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Lưu</button>
        </form>
    </div>

@endsection
