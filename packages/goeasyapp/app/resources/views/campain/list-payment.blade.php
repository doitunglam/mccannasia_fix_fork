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
            <div class="card search_page d-flex" style="width: 300px; background: rgba(90, 55, 55, 0.2)">
                <div class="d-flex" style="flex-direction: row">
                    <div class="card-body">
                        <a class="btn btn-info waves-effect waves-light mt-3 d-grid" id="btn-view-0"
                            style=" height: 90px; align-items: center"><i
                                class="fa fa-plus"></i>{{ __trans($language, 'All.recharge', 'Nạp tiền') }}</a>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-info waves-effect waves-light mt-3 d-grid" id="btn-view-1"
                            style=" height: 90px; align-items: center"><i
                                class="fa fa-minus"></i>{{ __trans($language, 'All.withdraw', 'Rút tiền') }}</a>
                    </div>
                </div>
                <div class="card-body d-flex" style="flex-direction: column">
                    <a class="btn btn-info waves-effect waves-light mt-2 d-grid" id="btn-view-2"
                        style="width: 100%; height: 50px; align-items: center">{{ __trans($language, 'All.withdraw', 'Chi tiết giao dịch') }}</a>
                </div>
            </div>
            <div class="card" style="width: 78%; background: rgba(90, 55, 55, 0.2); min-height: 300px">
                <div class="card-body">
                    <div class="col-12">
                        <div class="row">
                            <div class="table-responsive" style="min-height: 300px">
                                <div id="view-1">
                                    <form method="POST" action="{{ route('payment.withdraw') }}"
                                        enctype="multipart/form-data" style="position: relative;z-index: 1;">
                                        @csrf
                                        <div class="mb-5">
                                            <h5 class="modal-title" id="transaction-detailModalLabel">
                                                {{ __trans($language, 'All.tranfer_info', 'Thông tin ngân hàng') }}</h5>
                                            <table class="custom-table">
                                                <tr class="custom-table">
                                                    <td class="custom-table"> {{ 'Tên tài khoản' }} </td>
                                                    <td class="custom-table"> {!! $user->bank_name_account ?? 'Unknown' !!} </td>
                                                </tr>
                                                <tr class="custom-table">
                                                    <td class="custom-table">
                                                        {{ __trans($language, 'All.bank_name', 'Tên ngân hàng') }} </td>
                                                    <td class="custom-table"> {!! $user->bank_name ?? 'Unknown' !!} </td>
                                                </tr>
                                                <tr class="custom-table">
                                                    <td class="custom-table">
                                                        {{ __trans($language, 'All.bank_account', 'Số tài khoản') }} </td>
                                                    <td class="custom-table"> {!! $user->bank_account ?? 'Unknown' !!}</td>
                                                </tr>
                                            </table>
                                            <style>
                                                table.custom-table {
                                                    width: 50%;
                                                    border-collapse: collapse;
                                                }

                                                td.custom-table {
                                                    border-bottom: 1px solid black;
                                                    padding: 10px;
                                                }

                                                tr.custom-table {
                                                    display: flex;
                                                    justify-content: space-between;
                                                }

                                                td.custom-table:first-child {
                                                    width: 100%;
                                                }
                                            </style>
                                            {{-- <p style="width: 70%;">
                                                <p class="mb-3" style="margin-top: 10px;font-weight: bold">
                                                    {{ 'Tên tài khoản' }}:
                                                </p>
                                                <span class="text-primary">{!! $user->bank_name_account ?? 'Unknown' !!}</span>
                                            </p>

                                            <p class="mb-3" style="margin-top: 10px;font-weight: bold">
                                                {{ __trans($language, 'All.bank_name', 'Tên ngân hàng') }}:
                                                <span class="text-primary">{!! $user->bank_name ?? 'Unknown' !!}</span>
                                            </p>
                                            <p class="mb-4" style="margin-bottom: 9px !important;font-weight: bold">
                                                {{ __trans($language, 'All.bank_account', 'Số tài khoản') }}:
                                                <span class="text-primary">{!! $user->bank_account ?? 'Unknown' !!}</span>
                                            </p> --}}
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="modal-title" id="transaction-detailModalLabel">
                                                {{ __trans($language, 'All.tranfer_detail', 'Phương thức') }}</h6>
                                            <div class="radio">
                                                <input type="radio" checked label={!! $user->bank_name ?? 'Unknown' !!} />
                                            </div>
                                            {{-- <span class="" style="font-size: 13px">{!! $user->bank_name ?? 'Unknown' !!}</span> --}}
                                        </div>
                                        <style>
                                            .radio {
                                                background: #454857;
                                                padding: 4px;
                                                border-radius: 3px;
                                                box-shadow: inset 0 0 0 3px rgba(35, 33, 45, 0.3),
                                                    0 0 0 3px rgba(185, 185, 185, 0.3);
                                                position: relative;
                                                width: 4.2%;
                                            }

                                            .radio input {
                                                width: auto;
                                                height: 100%;
                                                -webkit-appearance: none;
                                                -moz-appearance: none;
                                                appearance: none;
                                                outline: none;
                                                cursor: pointer;
                                                border-radius: 2px;
                                                padding: 4px 8px;
                                                background: #454857;
                                                color: #bdbdbdbd;
                                                font-size: 14px;
                                                font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
                                                    "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji",
                                                    "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                                                transition: all 100ms linear;
                                            }

                                            .radio input:checked {
                                                background-image: linear-gradient(180deg, #95d891, #74bbad);
                                                color: #fff;
                                                box-shadow: 0 1px 1px #0000002e;
                                                text-shadow: 0 1px 0px #79485f7a;
                                            }

                                            .radio input:before {
                                                content: attr(label);
                                                display: inline-block;
                                                text-align: center;
                                                width: 100%;
                                            }
                                        </style>
                                        <div class="mb-3">
                                            <h6 class="modal-title" id="transaction-detailModalLabel">
                                                {{ __trans($language, 'All.tranfer_limit', 'Giới hạn rút tiền') }}</h6>
                                            <span class="" style="font-size: 20px">200k ~ <i
                                                    class="fa fa-infinity"></i></span>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="modal-title" id="transaction-detailModalLabel">
                                                {{ __trans($language, 'All.tranfer_input', 'Rút tiền qua ngân hàng') }}
                                            </h6>
                                            <input type="number" class="form-control" placeholder="Nhập số tiền rút"
                                                style="width: 30%" name="payment">
                                        </div>
                                        <div class="mb-3">
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
                                        <div class="mb-5">
                                            <h5 class="modal-title" id="transaction-detailModalLabel">
                                                {{ __trans($language, 'All.tranfer_info', 'Thông tin chuyển khoản') }}
                                            </h5>
                                            @foreach ($config as $index => $n)
                                                <?php
                                                $info = json($n->name);
                                                ?>
                                            @endforeach
                                            <table class="custom-table">
                                                <tr class="custom-table">
                                                    <td class="custom-table"> {{ 'Tên tài khoản' }} </td>
                                                    <td class="custom-table"> {!! $info ? $info['name'] : 'Unknown' !!} </td>
                                                </tr>
                                                <tr class="custom-table">
                                                    <td class="custom-table">
                                                        {{ __trans($language, 'All.bank_name', 'Tên ngân hàng') }} </td>
                                                    <td class="custom-table"> {!! $info ? $info['bank'] : 'Unknown' !!}</td>
                                                </tr>
                                                <tr class="custom-table">
                                                    <td class="custom-table">
                                                        {{ __trans($language, 'All.bank_account', 'Số tài khoản') }} </td>
                                                    <td class="custom-table"> {!! $n ? __transItem($n->value) : 'Unknown' !!}</td>
                                                </tr>
                                            </table>

                                            <i class="text-danger">* Nội dung chuyển khoản không được thay đổi</i>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="modal-title" id="transaction-detailModalLabel">
                                                {{ __trans($language, 'All.tranfer_input', 'Nạp tiền') }}</h6>
                                            <input type="number" class="form-control" name="payment"
                                                placeholder="Nhập số tiền nạp" style="width: 30%">
                                        </div>
                                        <div class="mb-3">
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
                                                    href="{{ route('payment.all') }}?date=today" id="btn-view-0"
                                                    style="align-items: center; margin-right:10px">Hôm nay</a>
                                                <a class="btn btn-info waves-effect waves-light mr-2 d-grid"
                                                    href="{{ route('payment.all') }}?date=yesterday" id="btn-view-0"
                                                    style="align-items: center; margin-right:10px">Hôm qua</a>
                                                <a class="btn btn-info waves-effect waves-light mr-2 d-grid"
                                                    href="{{ route('payment.all') }}?date=week" id="btn-view-0"
                                                    style="align-items: center; margin-right:10px">Trong vòng 7 ngày</a>
                                                <a class="btn btn-info waves-effect waves-light mr-2 d-grid"
                                                    href="{{ route('payment.all') }}?date=month" id="btn-view-0"
                                                    style="align-items: center; margin-right:10px">Trong vòng 30 ngày</a>
                                                <div id="dropdown-wrapper" class="dropdown-wrapper" tabindex="1">
                                                    <span class="dropdown-value">---Chọn bộ lọc---</span>
                                                    <ul class="dropdown-list">
                                                        <li><a href="#">Nạp</a></li>
                                                        <li><a href="#">Rút</a></li>
                                                        <li><a href="#">Giao dịch bị từ chối</a></li>
                                                    </ul>
                                                </div>
                                                <input type="text" name="datetimes" />
                                                <a class="btn btn-info waves-effect waves-light ml-2 d-grid"
                                                    onclick="handleFilter()" id="btn-view-0"
                                                    style="align-items: center; margin-left:10px">
                                                    Lọc</a>
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
                                                <tr data-id="1" style="cursor: pointer;"
                                                    class="item-{{ $item->type }}">
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" defer>
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $('.get-download').click(function() {
            var url = "{{ route('campain.download', ['s_name' => request()->s_name]) }}";
            $('.dowload-file').attr('src', url);
        })
    </script>
    @stack('c-script')
    <script>
        let startDate = '';
        let endDate = '';
        const typeMap = {
            "Nạp": 1,
            "Rút": 2,
            "Giao dịch bị từ chối": 3
        }
        const handleFilter = () => {
            let url = "<?php echo route('payment.all'); ?>";
            const type = $('.dropdown-value').text();
            const hasType = ["Giao dịch bị từ chối", "Nạp", "Rút"].includes(type);
            if (hasType) {
                url += `?type=${typeMap[type]}`;
            }
            if (startDate && endDate) {
                if (!hasType) {
                    url += `?type=0`;
                }
                url +=
                    `&from=${moment(startDate).startOf('day').toISOString()}&to=${moment(endDate).endOf('day').toISOString()}`;
            }
            window.location.href = url;
        }
        $(document).ready(function() {
            $("input[name='datetimes']").daterangepicker({},
                function(start, end, label) {
                    startDate = start.format("YYYY-MM-DD").toString();
                    endDate = end.format("YYYY-MM-DD").toString();
                }
            );
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
            const type = "<?php echo request()->type; ?>";
            const date = "<?php echo request()->date; ?>"
            if (date || type) {
                $("#view-0").addClass('d-none');
                $("#view-1").addClass('d-none');
                $("#view-2").removeClass('d-none');
            }
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
        const dd = document.querySelector('#dropdown-wrapper');
        const links = document.querySelectorAll('.dropdown-list a');
        const span = document.querySelector('span.dropdown-value');

        dd.addEventListener('click', function() {
            this.classList.toggle('is-active');
        });

        links.forEach((element) => {
            element.addEventListener('click', function(evt) {
                span.innerHTML = evt.currentTarget.textContent;
            })
        })
    </script>
    <style>
        .dropdown-wrapper {
            position: relative;
            width: 240px;
            margin: 10px;
            padding: 12px 15px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.2);
            cursor: pointer;
            outline: none;
            transition: all 0.3s ease-out;
        }

        .dropdown-wrapper:after {
            content: "";
            width: 0;
            height: 0;
            position: absolute;
            top: 50%;
            right: 15px;
            margin-top: -3px;
            border-width: 6px 6px 0 6px;
            border-style: solid;
            border-color: #f05b55 transparent;
        }

        .dropdown-wrapper.is-active {
            border-radius: 5px 5px 0 0;
            background: #f05b55;
            box-shadow: none;
            border-bottom: none;
            color: white;
        }

        .dropdown-wrapper.is-active:after {
            border-color: #ffffff transparent;
            transform: rotate(180deg);
        }

        .dropdown-wrapper.is-active .dropdown-list {
            border-bottom: 1px solid rgba(0, 0, 0, 0.2);
            max-height: 400px;
        }

        .dropdown-list {
            /* Size & position */
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            /* Styles */
            background: #fff;
            border-radius: 0 0 5px 5px;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-top: none;
            border-bottom: none;
            list-style: none;
            transition: all 0.3s ease-out;
            /* Hiding */
            max-height: 0;
            overflow: hidden;
        }

        .dropdown-list li {
            padding: 0 10px;
        }

        .dropdown-list li:hover a {
            color: #f05b55;
        }

        .dropdown-list li:last-of-type a {
            border: none;
        }

        .dropdown-list a {
            display: block;
            text-decoration: none;
            color: #333;
            padding: 10px 0;
            transition: all 0.3s ease-out;
            border-bottom: 1px solid #e6e8ea;
        }
    </style>
@endsection()
