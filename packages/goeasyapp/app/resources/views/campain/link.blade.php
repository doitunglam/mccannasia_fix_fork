@extends('core::layout.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{$title}} : {{__transItem($item->name)}}</h4>
            </div>
        </div>
    </div>
    <form action="{{ route('shortlink.store', $item->id) }}" method="POST" class="form-submit" enctype="multipart/form-data">
        @csrf
        @if(isset($use_))
            <input type="hidden" name="use_" value="{{$use_}}"/>
        @endif
        <div class="card">
            <div class="card-body">
                <h5>{{__trans($language, 'All.create_link_product', 'Create link product')}}</h5>

                <h6 style="margin-top: 20px;">{{__trans($language, 'All.link_original', 'Đường dẫn')}}</h6>
                <input class="form-control" name="original_link" id="original-link" type="search" readonly="" value="{{$link}}">
                <button class="mt-3 btn btn-primary waves-effect waves-light">{{__trans($language, 'All.create_link_product', 'Tạo')}}</button>
                <table class="mt-3 w-100 table table-hover">
                    <tr>
                        <th>#</th>
                        <th>{{__trans($language, 'All.link', 'Đường dẫn')}}</th>
                        <th>{{__trans($language, 'All.short_link', 'Đường dẫn rút gọn')}}</th>
                        <th>{{__trans($language, 'All.original_link', 'Đường dẫn nguyên bản')}}</th>
                    </tr>
                    @foreach($listLink as $index => $item)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$item->link}}</td>
                            <td>{{$item->short_link}}</td>
                            <td>{{$item->link_original}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
</div>
@endsection()
