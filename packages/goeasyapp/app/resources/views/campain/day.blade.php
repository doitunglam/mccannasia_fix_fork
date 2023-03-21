<?php

use App\Models\Banner;
use App\Models\CampainItem;

$bannes = Banner::where('is_popup', FALSE)->where('status', 1)->get();
$popups = \App\Models\Banner::where('is_popup', TRUE)->where('status', 1)->get();
?>@extends('core::layout.admin')
@section('content')
    <div class="container-fluid">
        @if(session()->has('login-current') && !empty($popups))
        <button type="button" class="d-none" id="popup-banner-btn" data-bs-toggle="modal" data-bs-target="#popup-modal">
            Launch demo modal
        </button>
        <div class="modal" tabindex="-1" id="popup-modal">
            <div class="modal-dialog">
                <div class="modal-content rounded-0 ">
                    <div class="modal-body position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 p-4" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div>
                            <div id="popup-carousel-slide" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    @foreach($popups as $key => $popup)
                                    <button type="button" data-bs-target="#popup-carousel-slide" data-bs-slide-to="{{ $key }}"  @if($key == 0)  class="active" aria-current="true" @endif></button>
                                    @endforeach
                                </div>
                                <div class="carousel-inner">
                                    @foreach($popups as $key => $popup)
                                        <div class="carousel-item @if($key == 0) active @endif" data-bs-touch="true" data-bs-interval="3000">
                                            <img src="{{asset($popup->image)}}" class="d-block w-100 h-100" alt="{{asset($popup->image)}}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{$title}}</h4>
                </div>
                <div class="cat-slider border-bottom" style="margin-top: -28px;">
                    @foreach($bannes as $b)
                        <div class="cat-item px-1 py-3">
                            <a class="bg-white rounded d-block p-2 text-center shadow" href="{{$b->link_}}">
                                <img style="width: 100%" src="{{asset($b->image)}}" class="img-fluid mb-2">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>


        <div class="card search_page">
            <div class="card-body">
                <form method="GET">
                    <div class="d-flex flex-wrap gap-2">
                        <div class="col-sm-2">
                            <x-component::form.text name="s_name" default="Tên" value="{{request()->s_name}}" id="name" key="all.name" placeholder="all.enter_name" defaultplaceholder="Nhập tên bạn"/>
                        </div>
                        <button type="submit" class="btn btn-danger waves-effect waves-light add-new" style="height: 36px;margin-top: 26px;">Tìm kiếm</button>
                    </div>
                </form>
            </div>

        </div>

        <div class="row">

            @foreach($items as $item)
                <div class="col-md-6 col-xl-2">
                    <div class="card rounded-3 position-relative card-hover campaign-item">
                        <div class="wrap-image p-2">
                            <div class="wrap-button">
                                <a href="{{route('campain.register', $item->id)}}" class="btn waves-effect waves-light btn-register">{{__trans($language, 'All.register', 'Đăng ký')}}</a>
                            </div>
                            <img class="card-img-top img-fluid h-100 img-campaign" src="{!! env('APP_URL').__transItem($item->image) !!}" onerror="this.src='{{asset('upload/no-image.png')}}'" alt="add alternative text here">
                        </div>
                        <div class="card-body p-2">
								<?php

								$count = count(CampainItem::where('cid', $item->id)->get());
								?>
                            <h5 class="card-title campaign-name text-truncate" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __transItem($item->name) }}">{{ __transItem($item->name) }}</h5>
                            <hr>
                            <p class="card-text text-short-description mb-2 text-truncate">{{__trans($language, 'All.registration_fee', 'Phí đăng ký')}}: {{currency_format($item->registration_fee, 'đ')}}</p>
                            <p class="card-text text-short-description mb-2 text-truncate">{{__trans($language, 'All.subscriber_number', 'Số người đăng ký')}}: {{$count}}</p>
                            <p class="card-text text-short-description mb-2 text-truncate">{{__trans($language, 'All.daily_profit', 'Lợi nhuận hàng ngày')}}: {{currency_format($item->daily_profit)}}</p>
                            <?php
                            $date_to_end = '';
                            if( $item->date_public != null) {
                                $date_public = DateTime::createFromFormat('d/m/Y', $item->date_public);
                                $date_public->add(new DateInterval('P' . $item->date_end . 'D'));
                                $date_to_end = $date_public->format('d/m/Y');
                            }
                            ?>
                            <p class="card-text text-short-description mb-2 text-truncate">{{__trans($language, 'All.date_end', 'Ngày kết thúc')}}: {{$date_to_end}}</p>

                            {{--                            <a href="{{route('campain.register', $item->id)}}" class="btn btn-primary waves-effect waves-light">{{__trans($language, 'All.register', 'Register')}}</a>--}}
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

                </div>
            @endforeach
        </div>
    </div>
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mt-5" role="alert" style="margin-left: 13px;margin-right: 13px;">
            <i class="mdi mdi-check-all me-2"></i>
            {!! session()->get('success') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endsection()
@section('script')
    @stack('c-script')
    <script>
		$(document).ready(function () {

			$('.cat-slider').not('.slick-slider').slick({
				centerMode: true,
				slidesToShow: 1,
				arrows: false,
				responsive: [{
					breakpoint: 768,
					settings: {
						arrows: false,
						centerMode: true,
						slidesToShow: 1
					}
				},
					{
						breakpoint: 480,
						settings: {
							arrows: false,
							centerMode: true,
							slidesToShow: 1
						}
					}
				]
			});
            @if(session()->has('login-current') && !empty($popup))

            $('.popup-banner-slick').slick({
	            arrows: false,
	            dots: true
            });
			$("#popup-banner-btn")[0].click();
            @php(session()->remove('login-current'))
            @endif
		});
    </script>
@endsection()
