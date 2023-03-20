<?php
use App\Models\Language;
use App\Models\Nation;
use App\Models\CountryData;
use App\Models\Resuft;
use App\Models\User;
$lang = session('locale') ? session('locale') : 'en';
$ln = Language::where('code', $lang)->first();
$ln = json_decode($ln->label_, true);
?>
@extends('core::layout.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        <thead>
                            <tr style="cursor: pointer;">
                                <th>{{ isset($ln['id']) ? $ln['id'] : 'ID' }}</th>
                                <th style="text-align:center">
                                    {{ isset($ln['name_campain']) ? $ln['name_campain'] : 'Tên chiến dịch' }}</th>
                                <th style="text-align:center">{{ isset($ln['username']) ? $ln['username'] : 'Người làm' }}
                                </th>
                                <th style="text-align:center">{{ isset($ln['amount']) ? $ln['amount'] : 'Số tiền' }}</th>
                                <th style="text-align:center">{{ isset($ln['explain']) ? $ln['explain'] : 'Giải trình' }}
                                </th>
                                <th style="text-align:center">{{ isset($ln['image']) ? $ln['image'] : 'Hình ảnh' }}
                                </th>
                                <th style="text-align:center">{{ isset($ln['action']) ? $ln['action'] : 'Thao tác' }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td style="text-align:center">{{ $item->campain_name }}</td>
                                    <td style="text-align:center">{{ $item->user_name }}</td>
                                    <td style="text-align:center">{{ currency_format($item->price) }}</td>
                                    <td style="text-align:center">
                                        <?php
                                        $explain = json_decode($item->resuft_explain, true);
                                        ?>
                                        <span>{{ $explain[0] ?? '' }}</span>
                                    </td>
                                    <td style="text-align:center">
                                        <?php
                                        // get first image
                                        $images = json_decode($item->resuft, true);
                                        $image = [];

                                        if ($images != null && count($images) > 0) {
                                            $image = $images[0];
                                        }
                                        ?>
                                        <img src="{{ $image[0] ?? '' }}" alt=""
                                            style="width: 100px; height: 100px; pointer: cursor;" onclick="window.open(this.src)" />
                                    </td>
                                    <td style="text-align:center">
                                        <form action="{{ route($route)."/".$item->id }}" method="POST"
                                            class="form-submit{{ $item->id }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="status" class="check-status{{ $item->id }}" />
                                            @if ($item->status == 0)
                                                <div class="d-flex flex-wrap gap-2">
                                                    <button
                                                        class="btn btn-primary waves-effect waves-light appect{{ $item->id }}"
                                                        type="button"
                                                        onclick="return confirm('{{ __trans($language, 'All.confirm_payment_recharge', 'Bạn chắc chắn thực hiện điều này?') }}')">{{ __trans($language, 'all.appect', 'Chấp nhận') }}</button>
                                                    <button
                                                        class="btn btn-danger waves-effect waves-light not_appect{{ $item->id }}"
                                                        type="button"
                                                        onclick="return confirm('{{ __trans($language, 'All.confirm_payment_recharge', 'Bạn chắc chắn thực hiện điều này?') }}')">{{ __trans($language, 'all.not_appect', 'Từ chối') }}</button>
                                                </div>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            @foreach ($items as $item)
                $('.appect{{ $item->id }}').click(function() {
                    $('.check-status{{ $item->id }}').val(1);
                    $('.form-submit{{ $item->id }}').submit();
                })
                $('.not_appect{{ $item->id }}').click(function() {
                    $('.check-status{{ $item->id }}').val(2);
                    $('.form-submit{{ $item->id }}').submit();
                })
            @endforeach

            $(".shadow-sm").addClass('d-none');
            $(".flex-1").addClass('mb-3');
        })
    </script>
@endsection
