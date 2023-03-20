@php use App\Models\CampainItem; @endphp@extends('core::layout.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{$title}}</h4>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($items as $item)
                <div class="col-md-6 col-xl-2">
                    <div class="card rounded-3 position-relative card-hover campaign-item">
                        <div class="wrap-image p-2">
                            <img class="card-img-top img-fluid h-100 img-campaign" src="{!! env('APP_URL').__transItem($item->image) !!}" onerror="this.src='{{asset('upload/no-image.png')}}'" alt="add alternative text here">
                        </div>
                        <div class="card-body p-2">
								<?php
								$count = count(CampainItem::where('cid', $item->id)->get());
								?>
                            <h5 class="card-title campaign-name text-truncate" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __transItem($item->name) }}">{{ __transItem($item->name) }}</h5>
                            <hr>
                            <div class="short-content">
                                {{ __transItem($item->short_content) }}
                            </div>
                            <br>
                            <a href="{{route('campain.resuft', $item->id)}}" class="btn btn-primary waves-effect waves-light">{{__trans($language, 'All.resuft', 'Resuft')}}</a>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6 col-xl-2">
                    <div class="card rounded-3 position-relative card-hover campaign-item">
                        <div class="wrap-image p-2">
                            <img class="card-img-top img-fluid h-100 img-campaign" src="{!! env('APP_URL').__transItem($item->image) !!}" onerror="this.src='{{asset('upload/no-image.png')}}'" alt="add alternative text here">
                        </div>
                        <div class="card-body p-2">
						        <?php
						        $count = count(CampainItem::where('cid', $item->id)->get());
						        ?>
                            <h5 class="card-title campaign-name text-truncate" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __transItem($item->name) }}">{{ __transItem($item->name) }}</h5>
                            <hr>
                            <div class="short-content">
                                McCann Asia là một nền tảng trung gian kết nối các
                            </div>
                            <br>
                            <a href="{{route('campain.resuft', $item->id)}}" class="btn btn-primary waves-effect waves-light">{{__trans($language, 'All.resuft', 'Resuft')}}</a>
                        </div>
                        @if($item->is_hot)
                            <span class="position-absolute top-0 translate-middle badge rounded-pill bg-danger me-2 py-2 hot-beginner">
                                Hot
                            </span>
                        @endif
                        @if($item->is_beginner)
                            <span class="position-absolute top-0 translate-middle badge rounded-pill bg-success me-2 py-2 hot-beginner {{$item->is_hot ? 'is-beginner' : ''}}">
                                Beginner
                            </span>
                        @endif
                    </div>
                </div> --}}
            @endforeach
        </div>
    </div>
@endsection()
@section('script')
    @stack('c-script')
    <script>

    </script>
@endsection()
