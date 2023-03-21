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



    <form action="{{ route($route, $item->id) }}" method="POST" class="form-submit" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach(__language() as $index=>$ln)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link{{($index == 0) ? ' active': ''}}" data-bs-toggle="tab" href="#{{$ln->code}}" role="tab" aria-selected="true">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">{{$ln->name}}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <div class="tab-content p-3 text-muted">
                    @foreach(__language() as $index=>$ln)

                    <div class="tab-pane{{($index == 0) ? ' active show': ''}}" id="{{$ln->code}}" role="tabpanel">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-9">
                                    <x-component::form.text name="name[{{$ln->code}}]" default="Name" value="{{isset(json($item->name)[$ln->code]) ? json($item->name)[$ln->code] : $item->name}}" id="name" key="all.name" placeholder="All.enter_name" defaultplaceholder="Nhập tên"/>
                                    <x-component::input.ckeditor name="description[{{$ln->code}}]" default="Description" value="{{isset(json($item->name)[$ln->code]) ? json($item->description)[$ln->code] : $item->description}}" id="description" key="All.description" placeholder="All.enter_description" defaultplaceholder="Nhập mô tả"/>
                                    <x-component::form.text name="short_content[{{$ln->code}}]" default="Short Content" value="{{isset(json($item->name)[$ln->code]) ? json($item->short_content)[$ln->code] : $item->short_content}}" id="short_content" key="all.short_content" placeholder="All.enter_short_content" defaultplaceholder="Nhập nội dung"/>

                                    @if($index == 0)
                                        <x-component::form.date name="date_public" default="Date Public" value="{{$item->date_public}}" id="date_public" key="All.date_public" placeholder="All.enter_date" defaultplaceholder="Nhập ngày"/>
                                        <x-component::form.text name="link_" default="Link" value="{{$item->link_}}" id="link_" key="all.link" placeholder="All.link" defaultplaceholder="Nhập đường dẫn"/>
                                    @endif
                                    <div>
                                        <x-component::form.text name="mission_id" default="Id Nhiệm vụ" value="{{$item->mission_id}}" id="mission_id" key="all.mission_id" placeholder="All.mission_id" defaultplaceholder="Nhập ID nhiệm vụ"/>
                                        <div class="get-html" style="display: none">
                                            <div class="row content-item" style="margin-top: 10px; ">
                                                <div class="col-9">
                                                    <input type="text" class="form-control content-task" name="task[{{$ln->code}}][]" value=""/>
                                                </div>
                                            </div>
                                        </div>
                                        <span data-language="{{$ln->code}}" class="add_task badge rounded-pill badge-soft-primary" style="cursor: pointer">{{__trans($language, 'All.add_task', 'Thêm nhiệm vụ')}}</span>
                                        </div>
                                        @if ($index == 0)
                                            <x-component::form.number messages="" name="date_end"
                                                default="Số ngày làm nhiệm vụ" value="{{$item->date_end}}" id="date_end"
                                                key="all.date_end" placeholder="all.date_end"
                                                defaultplaceholder="Nhập số ngày" />
                                        @endif
                                        <div class="task-wrap">
                                           <?php
                                                $tasks = json($item->list_task);

                                           ?>
                                           @if(isset($tasks[$ln->code]))
                                            @foreach($tasks[$ln->code] as $task)
                                            @if($task)
                                            <div class="row content-item" style="margin-top: 10px; ">
                                                <div class="col-9">
                                                    <input type="text" class="form-control content-task" name="task[{{$ln->code}}][]" value="{{$task}}"/>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                            @endif
                                        </div>
                                </div>
                                <div class="col-3">
                                    <x-component::input.ckfinder name="image[{{$ln->code}}]" value="{{isset(json($item->image)[$ln->code]) ? json($item->image)[$ln->code] : $item->image}}" key="all.image" default="Image" id="ckfinder_{{$ln->code}}"/>
                                    @if($index == 0)
                                        <x-component::form.text name="price" default="Price" value="{{$item->price}}" id="price" key="All.price" placeholder="All.enter_date" defaultplaceholder="Nhập giá"/>
                                        <div class="form-group mb-3">
                                            <label for="category">Category</label>
                                            <select name="category" id="category" class="select2 form-control">
                                                <option value="">Select</option>
                                                @foreach($categories as $key => $val)
                                                    <option value="{{ $key }}" @if($key == $item->category) selected @endif>{{ $val }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="mission">Mission</label>
                                            <select name="mission_id" id="mission" class="select2 form-control">
                                                <option value="">Select</option>
                                                @foreach($missions as $key => $val)
                                                    <option value="{{ $key }}" @if($key == $item->mission_id) selected @endif>{{ $val }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="d-flex align-items-center">
                                                <input type="checkbox" name="is_hot" value="1" class="me-2" @if($item->is_hot == 1) checked @endif>
                                                <span>Is Hot</span>
                                            </label>
                                        </div>
                                        <div class="form-group mb-">
                                            <label class="d-flex align-items-center">
                                                <input type="checkbox" name="is_beginner" value="1" class="me-2" @if($item->is_beginner == 1) checked @endif>
                                                <span>For Beginner</span>
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="d-flex flex-wrap gap-2">
                            <x-component::form.submit default="Lưu"  key="all.save"/>
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
$(document).ready(function(){
$(document).ready(function(){
    $('.add_task').click(function(){
        var parent = $(this).parent();
        var val = parent.find('input').val();
        if(val == '')return;
        for(var i = 0; i < $('.tab-pane').length; i++){
            var html = $('.tab-pane').eq(i).find('.get-html').html();
            $('.tab-pane').eq(i).find('.task-wrap').append(html);
        }
        parent.parent().find('.task-wrap .content-item').last().find('input').val(val);
    })

})
})
</script>
@endsection()
