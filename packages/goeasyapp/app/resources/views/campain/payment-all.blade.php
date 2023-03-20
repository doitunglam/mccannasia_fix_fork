
@extends('core::layout.admin')
@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{$title}}</h4>
            </div>
        </div>
    </div>
    <iframe src="" style="width: 0 !important; height: 0 !important; height" title="W3Schools Free Online Web Tutorials" class="dowload-file"></iframe>
    <div class="card search_page">
        <div class="card-body">
            <form method="GET" action=""  enctype="multipart/form-data" style="position: relative;z-index: 1;">
                @csrf
            <div class="d-flex flex-wrap gap-2">
                <div class="col-sm-2">
                    <div class="mb-3">
                        <label for="name" class="form-label">{{__trans($language, 'All.name', 'Tên')}}</label>
                        <input type="text" class="form-control s_name" id="name" placeholder="" name="s_name" value="{{request()->s_name}}">
                    </div>
                </div>
                <button type="submit" class="btn btn-danger waves-effect waves-light" style="height: 36px;margin-top: 26px;" onclick="return confirm('{{ __trans($language, 'All.confirm_payment_recharge', 'Bạn chắc chắn thực hiện điều này?')}}')">{{__trans($language, 'All.search', 'Tìm kiếm')}}</button>

            </div>
            </form>
            <div class="d-flex flex-wrap gap-2" style="margin-top: -77px;">
                <div class="col-sm-2"></div>
                <div class="col-sm-2"> <button type="button" class="btn btn-primary waves-effect waves-light get-download" style="height: 36px;margin-top: 23px;margin-left: 79px;position: relative;z-index: 10;" onclick="return confirm('{{ __trans($language, 'All.confirm_payment_recharge', 'Bạn chắc chắn thực hiện điều này?')}}')">{{__trans($language, 'All.export', 'Xuất')}}</button></div>
            </div>
            <a class="btn btn-success waves-effect waves-light mt-3" href="{{route('payment.acceptAll',$type)}}" onclick="return confirm('{{ __trans($language, 'All.confirm_payment_recharge', 'Bạn chắc chắn thực hiện điều này?')}}')">{{__trans($language, 'All.accept', 'Chấp nhận tất cả yêu cầu')}}</a>
        </div>

    </div>

    <div class="card">
        <div class="card-body">
            <div class="col-12">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-editable table-nowrap align-middle table-edits">
                            <thead>
                                <tr style="cursor: pointer;">
                                    @foreach($td as $i)
                                    <th>{{ $i['title'] }}</th>
                                    @endforeach
                                    <th>{{__trans($language, 'All.id_user', 'ID người dùng')}}</th>
                                    <th>{{__trans($language, 'All.type', 'Loại')}}</th>
                                    <th>{{__trans($language, 'All.status', 'Trạng thái')}}</th>
                                    <th>{{__trans($language, 'All.created_at', 'Thời gian tạo')}}</th>
                                    <th>{{__trans($language, 'All.review_date', 'Thời gian xem xét')}}</th>
                                    <th>{{__trans($language, 'All.edit', 'Thao tác')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr data-id="1" style="cursor: pointer;">
                                    @foreach($td as $i)
                                    <?php
                                        $key = $i['value'];
                                        $value = $item->$key;
                                        if ($key === 'amount') {
                                            $value = currency_format($value);
                                        }
                                    ?>
                                    @if(isset($i['type']) && $i['type'] == 'image')
                                        <td style=""><img style="height: 150px; width: auto" src="{!! env('APP_URL').__transItem($item->$key) !!}"/></td>
                                    @else
                                        <td style="">{{ __transItem($value) }}</td>
                                    @endif
                                    @endforeach
                                    <td style="">{{ $item->user }}</td>
                                    @if($item->type == '')
									<td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-success">{{__trans($language, 'All.withdraw_money', 'Rút tiền')}}</span></td>
									@else
                                    <td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-danger">{{__trans($language, 'All.recharge', 'Nạp tiền')}}</span></td>
                                    @endif

                                    @if($item->status == 1)
									<td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-success">{{__trans($language, 'All.appect', 'Chấp nhận')}}</span></td>
									@elseif($item->status == 2)
									<td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-danger">{{__trans($language, 'All.not_appect', 'Từ chối')}}</span></td>
									@else
                                    <td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-primary">{{__trans($language, 'All.waiting', 'Đang chờ')}}</span></td>
                                    @endif
                                    <td style="">{{ $item->created_at }}</td>
                                    <td style="">{{ $item->updated_at }}</td>

                                    <form action="{{ route($route, $item->id) }}" method="POST" class="form-submit{{$item->id}}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="status" class="check-status{{$item->id}}"/>
                                        <td style="">
                                            @if($item->status == null)
                                            <div class="d-flex flex-wrap gap-2">
                                                <button class="btn btn-primary waves-effect waves-light appect{{$item->id}}" type="button" onclick="return confirm('{{ __trans($language, 'All.confirm_payment_recharge', 'Bạn chắc chắn thực hiện điều này?')}}')">{{ __trans($language, 'all.appect', 'Chấp nhận') }}</button>
                                                <button class="btn btn-danger waves-effect waves-light not_appect{{$item->id}}" type="button" onclick="return confirm('{{ __trans($language, 'All.confirm_payment_recharge', 'Bạn chắc chắn thực hiện điều này?')}}')">{{ __trans($language, 'all.not_appect', 'Từ chối') }}</button>
                                            </div>
                                            @endif
    {{--                                        <a class="btn btn-outline-secondary btn-sm edit" href="{{ route($route, $item->id)}}" title="Edit">--}}
    {{--                                            <i class="fas fa-pencil-alt"></i>--}}
    {{--                                        </a>--}}
                                        </td>
                                    </form>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$items->links()}}
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection()
@section('script')
<script>
$('.get-download').click(function(){
    var url = "{{route('campain.download',['s_name' => request()->s_name])}}";
    $('.dowload-file').attr('src', url);
})
</script>
@stack('c-script')
<script>
    $(document).ready(function(){
        @foreach($items as $item)
            $('.appect{{$item->id}}').click(function(){
                $('.check-status{{$item->id}}').val(1);
                $('.form-submit{{$item->id}}').submit();
            })
            $('.not_appect{{$item->id}}').click(function(){
                $('.check-status{{$item->id}}').val(2);
                $('.form-submit{{$item->id}}').submit();
            })
        @endforeach

        $(".shadow-sm").addClass('d-none');
        $(".flex-1").addClass('mb-3');
    })
</script>
@endsection()
