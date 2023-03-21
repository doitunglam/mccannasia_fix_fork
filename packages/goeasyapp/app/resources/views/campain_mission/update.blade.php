
@extends('core::layout.admin')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Campain Mission</h4>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Update
            </div>
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="">Tên nhiệm vụ</label>
                                <input type="text" name="name" class="form-control" value="{{ $item->name }}">
                            </div>
                            <div class="form-group mb-3">
                                <x-component::input.ckeditor name="content" default="Nội dung" value="{{ $item->content }}" id="content" key="content" placeholder="content" defaultplaceholder="Enter your content"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="">Phí ràng buộc hợp đồng</label>
                                <input type="number" name="binding_fee" class="form-control" value="{{ $item->binding_fee }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Lợi nhuận hàng ngày(VNĐ)</label>
                                <input type="number" name="daily_profit" class="form-control" value="{{ $item->daily_profit }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Thời hạn hợp đồng(Ngày)</label>
                                <input type="number" name="contract_term" class="form-control" value="{{ $item->contract_term }}">
                            </div>
                        </div>
                    </div>
                    <div class="py-3">
                        <button class="btn btn-primary">Lưu</button>
                    </div>
                </form>
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

					$(".shadow-sm").addClass('d-none');
					$(".flex-1").addClass('mb-3');
				});
            </script>
    @stack('c-script')
@endsection()
