@extends('core::layout.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ $title }} : {{ __transItem($item->name) }}</h4>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5>{{ __trans($language, 'All.description', 'Miêu tả') }}</h5>
                {!! __transItem($item->description) !!}
                <h5 style="margin-top: 20px;">{{ __trans($language, 'All.Reason_for_cancellation', 'Lý do huỷ') }}</h5>
                {!! __transItem($item->reson_cancel) !!}
                <h5 style="margin-top: 20px;">{{ __trans($language, 'All.registration_fee', 'Phí đăng ký') }}</h5>
                <p>
                    {!! __transItem(currency_format($item->registration_fee)) !!}
                </p>
                <h5 style="margin-top: 20px;">{{ __trans($language, 'All.price', 'Lãi') }}</h5>
                <p>
                    {!! __transItem(currency_format($item->price)) !!} / {{ __trans($language, 'All.day', 'Ngày') }}
                </p>
                <h5 style="margin-top: 20px;">{{ __trans($language, 'All.link', 'Đường dẫn') }}</h5>
                <p>
                    {{ route('campain.link', [$item->id, 'campain' => $info->code, 'use_' => $info->url]) }}
                </p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5>{{ __trans($language, 'All.resuft', 'Kết quả') }}</h5>
                @foreach ($resuft as $r)
                    <h6>{{ $r->date }}

                        @if ($r->status == 1)
                            <span
                                class="badge rounded-pill badge-soft-success">{{ __trans($language, 'All.appect', 'Chấp nhận') }}</span>
                        @elseif($r->status == 2)
                            <span
                                class="badge rounded-pill badge-soft-danger">{{ __trans($language, 'All.not_appect', 'Từ chối') }}</span>
                        @else
                            <span
                                class="badge rounded-pill badge-soft-primary">{{ __trans($language, 'All.waiting', 'Đang chờ') }}</span>
                        @endif
                    </h6>
                    <div class="imgArrList d-flex flex-column">
                        <?php
                        $value = $r->resuft;
                        $explain = json_decode($r->resuft_explain);
                        ?>
                        @if ($value)
                            @foreach ($value as $v)
                                @foreach ($v as $v1)
                                <label >{{ __trans($language, 'All.explain', 'Giải trình') }}: </label>
                                {{ $explain[$loop->parent->index] }}
                                    <img id="img_arr_prev"
                                        style="height: 150px !important; width: auto;margin: 20px;margin-left: 20px !important;"
                                        src="{{ $v1 }}" class="mx-auto h-auto w-full object-cover"
                                        alt="">
                                @endforeach
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <form action="{{ route($route, $item->id) }}" method="POST" class="form-submit" enctype="multipart/form-data">
            @csrf
            <?php
            $tasks = json_decode($item->list_task, true);
            ?>
            @foreach ($tasks as $index => $task)
                @if ($task)
                    <?php
                    $value = '';
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ __trans($language, 'All.enter_today_s_results', 'Nhập kết quả hôm nay') }}:
                                {{ date('d-m-Y') }}
                            </h5>
                            {!! __transItem($item->content) !!}
                            <div class="mb-3">
                                <label for="resuft_explain">{{ __trans($language, 'All.explain', 'Giải trình') }}</label>
                                <input id="resuft_explain" name="resuft_explain" type="text" class="form-control mb-2" value="" autocomplete="off">
                                </input>
                            </div>
                            <x-component::input.ckfinder-array id="task_{{ $index }}" key="{{ $index }}"
                                name="resuft[{{ $index + 1 }}][]" :value="$value" />
                        </div>
                    </div>
                @endif
            @endforeach
            <div class="card">
                <div class="card-body">
                    <div class="col-12">
                        <div class="row">
                            <div class="d-flex flex-wrap gap-2">
                                <x-component::form.submit default="Lưu" key="all.register" />
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
        $(document).ready(function() {
            $('.add_task').click(function() {
                var parent = $(this).parent();
                var val = parent.find('input').val();
                if (val == '') return;
                for (var i = 0; i < $('.tab-pane').length; i++) {
                    var html = $('.tab-pane').eq(i).find('.get-html').html();
                    $('.tab-pane').eq(i).find('.task-wrap').append(html);
                }
                parent.parent().find('.task-wrap .content-item').last().find('input').val(val);
            })

        })
    </script>
@endsection()
