<?php
use App\Models\Language;
use App\Models\Nation;
use App\Models\CountryData;
use App\Models\Payment;
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
                    <div class="page-title-right">
                        @if (!isset($restore))
                            <form action="{{ route('user.delete.all') }}" method="POST" class="delete-form">
                                @csrf
                                <input type="hidden" name="delete_all" class="delete-input" />
                            </form>
                            @if ($user->type == 'super-admin')
                            <a href="{{ route($create) }}" class="btn btn-primary waves-effect waves-light">Thêm mới</a>
                            <a class="btn btn-danger waves-effect waves-light delete-all">Xóa</a>
                            @endif
                        @else
                            <form action="{{ route('user.restore.all') }}" method="POST" class="delete-form">
                                @csrf
                                <input type="hidden" name="delete_all" class="delete-input" />
                            </form>
                            <a class="btn btn-danger waves-effect waves-light delete-all">Khôi phục</a>
                        @endif
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
                                <th>{{ isset($ln['id']) ? $ln['id'] : 'ID' }}</th>
                                <th>{{ isset($ln['xoa']) ? $ln['xoa'] : 'Xóa' }}</th>
                                <th style="text-align:center">{{ isset($ln['name']) ? $ln['name'] : 'Tên' }}</th>
                                <th style="text-align:center">{{ isset($ln['email']) ? $ln['email'] : 'Email' }}</th>
                                <th style="text-align:center">{{ isset($ln['phone']) ? $ln['phone'] : 'Số điện thoại' }}</th>
                                <th style="text-align:center">{{ isset($ln['note']) ? $ln['note'] : 'Ghi chú' }}</th>
                                <th style="text-align:center">{{ isset($ln['last_login_time']) ? $ln['last_login_time'] : 'Lần đăng nhập cuối' }}</th>
                                <th style="text-align:center">{{ isset($ln['recharge']) ? $ln['recharge'] : 'Nạp' }}
                                </th>
                                <th style="text-align:center">{{ isset($ln['withdraw']) ? $ln['withdraw'] : 'Rút' }}
                                </th>
                                <th style="text-align:center">{{ isset($ln['amount']) ? $ln['amount'] : 'Số dư' }}</th>
                                <th style="text-align:center">
                                    {{ isset($ln['created_at']) ? $ln['created_at'] : 'Tạo lúc' }}</th>
                                <th style="text-align:center">{{ isset($ln['block']) ? $ln['block'] : 'Chặn' }}</th>
                                <th style="text-align:center">{{ isset($ln['view']) ? $ln['view'] : 'Xem' }}</th>
                                <th style="text-align:center">{{ isset($ln['password']) ? $ln['password'] : 'Mật khẩu' }}
                                </th>
                                @if (!isset($restore))
                                    <th colspan="2" style="text-align: center">
                                        {{ isset($ln['edit']) ? $ln['edit'] : 'Edit' }}</th>
                                @endif
                                <th style="text-align:center">
                                    {{ isset($ln['change_amount']) ? $ln['change_amount'] : 'Sửa số dư' }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            <form method="GET" class="search-form">
                                <tr data-id="1" style="cursor: pointer;">
                                    <td data-field="id" style="width: 80px"></td>
                                    <td>
                                        <span class="check-all">All</span>
                                    </td>
                                    <td>
                                        <input id="f_name" name="f_name" type="text"
                                            class="form-control get-val-search search-change"
                                            placeholder="{{ isset($ln['name']) ? $ln['name'] : 'Tên' }}">
                                    </td>
                                    <td>
                                        <input id="f_email" name="f_email" type="text"
                                            class="form-control get-val-search search-change"
                                            placeholder="{{ isset($ln['email']) ? $ln['email'] : 'Email' }}">
                                    </td>
                                    <td>
                                        <input id="f_phone" name="f_phone" type="text"
                                            class="form-control get-val-search search-change"
                                            placeholder="{{ isset($ln['phone']) ? $ln['phone'] : 'Số điện thoại' }}">
                                    </td>
                                    <td style="width: 30px"></td>
                                    <td style="width: 30px"></td>
                                    <td style="width: 30px"></td>
                                    @if (!isset($restore))
                                        <td style="width: 30px"></td>
                                        <td style="width: 30px"></td>
                                    @endif
                                </tr>
                            </form>
                            @foreach ($items as $item_)
                                <tr data-id="1" style="cursor: pointer;">
                                    <td data-field="id" style="width: 80px">{{ $item_->id }}</td>
                                    <td>
                                        <input style="height: 20px;" class="form-check-input" type="checkbox"
                                            value="{{ $item_->id }}" />
                                    </td>
                                    <td>
                                        <h5 class="text-truncate font-size-14"><a href="javascript: void(0);"
                                                class="text-dark">{{ $item_->name }}</a></h5>

                                    </td>
                                    <td>
                                        <h5 class="text-truncate font-size-14"><a href="javascript: void(0);"
                                                class="text-dark">{{ $item_->email }}</a></h5>

                                    </td>
                                    <td>
                                        <h5 class="text-truncate font-size-14"><a href="javascript: void(0);"
                                                class="text-dark">{{ $item_->phone }}</a></h5>

                                    </td>

                                    <td>
                                        <h5 class="text-truncate font-size-14"><a href="javascript: void(0);"
                                                class="text-dark">{{ $item_->address }}</a></h5>

                                    </td>
                                    <td>
                                        <div>
                                            <h5 class="text-truncate font-size-14"><a href="javascript: void(0);"
                                                    class="text-dark">{{ $item_->last_login_time }}</a></h5>

                                                </a></h5>
                                                <h5 class="text-truncate font-size-14"><a href="javascript: void(0);"
                                                    class="text-dark">{{ $item_->last_login_ip }}</a></h5>

                                                </a></h5>
                                        </div>

                                    </td>
                                    <?php
                                    $recharge = Payment::where('status', 1)
                                        ->where('type', 1)
                                        ->where('user', $item_->id)
                                        ->sum('amount');
                                    ?>

                                    <td data-field="name" style="width: 50px;"><span
                                            class="badge rounded-pill badge-soft-success">{{ currency_format($recharge) }}</span></td>
                                    <?php
                                    $recharge = Payment::where('status', 1)
                                        ->where('type', null)
                                        ->where('user', $item_->id)
                                        ->sum('amount');
                                    ?>
                                    <?php
                                    $user = User::find($item_->id);
                                    ?>

                                    <td data-field="name" style="width: 50px;"><span
                                            class="badge rounded-pill badge-soft-danger">{{ currency_format($recharge) }}</span></td>
                                    <td data-field="name" style="width: 50px;"><span
                                            class="badge rounded-pill badge-soft-primary">{{ currency_format($user->amount) }}</span></td>
                                    <td data-field="name" style="width: 50px;">
                                        {{ date('d-m-Y', strtotime($item_->created_at)) }}</td>
                                    @if ($item_->status == 1)
                                        <td data-field="name" style="width: 50px;"><a
                                                href="{{ route($status, $item_->id) }}"><span
                                                    class="badge rounded-pill badge-soft-success">{{ __trans($language, 'All.block', 'Block') }}</span></a>
                                        </td>
                                    @else
                                        <td data-field="name" style="width: 50px;"><a
                                                href="{{ route($status, $item_->id) }}"><span
                                                    class="badge rounded-pill badge-soft-danger">{{ __trans($language, 'All.not_block', 'Không chặn') }}</span></a>
                                        </td>
                                    @endif
                                    <td data-field="name" style="width: 50px;"><a
                                            href="{{ route('campain.view.info', $item_->id) }}"><span
                                                class="badge rounded-pill badge-soft-success">{{ __trans($language, 'All.view', 'Xem') }}</span></a>
                                    </td>
                                    <td data-field="name" style="width: 50px;"><a
                                            href="{{ route('user.reset', $item_->id) }}"><span
                                                class="badge rounded-pill badge-soft-primary">{{ __trans($language, 'All.reset', 'Cài lại') }}</span></a>
                                    </td>
                                    @if (!isset($restore))
                                        <td style="width: 30px;padding: 0;">
                                            <a class="edit badge rounded-pill badge-soft-success"
                                                href="{{ route($update, $item_->id) }}" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                        <td style="width: 30px;padding: 0;">
                                            <form action="{{ route($delete, $item_->id) }}" method="post">
                                                {{ csrf_field() }}
                                                @method('DELETE')
                                                <a class="btn-delete badge rounded-pill badge-soft-danger"
                                                    type="button"><i class="fa fa-trash"></i></a>
                                            </form>
                                        </td>
                                    @endif
                                    <td style="width: 30px;padding: 0;" class="text-center">
                                        <a class="edit badge rounded-pill badge-soft-success"
                                            href="{{ route($change_amount, $item_->id) }}" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
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
            $(".btn-delete").click(function() {
                item = $(this);
                var r = confirm("Are you sure delete this item!");
                if (r == true) {
                    item.parent().submit();
                } else {

                }
            });
            var tt = 0;
            $('.check-all').click(function() {
                if (tt == 0) {
                    $('.form-check-input').click();
                    tt = 1;
                } else {
                    $('.form-check-input').click();
                    tt = 0;
                }
            })
            $('.delete-all').click(function() {
                var strong = '';
                for (var i = 0; i < $('.form-check-input:checked').length; i++) {
                    if (i != 0) strong = strong + ',';
                    strong = strong + $('.form-check-input:checked').eq(i).attr('value');
                }
                $('.delete-input').val(strong);
                $('.delete-form').submit();
            })



            @foreach ($search as $key_ => $s)
                @if (isset($search[$key_]))
                    $('input[name="{{ $key_ }}"], select[name="{{ $key_ }}"]').val(
                        '{{ $search[$key_] }}');
                @endif
            @endforeach

            $('.search-change').change(function() {
                $('.search-form').submit();
            })
        });
    </script>
@endsection
