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
        <div class="d-flex" style="justify-content: space-between">
            <div class="card search_page d-flex" style="width: 20%">
                <div class="d-flex" style="flex-direction: row">
                    <div class="card-body">
                        <a class="btn btn-success waves-effect waves-light mt-3 d-grid" id="btn-view-0"
                            style="width: 110px; height: 110px; align-items: center">{{ __trans($language, 'All.recharge', 'Nạp tiền') }}</a>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-danger waves-effect waves-light mt-3 d-grid" id="btn-view-1"
                            style="width: 110px; height: 110px; align-items: center">{{ __trans($language, 'All.withdraw', 'Rút tiền') }}</a>
                    </div>
                </div>
                <div class="card-body d-flex" style="flex-direction: column">
                    <a class="btn btn-danger waves-effect waves-light mt-3 d-grid" id="btn-view-2"
                        style="width: 100%; height: 50px; align-items: center">{{ __trans($language, 'All.withdraw', 'Chi tiết giao dịch') }}</a>
                </div>
            </div>
            <div class="card" style="width: 78%">
                <div class="card-body">
                    <div class="col-12">
                        <div class="row">
                            <div class="table-responsive">
                                <div id="view-1">
                                    <form method="POST" action="{{ route('payment.withdraw') }}"
                                        enctype="multipart/form-data" style="position: relative;z-index: 1;">
                                        @csrf
                                        <div class="mb-3">
                                            <h5 class="modal-title" id="transaction-detailModalLabel">
                                                {{ __trans($language, 'All.tranfer_info', 'Thông tin ngân hàng') }}</h5>
                                            <p class="mb-2" style="margin-top: 10px;font-weight: bold">
                                                {{ 'Tên tài khoản' }}:
                                                <span class="text-primary">{!! $user->bank_name_account ?? 'Unknown' !!}</span>
                                            </p>
                                            <p class="mb-2" style="margin-top: 10px;font-weight: bold">
                                                {{ __trans($language, 'All.bank_name', 'Tên ngân hàng') }}:
                                                <span class="text-primary">{!! $user->bank_name ?? 'Unknown' !!}</span>
                                            </p>
                                            <p class="mb-4" style="margin-bottom: 9px !important;font-weight: bold">
                                                {{ __trans($language, 'All.bank_account', 'Số tài khoản') }}:
                                                <span class="text-primary">{!! $user->bank_account ?? 'Unknown' !!}</span>
                                            </p>
                                        </div>
                                        <div class="mb-2">
                                            <h6 class="modal-title" id="transaction-detailModalLabel">
                                                {{ __trans($language, 'All.tranfer_detail', 'Phương thức') }}</h6>
                                            <input type="radio" checked>
                                            <span class="" style="font-size: 13px">{!! $user->bank_name ?? 'Unknown' !!}</span>
                                        </div>
                                        <div class="mb-2">
                                            <h6 class="modal-title" id="transaction-detailModalLabel">
                                                {{ __trans($language, 'All.tranfer_limit', 'Giới hạn rút tiền') }}</h6>
                                            <span class="" style="font-size: 13px">200k ~ ∞</span>
                                        </div>
                                        <div class="mb-2">
                                            <h6 class="modal-title" id="transaction-detailModalLabel">
                                                {{ __trans($language, 'All.tranfer_input', 'Rút tiền qua ngân hàng') }}
                                            </h6>
                                            <input type="number" class="form-control" placeholder="Nhập số tiền rút"
                                                style="width: 30%" name="payment">
                                        </div>
                                        <div class="mb-2">
                                            <button class="btn btn-danger waves-effect waves-light mt-3 d-grid"
                                                style="width: 30%; height: 40px; align-items: center"
                                                onclick="return confirm('{{ __trans($language, 'All.confirm_payment_recharge', 'Bạn chắc chắn thực hiện điều này?') }}')">{{ __trans($language, 'All.withdraw', 'Rút tiền') }}</a>
                                        </div>
                                    </form>
                                </div>
                                <div id="view-0" class="view-1 d-none">
                                    <form method="POST" action="{{ route('payment.recharge') }}"
                                        enctype="multipart/form-data" style="position: relative;z-index: 1;">
                                        @csrf
                                        <div class="mb-3">
                                            <h5 class="modal-title" id="transaction-detailModalLabel">
                                                {{ __trans($language, 'All.tranfer_info', 'Thông tin chuyển khoản') }}
                                            </h5>
                                            @foreach ($config as $index => $n)
                                                <?php
                                                $info = json($n->name);
                                                ?>
                                            @endforeach

                                            <p class="mb-2" style="margin-top: 10px;font-weight: bold">
                                                {{ 'Tên tài khoản' }}:
                                                <span class="text-primary">{!! $info['name'] !!}</span>
                                            </p>
                                            <p class="mb-2" style="margin-top: 10px;font-weight: bold">
                                                {{ __trans($language, 'All.bank_name', 'Tên ngân hàng') }}:
                                                <span class="text-primary">{!! $info['bank'] !!}</span>
                                            </p>
                                            <p class="mb-4" style="margin-bottom: 9px !important;font-weight: bold">
                                                {{ __trans($language, 'All.bank_account', 'Số tài khoản') }}:
                                                <span class="text-primary">{!! __transItem($n->value) !!}</span>
                                            </p>
                                            <p class="mb-4" style="margin-bottom: 9px !important;font-weight: bold">
                                                {{ 'Nội dung chuyển khoản' }}:
                                                <span class="text-primary">{!! $user ? $user->username : '' !!}</span>
                                            </p>
                                            <i class="text-danger">* Nội dung chuyển khoản không được thay đổi</i>
                                        </div>
                                        <div class="mb-2">
                                            <h6 class="modal-title" id="transaction-detailModalLabel">
                                                {{ __trans($language, 'All.tranfer_input', 'Nạp tiền') }}</h6>
                                            <input type="number" class="form-control" name="payment"
                                                placeholder="Nhập số tiền nạp" style="width: 30%">
                                        </div>
                                        <div class="mb-2">
                                            <button class="btn btn-danger waves-effect waves-light mt-3 d-grid"
                                                style="width: 30%; height: 40px; align-items: center"
                                                onclick="return confirm('{{ __trans($language, 'All.confirm_payment_recharge', 'Bạn chắc chắn thực hiện điều này?') }}')">{{ __trans($language, 'All.recharge', 'Nạp tiền') }}</a>
                                        </div>
                                    </form>
                                </div>
                                <div id="view-2" class="d-none">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center">
                                                <a class="btn btn-info waves-effect waves-light mr-2 d-grid"
                                                    href="{{ route('payment.all') }}?date=today"
                                                    id="btn-view-0" style="align-items: center; margin-right:10px">Hôm nay</a>
                                                <a class="btn btn-info waves-effect waves-light mr-2 d-grid"
                                                    href="{{ route('payment.all') }}?date=yesterday"
                                                    id="btn-view-0" style="align-items: center; margin-right:10px">Hôm qua</a>
                                                <a class="btn btn-info waves-effect waves-light mr-2 d-grid"
                                                    href="{{ route('payment.all') }}?date=week"
                                                    id="btn-view-0" style="align-items: center; margin-right:10px">Trong vòng 7 ngày</a>
                                                <a class="btn btn-info waves-effect waves-light mr-2 d-grid"
                                                    href="{{ route('payment.all') }}?date=month"
                                                    id="btn-view-0" style="align-items: center; margin-right:10px">Trong vòng 30 ngày</a>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-editable table-nowrap align-middle table-edits">
                                        <thead>
                                            <tr style="cursor: pointer;">
                                                <th>{{ __trans($language, 'All.type', 'Loại') }}</th>
                                                <th>{{ __trans($language, 'All.amount', 'Số tiền') }}</th>
                                                <th>{{ __trans($language, 'All.status', 'Trạng thái') }}</th>
                                                <th>{{ __trans($language, 'All.created_at', 'Thời gian tạo') }}</th>
                                                <th>{{ __trans($language, 'All.review_date', 'Thời gian xem xét') }}</th>
                                                <th>{{ __trans($language, 'All.reason', 'Lý do') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr data-id="1" style="cursor: pointer;" class="item-{{ $item->type }}">
                                                    @if ($item->type == '')
                                                        <td data-field="name" style="width: 50px;"><span
                                                                class="badge rounded-pill badge-soft-success">{{ __trans($language, 'All.withdraw_money', 'Rút tiền') }}</span>
                                                        </td>
                                                    @else
                                                        <td data-field="name" style="width: 50px;"><span
                                                                class="badge rounded-pill badge-soft-danger">{{ __trans($language, 'All.recharge', 'Nạp tiền') }}</span>
                                                        </td>
                                                    @endif
                                                    <td style="">{{ currency_format($item->amount) }}</td>
                                                    @if ($item->status == 1)
                                                        <td data-field="name" style="width: 50px;"><span
                                                                class="badge rounded-pill badge-soft-success">{{ __trans($language, 'All.appect', 'Chấp nhận') }}</span>
                                                        </td>
                                                    @elseif($item->status == 2)
                                                        <td data-field="name" style="width: 50px;"><span
                                                                class="badge rounded-pill badge-soft-danger">{{ __trans($language, 'All.not_appect', 'Từ chối') }}</span>
                                                        </td>
                                                    @else
                                                        <td data-field="name" style="width: 50px;"><span
                                                                class="badge rounded-pill badge-soft-primary">{{ __trans($language, 'All.waiting', 'Đang chờ') }}</span>
                                                        </td>
                                                    @endif
                                                    <td style="">{{ $item->created_at }}</td>
                                                    <td style="">{{ $item->updated_at }}</td>
                                                    <td style="">{{ $item->reason }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $items->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection()
@section('script')
    <script>
        $('.get-download').click(function() {
            var url = "{{ route('campain.download', ['s_name' => request()->s_name]) }}";
            $('.dowload-file').attr('src', url);
        })
    </script>
    @stack('c-script')
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
            @if (request()->date)
                $("#view-0").addClass('d-none');
                $("#view-1").addClass('d-none');
                $("#view-2").removeClass('d-none');
            @endif
            $("#btn-view-0").click(function() {
                $("#view-0").removeClass('d-none');
                $("#view-1").addClass('d-none');
                $("#view-2").addClass('d-none');
            })
            $("#btn-view-1").click(function() {
                $("#view-0").addClass('d-none');
                $("#view-1").removeClass('d-none');
                $("#view-2").addClass('d-none');
            })
            $("#btn-view-2").click(function() {
                $("#view-0").addClass('d-none');
                $("#view-1").addClass('d-none');
                $("#view-2").removeClass('d-none');
            })
            $(".shadow-sm").addClass('d-none');
            $(".flex-1").addClass('mb-3');
        })
    </script>
@endsection()
