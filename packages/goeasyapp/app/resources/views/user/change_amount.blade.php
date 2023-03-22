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
                            <h4>{{__trans($language, 'All.add_amount', 'Cộng tiền cho ')}} {{$model->name}}</h4>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="productname">{{__trans($language, 'All.amount', 'Số dư')}}</label>
                            </div>
                            <div class="col-md-10">
                                {{currency_format($model->amount)}}
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-2">
                                <label for="productname">{{__trans($language, 'All.increase_money', 'Cộng thêm')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input id="plus_amount" name="plus_amount" type="text" value="" class="form-control" autocomplete="off">
                            </div>
                            <script>
                                function numberFormat(number, decimals = 0, decPoint = '.', thousandsSep = ',') {
                                    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                                    const n = !isFinite(+number) ? 0 : +number;
                                    const prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
                                    const sep = thousandsSep;
                                    const dec = decPoint;
                                    const toFixedFix = (n, prec) => {
                                        const k = Math.pow(10, prec);
                                        return '' + Math.round(n * k) / k;
                                    };
                                    let s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                                    if (s[0].length > 3) {
                                        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                                    }
                                    if ((s[1] || '').length < prec) {
                                        s[1] = s[1] || '';
                                        s[1] += new Array(prec - s[1].length + 1).join('0');
                                    }
                                    return s.join(dec);
                                }

                                const plus_amount = document.getElementById('plus_amount');
                                plus_amount.addEventListener('keyup', function(e) {
                                    const value = e.target.value;
                                    e.target.value = numberFormat(value);
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Lưu</button>
        </form>
    </div>

@endsection
