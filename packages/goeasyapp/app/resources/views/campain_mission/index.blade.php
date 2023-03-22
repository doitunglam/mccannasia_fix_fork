@extends('core::layout.admin')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Nhiệm vụ chiến dịch</h4>
                </div>
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
                                    <th>#</th>
                                    <th>Tên nhiệm vụ</th>
                                    <th>Phí ràng buộc hợp đồng</th>
                                    <th>Lợi nhuận hàng ngày(VNĐ)</th>
                                    <th>Thời hạn hợp đồng(Ngày)</th>
                                    <th>Nhiệm Vụ</th>
                                    <th colspan="2">{{__trans($language, 'All.edit', 'Chỉnh sửa')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $key => $item)
                                    <tr data-id="1" style="cursor: pointer;">
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->binding_fee }}</td>
                                        <td>{{ $item->daily_profit }}</td>
                                        <td>{{ $item->contract_term }}</td>
                                        <td style="max-width: 500px; white-space: inherit;">{!! $item->content !!}</td>
                                        <td style="width: 30px">
                                            <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('campain.mission.getUpdate', $item->id) }}" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                        <td style="width: 30px">
                                            <form action="{{ route('campain.mission.delete', $item->id) }}" method="get">
                                                {{ csrf_field() }}
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm btn-delete" type="button"><i class="fa fa-trash"></i></button>
                                            </form>

                                        </td>
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
        @endsection()
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

					$(".flex-1").addClass('mb-3');
				});
            </script>
    @stack('c-script')
@endsection()
