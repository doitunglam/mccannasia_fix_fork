@extends('core::layout.admin')
@section('content')
    <form action="{{ route($route, $item->id) }}" method="POST" class="form-submit" enctype="multipart/form-data">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $title }} : {{ __transItem($item->name) }}</h4>
                    </div>
                </div>
            </div>
            <div class="bg-white py-4 px-2 mb-4">
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center justify-content-end border-end">
                        <div class="px-5">
                            <div class="rounded-circle avatar-wrapper">
                                <img class="card-img-top img-fluid h-100 img-campaign rounded-circle"
                                    src="{!! env('APP_URL') . __transItem($item->image) !!}" onerror="this.src='{{ asset('upload/no-image.png') }}'"
                                    alt="add alternative text here">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="px-5">
                            <h4 class="fw-bold">{{ __transItem($item->name) }}</h4>
                            <div class="d-flex mb-3">
                                <div class="me-2">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fas fa-star-half-alt checked"></span>
                                </div>
                                <div>(31) | 21,734</div>
                            </div>
                            <div>
                                <?php
                                $is_before_now = false;
                                if ($item->date_public != null) {
                                    $date_public = DateTime::createFromFormat('d/m/Y', $item->date_public);
                                    $date_public->add(new DateInterval('P' . $item->date_end . 'D'));
                                    $is_before_now = \Carbon\Carbon::parse($date_public)->isBefore(\Carbon\Carbon::now());
                                }
                                ?>
                                @if (!$is_before_now)
                                    @if (!$info)
                                        <x-component::form.submit default="Đăng ký" key="all.register" />
                                    @else
                                        <a href="{{ route('campain.link', $item->id) }}"
                                            class="btn btn-primary waves-effect waves-light">{{ __trans($language, 'all.create_link', 'Tạo link') }}</a>
                                    @endif
                                @else
                                    <span>Đã hết thời gian đăng ký</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @csrf
            @if (isset($use_))
                <input type="hidden" name="use_" value="{{ $use_ }}" />
            @endif
            <div class="card">
                <div class="card-body">
                    <h5>{{ __trans($language, 'All.description', 'Mô tả') }}</h5>
                    {!! __transItem($item->description) !!}
                    <h5 style="margin-top: 20px;">{{ __trans($language, 'All.Reason_for_cancellation', 'Lý do huỷ') }}</h5>
                    {!! __transItem($item->reson_cancel) !!}
                    <h5 style="margin-top: 20px;">{{ __trans($language, 'All.registration_fee', 'Phí đăng ký') }}</h5>
                    <p>
                        {!! currency_format(__transItem($item->registration_fee)) !!} </p>
                    <h5 style="margin-top: 20px;">{{ __trans($language, 'All.price', 'Giá') }}</h5>
                    <p>
                        {!! currency_format(__transItem($item->price)) !!}/ {{ __trans($language, 'All.day', 'Số ngày') }}
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5>{{ __trans($language, 'All.mission_name', 'Tên nhiệm vụ') }}</h5>
                    {!! __transItem($item->mission_name) !!}
                    <h5 style="margin-top: 20px;">{{ __trans($language, 'All.mission_content', 'Nội dung nhiệm vụ') }}</h5>
                    {!! __transItem($item->content) !!}
                    <h5 style="margin-top: 20px;">{{ __trans($language, 'All.daily_profit', 'Lợi nhuận hàng ngày') }}</h5>
                    <p>
                        {!! currency_format(__transItem($item->daily_profit)) !!} </p>
                    <h5 style="margin-top: 20px;">{{ __trans($language, 'All.binding_fee', 'Phí ràng buộc') }}</h5>
                    <p>
                        {!! currency_format(__transItem($item->binding_fee)) !!}
                    </p>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade transaction-detailModal" tabindex="-1" role="dialog"
        aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transaction-detailModalLabel">
                        {{ __trans($language, 'All.tranfer_info', 'Thông tin chuyển khoản') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach ($config as $index => $n)
                        <?php
                        $info = json($n->name);
                        ?>
                        <div style="border-bottom: 1px solid #ddd;position: relative">
                            <p class="mb-2" style="margin-top: 10px;font-weight: bold">
                                {{ 'Tên tài khoản' }}: <span class="text-primary">{!! $info['name'] !!}</span>
                            </p>
                            <p class="mb-2" style="margin-top: 10px;font-weight: bold">
                                {{ __trans($language, 'All.bank_name', 'Tên ngân hàng') }}:
                                <span class="text-primary">{!! $info['bank'] !!}</span>
                            </p>
                            <p class="mb-4" style="margin-bottom: 9px !important;font-weight: bold">
                                {{ __trans($language, 'All.bank_account', 'Số tài khoản') }}: <span
                                    class="text-primary">{!! __transItem($n->value) !!}</span></p>
                            <p class="mb-4" style="margin-bottom: 9px !important;font-weight: bold">
                                {{ 'Nội dung chuyển khoản' }}: <span class="text-primary">{!! $info['name'] !!}</span>
                            </p>
                            <i class="text-danger">* Nội dung chuyển khoản không được thay đổi</i>
                            <img src="{{ asset($n->image) }}"
                                style="position: absolute; top: -16px;right: 0;height: 61px;" />
                        </div>
                    @endforeach

                    <p class="mb-4" style="margin-top: 10px;font-weight: bold">
                        {{ __trans($language, 'All.Amount', 'Số tiền cần chuyển') }}: <span
                            class="text-primary">{!! __transItem(currency_format($item->registration_fee)) !!}</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success done-payment"
                        data-bs-dismiss="modal">{{ __trans($language, 'All.done', 'Hoàn thành') }}</button>
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __trans($language, 'All.close', 'Đóng') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade error-beginner-modal" tabindex="-1" role="dialog" aria-labelledby="error-beginner-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="error-beginner-modalLabel">
                        {{ __trans($language, 'All.error', 'Lỗi') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-4 error-dialog" style="margin-top: 10px;font-weight: bold"></p>
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
    @if (session()->has('error_beginner'))
        <script>
            $(document).ready(function() {
                $('.error-dialog').html('Chiến dịch này chỉ áp dụng cho người mới bắt đầu')
                $('.error-beginner-modal').modal('show');
            })
        </script>
    @endif
    @if (session()->has('error_more_campain'))
        <script>
            $(document).ready(function() {
                $('.error-dialog').html('Bạn không thể đăng ký 2 chiến dịch cùng một thời điểm!')
                $('.error-beginner-modal').modal('show');
            })
        </script>
    @endif
@endsection()
@section('script')
    @stack('c-script')
    <script>
        $(document).ready(function() {
            $('.done-payment').click(function() {
                var fd = new FormData();
                fd.append('price', {{ $item->registration_fee }});
                fd.append('type', 1);
                $.ajax({
                    type: 'post',
                    url: "{{ route('home.base') }}" + '/admin/payment/done',
                    contentType: false,
                    data: fd,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    traditional: true,
                    success: function(data) {

                    }
                });
            })
            $('.add_task').click(function() {
                var parent = $(this).parent();
                var val = parent.find('input').val();
                if (val == '') {
                    return;
                }
                for (var i = 0; i < $('.tab-pane').length; i++) {
                    var html = $('.tab-pane').eq(i).find('.get-html').html();
                    $('.tab-pane').eq(i).find('.task-wrap').append(html);
                }
                parent.parent().find('.task-wrap .content-item').last().find('input').val(val);
            })
        })
    </script>
@endsection()
