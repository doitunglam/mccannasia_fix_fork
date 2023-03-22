<?php

use App\Models\Category;
use Illuminate\Support\Str;

$cas = json_decode(file_get_contents(public_path() . '/campain_category.json') ?? '[]', 1);
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-component::app.header />

<body class="">

    <body data-sidebar="dark">
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <div class="navbar-brand-box" style="background: #fff !important;">
                            <x-component::app.navbar />
                        </div>

                        <span
                            class="btn custom-height btn-sm d-flex flex-column justify-content-center px-3 font-size-14 header-item dnm-cs waves-effect"
                            id="">
                            <a class="d-flex" style="color: #fff;" href="{{ route('home') }}"><i
                                    class='bx bx-notification'></i>
                                <span class="d-none d-sm-block">{!! __trans($language, 'All.statistical', 'Thống kê') !!}</span></a>
                        </span>
                        <span
                            class="btn custom-height btn-sm d-flex flex-column justify-content-center px-3 font-size-14 header-item dnm-cs waves-effect"
                            id="">
                            <a class="d-flex" style="color: #fff;" href="{{ route('campain.day') }}"><i
                                    class='bx bx-notification'></i>
                                <span class="d-none d-sm-block">{!! __trans($language, 'All.campain_day', 'Chiến dịch ngày') !!}</span></a>
                        </span>
                        <span
                            class="btn btn-sm custom-height d-flex flex-column justify-content-center px-3 font-size-14 header-item dnm-cs waves-effect"
                            id="">
                            <a class="d-flex" style="color: #fff;" href="{{ route('campain.my') }}"><i
                                    class='bx bxs-customize'></i>
                                <span class="d-none d-sm-block">{!! __trans($language, 'All.campain_my', 'Chiến dịch của tôi') !!}</span></a>
                        </span>
                        <span
                            class="btn d-none custom-height d-flex flex-column justify-content-center btn-sm px-3 font-size-14 header-item dnm-cs waves-effect"
                            id="">
                            <a class="d-flex" style="color: #fff;" href="{{ route('campain.payment') }}"><i
                                    class='bx bxs-customize'></i>
                                <span class="d-none d-sm-block">{!! __trans($language, 'All.payment', 'Thanh toán') !!}</span></a>
                        </span>
                    </div>
                    <div class="d-flex align-items-center">
                        @if (Auth::user()->type == 'agency')
                            <nav class="navbar navbar-expand-lg">
                                <div class="container-fluid">
                                    <ul class="navbar-nav d-flex flex-row">
                                        <li class="nav-item">
                                            <div class="dropdown">
                                                <a class="me-3 d-flex dropdown-toggle hidden-arrow position-relative"
                                                    href="javascript:" id="bell-notification" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    @php($amount = currency_format(Auth::user()->amount ?? 0))
                                                    <i class="fa fa-credit-card text-white fs-5 me-2"></i>
                                                    <span
                                                        class="text-white border-bottom d-none d-sm-block">{{ $amount }}</span>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-start"
                                                    aria-labelledby="bell-notification-list">
                                                    <li>
                                                        <a href="{{ route('payment.listRecharge') }}"
                                                            class="dropdown-item"
                                                            key="t-default">{!! __trans($language, 'All.list_recharge', 'Nạp tiền') !!}</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('payment.listWithdraw') }}"
                                                            class="dropdown-item"
                                                            key="t-default">{!! __trans($language, 'All.list_withdraw', 'Rút tiền') !!}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        @endif
                        <div class="d-inline-block">
                            <a class="position-relative" href="javascript:" data-bs-toggle="modal"
                                data-bs-target="#contact-form">
                                <i class="fas fa-envelope fs-5 text-white"></i>
                                <span class="badge rounded-pill badge-notification bg-danger position-absolute"
                                    style="right: -10px; top: -5px;">!</span>
                            </a>
                        </div>
                        <nav class="navbar navbar-expand-lg px-2">
                            <div class="container-fluid">
                                <ul class="navbar-nav d-flex flex-row me-1">
                                    <li class="nav-item me-3 me-lg-0">
                                        <div class="dropdown">
                                            <a class="me-3 dropdown-toggle hidden-arrow position-relative"
                                                href="javascript:" id="bell-notification" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-bell text-white fs-5"></i>
                                                <span
                                                    class="badge rounded-pill badge-notification bg-danger position-absolute"
                                                    style="left: 10px; top: -5px;">+99</span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" style="right: -74px !important;"
                                                aria-labelledby="bell-notification-list">
                                                <li>
                                                    <a class="dropdown-item" href="#">Some news</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">Another news</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </nav>

                        @if (Auth::user()->type != 'agency')
                            <nav class="navbar navbar-expand-lg">
                                <ul class="navbar-nav d-flex flex-row">
                                    <li class="nav-item">
                                        <div class="dropdown">
                                            <?php
                                            $lang = session('locale') ? session('locale') : 'vi';
                                            $lang = strtoupper($lang);
                                            ?>
                                            <a class="me-3 dropdown-toggle hidden-arrow position-relative"
                                                href="javascript:" id="bell-notification" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="text-white">{{ $lang }}</span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-start"
                                                aria-labelledby="bell-notification-list">
                                                <li>
                                                    <a href="{{ route('admin.locale.cn') }}"
                                                        class="dropdown-item">Cn</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.locale.en') }}"
                                                        class="dropdown-item">En</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.locale.vi') }}"
                                                        class="dropdown-item">Vi</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </nav>
                            <nav class="navbar navbar-expand-lg">
                                <div class="container-fluid">
                                    <a class="position-relative" href="{{route('user.update', Auth::user()->id)}}" id="setting"
                                        role="button">
                                        <i class="fas fa-cog text-white fs-5"></i>
                                    </a>
                                </div>
                            </nav>
                        @endif
                        <div class="dropdown d-inline-block">
                            <x-component::app.dropdown />
                        </div>
                    </div>
                </div>
            </header>
            <div class="vertical-menu">
                <div data-simplebar class="h-100">
                    <div id="sidebar-menu">
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="off-menu" style="height: 0px;">
                                <a href="#" class="waves-effect">

                                </a>
                            </li>
                            @if (Auth::user()->type != 'agency')
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="bx bxs-bank"></i>
                                        <span key="t-dashboards">{!! __trans($language, 'All.bank', 'Bank') !!}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('config.list') }}"
                                                key="t-default">{!! __trans($language, 'All.list', 'Danh sách') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('config.create') }}"
                                                key="t-default">{!! __trans($language, 'All.add_new', 'Thêm mới') !!}</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fa fa-language"></i>
                                        <span key="t-dashboards">{!! __trans($language, 'All.language', 'Ngôn ngữ') !!}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('language.list') }}"
                                                key="t-default">{!! __trans($language, 'All.list', 'Danh sách') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('language.create') }}"
                                                key="t-default">{!! __trans($language, 'All.add_new', 'Thêm mới') !!}</a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fa fa-image"></i>
                                        <span key="t-dashboards">{!! __trans($language, 'All.banner', 'Ảnh') !!}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('banner.create') }}"
                                                key="t-default">{!! __trans($language, 'All.add_new', 'Thêm mới') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('banner.list') }}"
                                                key="t-default">{!! __trans($language, 'All.banner.list', 'Danh sách ảnh') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('banner.popup.list') }}"
                                                key="t-default">{!! __trans($language, 'All.popup.list', 'Danh sách popup') !!}</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fa fa-list"></i>
                                        <span key="t-dashboards">{!! __trans($language, 'All.category_new', 'Phân loại mới') !!}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('category-new.list') }}"
                                                key="t-default">{!! __trans($language, 'All.list', 'Danh sách') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('category-new.create') }}"
                                                key="t-default">{!! __trans($language, 'All.add_new', 'Thêm mới') !!}</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fa fa-blog"></i>
                                        <span key="t-dashboards">{!! __trans($language, 'All.blog', 'Bài viết') !!}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('blog.list') }}"
                                                key="t-default">{!! __trans($language, 'All.list', 'Danh sách') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('blog.create') }}"
                                                key="t-default">{!! __trans($language, 'All.add_new', 'Thêm mới') !!}</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fa fa-industry"></i>
                                        <span key="t-dashboards">{!! __trans($language, 'All.campain', 'Chiến dịch') !!}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('campain.list') }}"
                                                key="t-default">{!! __trans($language, 'All.list', 'Danh sách') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('campain.create') }}"
                                                key="t-default">{!! __trans($language, 'All.add_new', 'Thêm mới') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('campain.resuft.list') }}"
                                                key="t-default">{!! __trans($language, 'All.resuft', 'Kết quả') !!}</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:" class="waves-effect">
                                        <i class="fa fa-exclamation"></i>
                                        <span key="t-dashboards">{!! __trans('$language', 'All.campain_mission', 'Nhiệm vụ chiến dịch') !!}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('campain.mission.list') }}"
                                                key="t-default">{!! __trans($language, 'All.list', 'Danh sách') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('campain.mission.getCreate') }}"
                                                key="t-default">{!! __trans($language, 'All.add_new', 'Thêm mới') !!}</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fa fa-people-arrows"></i>
                                        <span key="t-dashboards">{!! __trans($language, 'All.agency', 'Đại lý') !!}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('user') }}"
                                                key="t-default">{!! __trans($language, 'All.list', 'Danh sách') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.create') }}"
                                                key="t-default">{!! __trans($language, 'All.add_new', 'Thêm mới') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.view_change_all_amount') }}"
                                                key="t-default">{!! __trans($language, 'All.change_amount', 'Đổi số dư') !!}</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fa fa-user"></i>
                                        <span key="t-dashboards">{!! __trans($language, 'All.resuft_management', 'Quản lý Kết quả') !!}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('resuft.management') }}"
                                                key="t-default">{!! __trans($language, 'All.list', 'Danh sách') !!}</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:" class="waves-effect">
                                        <i class="fa fa-credit-card"></i>
                                        <span key="t-dashboards">{!! __trans($language, 'All.payment', 'Thanh toán') !!}</span>
                                    </a>

                                    <ul class="sub-menu  @if (Request::route()->getName() == 'payment.list' ||
                                            Request::route()->getName() == 'payment.listAdminRecharge' ||
                                            Request::route()->getName() == 'payment.listAdminWithdraw') mm-show @endif">
                                        <li>
                                            <a href="{{ route('payment.listAdminRecharge') }}"
                                                key="t-default">{!! __trans($language, 'All.list_admin_recharge', 'Danh sách nạp tiền') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('payment.listAdminWithdraw') }}"
                                                key="t-default">{!! __trans($language, 'All.list_admin_withdraw', 'Danh sách rút tiền') !!}</a>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="menu-title" key="t-menu">Menus</li>
                                <li>
                                    <a href="{{ route('campain.hot') }}" class="waves-effect">
                                        <i class="fa fa-fire"></i>
                                        <span key="t-dashboards">{!! __trans($language, 'All.campain_hot', 'Campain Hot') !!}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('campain.my') }}" class="waves-effect">
                                        <i class="fa fa-industry"></i>
                                        <span key="t-dashboards">{!! __trans($language, 'All.campain_use', 'Campain Using') !!}</span>
                                    </a>

                                </li>
                                <li class="menu-title" key="t-menu">Category</li>
                                @foreach ($cas as $id => $name)
                                    <li>
                                        <a href="{{ route('campain.category', $id) }}" class="waves-effect">
                                            @php($ca_name_slug = Str::slug($name))
                                            @if ($ca_name_slug == Str::slug('Mobile app'))
                                                <i class="fa fa-mobile"></i>
                                            @elseif($ca_name_slug == Str::slug('Dịch vụ tài chính'))
                                                <i class="fa fa-coins"></i>
                                            @elseif($ca_name_slug === Str::slug('Giáo dục'))
                                                <i class="fa fa-user-graduate"></i>
                                            @elseif($ca_name_slug === Str::slug('Tiktok'))
                                                <img class="me-2"
                                                    src="data:image/png;base64,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"
                                                    width="20" alt="">
                                            @elseif($ca_name_slug === Str::slug('Shopee'))
                                                <img src="https://static-00.iconduck.com/assets.00/brand-shopee-icon-462x512-ylgpbjo5.png"
                                                    alt="" class="me-2" width="20">
                                            @elseif($ca_name_slug === Str::slug('Dịch vụ trực tuyến'))
                                                <i class="fa fa-signal"></i>
                                            @elseif($ca_name_slug === Str::slug('Du lịch giải trí'))
                                                <i class="fa fa-plane"></i>
                                            @elseif($ca_name_slug === Str::slug('Làm đẹp'))
                                                <i class="fa fa-heart"></i>
                                            @endif
                                            <span key="t-dashboards">{{ $name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                                <li class="d-none">
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fa fa-credit-card"></i>
                                        <span key="t-dashboards">{!! __trans($language, 'All.payment', 'Thanh toán') !!}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('payment.listRecharge') }}"
                                                key="t-default">{!! __trans($language, 'All.list_recharge', 'Danh sách nạp tiền') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('payment.listWithdraw') }}"
                                                key="t-default">{!! __trans($language, 'All.list_withdraw', 'Danh sách rút tiền') !!}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="page-content">
                    <x-component::form.error />
                    @yield('content')
                </div>
            </div>
            @yield('modal')
        </div>

        <div class="modal fade" id="contact-form" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="#">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="contact-form">Liên hệ với chúng tôi</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="#">Tên</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="#">Email</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="#">Nôi dung</label>
                                <textarea class="form-control" rows="9"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Gửi</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <x-component::app.footer />
    </body>

</html>
