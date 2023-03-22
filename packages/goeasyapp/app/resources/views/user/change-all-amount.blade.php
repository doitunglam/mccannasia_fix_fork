<?php
use App\Models\Language;
use App\Models\Nation;
use App\Models\CountryData;
use App\Models\Payment;
use App\Models\User;
$lang = (session('locale') ? session('locale') : 'en');
$ln = Language::where('code', $lang)->first();
$ln = json_decode($ln->label_, true);
?>
@extends('core::layout.admin')

@section('content')
	<div class="container-fluid">
        <form action="{{route('user.change_all_amount')}}" method="POST" class="form-submit" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{$title}}</h4>
                        <div class="page-title-right">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">{{__trans($language, 'All.edit', 'Lưu')}}</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-editable table-nowrap align-middle table-edits">
                            <thead>
                            <tr style="cursor: pointer;">
                                <th>{{isset($ln['id']) ?  $ln['id'] : 'ID'}}</th>
                                <th>{{isset($ln['name']) ?  $ln['name'] : 'Tên'}}</th>
                                <th>{{isset($ln['email']) ?  $ln['email'] : 'Email'}}</th>
                                <th style="text-align:center">{{isset($ln['amount']) ?  $ln['amount'] : 'Số dư'}}</th>
                                <th style="text-align:center">{{isset($ln['increase_amount']) ?  $ln['increase_amount'] : 'Cộng thêm'}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item_)
                                <tr data-id="1" style="cursor: pointer;">
                                    <td data-field="id" style="width: 80px">{{$item_->id}}</td>
                                    <td>
                                        <h5 class="text-truncate font-size-14"><a href="javascript: void(0);" class="text-dark">{{$item_->name}}</a></h5>
                                    </td>
                                    <td>
                                        <h5 class="text-truncate font-size-14"><a href="javascript: void(0);" class="text-dark">{{$item_->email}}</a></h5>
                                    </td>
                                    <td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-primary">{{currency_format($item_->amount)}}</span></td>
                                    <td style="width: 30px;padding: 0;" class="text-center">
                                        <input type="text" name="amount[{{$item_->id}}]" value="" class="change_all_amount"/>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
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

                                const plus_amount = document.getElementsByClassName('change_all_amount');
                                for (let i = 0; i < plus_amount.length; i++) {
                                    plus_amount[i].addEventListener('keyup', function(e) {
                                        const value = e.target.value;
                                        e.target.value = numberFormat(value);
                                    });
                                }
                            </script>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
<script>
$(document).ready(function(){
	$(".btn-delete").click(function(){
		item = $(this);
		var r = confirm("Are you sure delete this item!");
		if (r == true) {
			item.parent().submit();
		} else {

		}
	});
	var tt = 0;
	$('.check-all').click(function(){
		if(tt == 0){
			$('.form-check-input').click();
			tt = 1;
		}else{
			$('.form-check-input').click();
			tt = 0;
		}
	})
	$('.delete-all').click(function(){
		var strong = '';
		for( var i = 0;  i < $('.form-check-input:checked').length; i++ ){
			if(i != 0)strong = strong + ',';
			strong = strong + $('.form-check-input:checked').eq(i).attr('value');
		}
		$('.delete-input').val(strong);
		$('.delete-form').submit();
	})



	@foreach($search as $key_ => $s)
		@if(isset($search[$key_]))
			$('input[name="{{$key_}}"], select[name="{{$key_}}"]').val('{{$search[$key_]}}');
		@endif
	@endforeach

	$('.search-change').change(function(){
		$('.search-form').submit();
	})
});
</script>
@endsection
