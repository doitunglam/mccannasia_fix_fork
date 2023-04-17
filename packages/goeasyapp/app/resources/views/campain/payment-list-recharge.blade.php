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
        <iframe src="" style="width: 0 !important; height: 0 !important; height"
            title="W3Schools Free Online Web Tutorials" class="dowload-file"></iframe>
        <div class="search_page">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col-4 card p-3 me-3">
                        <form method="POST"
                            action="{{ $type == 1 ? route('payment.recharge') : route('payment.withdraw') }}"
                            enctype="multipart/form-data" style="position: relative;z-index: 1;">
                            @csrf
                            <div class="flex-wrap gap-2">
                                <div class="">
                                    @if ($type == 1)
                                        @if ($config != null)
                                            @foreach ($config as $index => $n)
                                                <?php
                                                $info = json($n->name);
                                                $user = Auth::user();
                                                ?>
                                                <div class="mb-3">
                                                    <h5 class="modal-title" id="transaction-detailModalLabel">
                                                        {{ __trans($language, 'All.tranfer_info', 'Thông tin chuyển khoản') }}
                                                    </h5>

                                                    <p class="mb-2" style="margin-top: 10px;font-weight: bold">
                                                        {{ 'Tên tài khoản' }}:
                                                        <span class="text-primary">{!! $info['name'] !!}</span>
                                                    </p>
                                                    <p class="mb-2" style="margin-top: 10px;font-weight: bold">
                                                        {{ __trans($language, 'All.bank_name', 'Tên ngân hàng') }}:
                                                        <span class="text-primary">{!! $info['bank'] !!}</span>
                                                    </p>
                                                    <p class="mb-4"
                                                        style="margin-bottom: 9px !important;font-weight: bold">
                                                        {{ __trans($language, 'All.bank_account', 'Số tài khoản') }}:
                                                        <span class="text-primary">{!! __transItem($n->value) !!}</span>
                                                    </p>
                                                    <p class="mb-4"
                                                        style="margin-bottom: 9px !important;font-weight: bold">
                                                        {{ 'Nội dung chuyển khoản' }}:
                                                        <span class="text-primary">{!! $user ? $user->username : '' !!}</span>
                                                    </p>
                                                    <i class="text-danger">* Nội dung chuyển khoản không được thay đổi</i>
                                                </div>
                                            @endforeach
                                        @endif
                                    @else
                                        <div class="mb-3">
                                            <h5 class="modal-title" id="transaction-detailModalLabel">
                                                {{ __trans($language, 'All.tranfer_info', 'Thông tin cá nhân') }}</h5>

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
                                    @endif

                                    <div>
                                        <div class="mb-3">
                                            @if ($type == 1)
                                                <label for="name"
                                                    class="form-label">{{ __trans($language, 'All.payment_recharge', 'Nạp tiền') }}</label>
                                            @else
                                                <label for="name"
                                                    class="form-label">{{ __trans($language, 'All.payment_withdraw', 'Rút tiền') }}</label>
                                            @endif
                                            <input type="text" class="form-control s_name" id="payment" placeholder=""
                                                name="payment" value="{{ request()->payment }}">
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

                                                const payment = document.getElementById('payment');
                                                payment.addEventListener('keyup', function(e) {
                                                    const value = e.target.value;
                                                    e.target.value = numberFormat(value);
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="name"
                                            class="form-label">{{ __trans($language, 'All.reason', 'Lý do') }}</label>
                                        <textarea class="form-control s_name" id="reason" placeholder="" name="reason" value="{{ request()->reason }}"
                                            rows="6"></textarea>
                                    </div>
                                </div>
                                @if ($type == 1)
                                    <button type="submit" class="btn btn-danger waves-effect waves-light"
                                        style="height: 36px;margin-top: 26px;"
                                        onclick="return confirm('{{ __trans($language, 'All.confirm_payment_recharge', 'Bạn chắc chắn thực hiện điều này?') }}')">{{ __trans($language, 'All.payment_recharge', 'Nạp') }}</button>
                                @else
                                    <button type="submit" class="btn btn-success waves-effect waves-light"
                                        style="height: 36px;margin-top: 26px;"
                                        onclick="return confirm('{{ __trans($language, 'All.confirm_payment_recharge', 'Bạn chắc chắn thực hiện điều này?') }}')">{{ __trans($language, 'All.payment_withdraw', 'Rút') }}</button>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="col-8 card p-3">
                        <div class="table-responsive">
                            <table class="table table-editable table-nowrap align-middle table-edits">
                                <thead>
                                    <tr style="cursor: pointer;">
                                        @foreach ($td as $i)
                                            <th>{{ $i['title'] }}</th>
                                        @endforeach
                                        <th>{{ __trans($language, 'All.type', 'Loại') }}</th>
                                        <th>{{ __trans($language, 'All.status', 'Trạng thái') }}</th>
                                        <th>{{ __trans($language, 'All.created_at', 'Thời gian tạo') }}</th>
                                        <th>{{ __trans($language, 'All.review_date', 'Thời gian xem xét') }}</th>
                                        <th>{{ __trans($language, 'All.reason', 'Lý do từ chối') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr data-id="1" style="cursor: pointer;">
                                            @foreach ($td as $i)
                                                <?php
                                                $key = $i['value'];
                                                $value = $item->$key;
                                                if ($key === 'amount') {
                                                    $value = currency_format($value);
                                                }
                                                ?>
                                                @if (isset($i['type']) && $i['type'] == 'image')
                                                    <td style="">
                                                        <img style="height: 150px; width: auto"
                                                            src="{!! env('APP_URL') . __transItem($item->$key) !!}" />
                                                    </td>
                                                @else
                                                    <td style="">{{ __transItem($value) }}</td>
                                                @endif
                                            @endforeach
                                            @if ($item->type == '')
                                                <td data-field="name" style="width: 50px;">
                                                    <span
                                                        class="badge rounded-pill badge-soft-success">{{ __trans($language, 'All.withdraw_money', 'Rút tiền') }}</span>
                                                </td>
                                            @else
                                                <td data-field="name" style="width: 50px;">
                                                    <span
                                                        class="badge rounded-pill badge-soft-danger">{{ __trans($language, 'All.recharge', 'Nạp tiền') }}</span>
                                                </td>
                                            @endif

                                            @if ($item->status == 1)
                                                <td data-field="name" style="width: 50px;">
                                                    <span
                                                        class="badge rounded-pill badge-soft-success">{{ __trans($language, 'All.appect', 'Chấp nhận') }}</span>
                                                </td>
                                            @elseif($item->status == 2)
                                                <td data-field="name" style="width: 50px;">
                                                    <span
                                                        class="badge rounded-pill badge-soft-danger">{{ __trans($language, 'All.not_appect', 'Từ chối') }}</span>
                                                </td>
                                            @else
                                                <td data-field="name" style="width: 50px;">
                                                    <span
                                                        class="badge rounded-pill badge-soft-primary">{{ __trans($language, 'All.waiting', 'Đang chờ') }}</span>
                                                </td>
                                            @endif
                                            <td style="">{{ $item->created_at }}</td>
                                            <td style="">{{ $item->updated_at }}</td>
                                            <td style="">{{ $item->reason }}</td>
                                            {{--                                    <td style="width: 30px"> --}}
                                            {{--                                        <a class="btn btn-outline-secondary btn-sm edit" href="{{ route($route, $item->id)}}" title="Edit"> --}}
                                            {{--                                            <i class="fas fa-pencil-alt"></i> --}}
                                            {{--                                        </a> --}}
                                            {{--                                    </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade transaction-detailModal" tabindex="-1" role="dialog"
        aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transaction-detailModalLabel">
                        {{ __trans($language, 'All.error', 'Lỗi') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div style="border-bottom: 1px solid #ddd;position: relative">
                        <?php
                        $err = session('error');
                        ?>
                        <p class="mb-2" style="margin-top: 10px;font-weight: bold">
                            {{ $err }} </span>
                        </p>
                        <p class="mb-2" style="margin-top: 10px;font-weight: bold">
                            {{ 'Nếu có thắc mắc xin liên hệ hỗ trợ' }} </span>
                        </p>
                    </div>

                    <p class="mb-4" style="margin-top: 10px;font-weight: bold">
                        {{ __trans($language, 'All.Amount', 'Số dư của bạn hiện tại: ') }}: <span
                            class="text-primary">{!! __transItem(currency_format($user->amount)) !!}</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __trans($language, 'All.close', 'Đóng') }}</button>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('error'))
        <script>
            $(document).ready(function() {
                $('.transaction-detailModal').modal('show');
            })
        </script>
    @endif
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
@endsection()
