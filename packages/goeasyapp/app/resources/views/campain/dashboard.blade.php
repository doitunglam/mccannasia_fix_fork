<?php

use App\Models\Banner;
use App\Models\CampainItem;

$bannes = Banner::where('is_popup', false)
    ->where('status', 1)
    ->get();
$popups = \App\Models\Banner::where('is_popup', true)
    ->where('status', 1)
    ->get();
?>@extends('core::layout.admin')
@section('content')

    <div class="container-fluid">
        @if (session()->has('login-current') && !empty($popups))
            <button type="button" class="d-none" id="popup-banner-btn" data-bs-toggle="modal" data-bs-target="#popup-modal">
                Launch demo modal
            </button>
            <div class="modal" tabindex="-1" id="popup-modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content rounded-0 ">
                        <div class="modal-body position-relative">
                            <button type="button" class="btn-close position-absolute top-0 end-0 p-4"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                            <div>
                                <div id="popup-carousel-slide" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        @foreach ($popups as $key => $popup)
                                            <button type="button" data-bs-target="#popup-carousel-slide"
                                                data-bs-slide-to="{{ $key }}"
                                                @if ($key == 0) class="active" aria-current="true" @endif></button>
                                        @endforeach
                                    </div>
                                    <div class="carousel-inner">
                                        @foreach ($popups as $key => $popup)
                                            <div class="carousel-item @if ($key == 0) active @endif"
                                                data-bs-touch="true" data-bs-interval="3000">
                                                <img src="{{ asset($popup->image) }}" class="d-block w-100 h-100"
                                                    alt="{{ asset($popup->image) }}">
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
                    <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
                </div>
                <div class="cat-slider border-bottom" style="margin-top: -28px;">
                    @foreach ($bannes as $b)
                        <div class="cat-item px-1 py-3">
                            <a class="bg-white rounded d-block p-2 text-center shadow" href="{{ $b->link_ }}">
                                <img style="width: 100%" src="{{ asset($b->image) }}" class="img-fluid mb-2">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        @if ($user->type == 'agency')
            <div style="display: flex; height: fit-content; justify-content: flex-end; padding-right: 26px;">
                <input id="input1" type="text" name="datetimes" />
                <a class="btn btn-info waves-effect waves-light ml-2 d-grid" onclick="handleFilter1()" id="btn-view-0"
                    style="align-items: center; margin-left:10px; background-color:#3B4F66; border-color: #3B4F66">
                    Lọc</a>
            </div>
            <div class="wrapper">
                <div class="container">
                    <div class="myrow">
                        <div class="mycard">
                            <div class="info">
                                <div class="sub">Tổng đại lý</div>
                                <div class="title">{{ $totalAgencyOfCurrentUser }}</div>
                            </div>
                            <i class="fa fa-user-graduate" style="font-size: 30px"></i>
                        </div>
                        <div class="mycard">
                            <div class="info">
                                <div class="sub">Tổng tiền cấp dưới nạp</div>
                                <div class="title">{{ currency_format($totalRecharge) }}</div>
                            </div>
                            <i class="fa fa-coins" style="font-size: 30px"></i>
                        </div>
                        <div class="mycard">
                            <div class="info">
                                <div class="sub">Tổng tiền cấp dưới rút</div>
                                <div class="title">{{ currency_format($totalWithdraw) }}</div>
                            </div>
                            <i class="fa fa-coins" style="font-size: 30px"></i>
                        </div>
                    </div>
                </div>
                @if (!empty($referral_list))
            </div>
            <div class="card-body">
                <?php
                $total_referral_list = 0;
                if (!empty($referral_list)) {
                    $total_referral_list = count($referral_list);
                }
                ?>
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <h4>Danh sách đối tác đã giới thiệu</h4>
                    </div>
                    <div style="display: flex; height: fit-content;">
                        <input id="input2" type="text" name="datetimes" />
                        <a class="btn btn-info waves-effect waves-light ml-2 d-grid" onclick="handleFilter2()"
                            id="btn-view-0"
                            style="align-items: center; margin-left:10px; background-color:#3B4F66; border-color: #3B4F66">
                            Lọc</a>
                    </div>
                </div>
                <div class="contact-container">
                    @foreach ($referral_list as $key => $item)
                        <div class="user-row">
                            <div class="profile-photo">
                                <svg id="Layer_1" enable-background="new 0 0 480.063 480.063" height="66"
                                    viewBox="0 0 480.063 480.063" width="66" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m394.032 424.803v39.26c0 4.42-3.58 8-8 8h-292c-4.42 0-8-3.58-8-8v-39.26c0-41.19 33.39-74.56 74.59-74.57 14.56-.01 27.38-7.5 34.76-18.86 7.414-11.394 6.65-21.302 6.65-29.31l.15-.37c-35.9-14.86-61.15-50.23-61.15-91.5v-3.13c-14.255 0-25-11.265-25-24.54v-41.56c-.32-14.47.34-65.5 37.2-101.03 42.86-41.31 110.78-37.93 159.98-15.83 1.6.72 1.55 3.01-.07 3.68l-12.83 5.28c-1.92.79-1.51 3.62.55 3.84l6.23.67c29.83 3.19 57.54 19.39 74.72 46.35.46.73.33 1.84-.26 2.47-10.6 11.21-16.52 26.09-16.52 41.56v54.57c0 13.55-10.99 24.54-24.54 24.54h-1.46v3.13c0 41.27-25.25 76.64-61.15 91.5l.15.37c0 7.777-.827 17.82 6.65 29.31 7.38 11.36 20.2 18.85 34.76 18.86 41.2.01 74.59 33.38 74.59 74.57z"
                                        fill="#ffdfba" />
                                    <path
                                        d="m394.032 424.803v39.26c0 4.418-3.582 8-8 8h-292c-4.418 0-8-3.582-8-8v-39.26c0-41.19 33.395-74.555 74.585-74.57 14.564-.005 27.387-7.504 34.765-18.86 25.754 22.002 63.531 22.015 89.3 0 7.377 11.356 20.201 18.855 34.765 18.86 41.19.015 74.585 33.38 74.585 74.57z"
                                        fill="#fe4f60" />
                                    <path
                                        d="m381.807 83.928c.464.729.334 1.833-.259 2.461-10.597 11.218-16.517 26.093-16.517 41.564v54.57c0 12.388-9.333 24.54-26 24.54v-61.77c0-26.51-21.49-48-48-48h-102c-26.51 0-48 21.49-48 48v61.77c-14.255 0-25-11.265-25-24.54v-41.56c-.32-14.47.34-65.5 37.2-101.03 42.858-41.311 110.784-37.929 159.977-15.827 1.601.719 1.558 3.01-.065 3.678l-12.831 5.282c-1.918.79-1.514 3.617.548 3.838l6.232.669c29.834 3.187 57.537 19.387 74.715 46.355z"
                                        fill="#42434d" />
                                    <path
                                        d="m339.032 210.193c0 54.696-44.348 99-99 99-51.492 0-99-40.031-99-102.13v-61.77c0-26.51 21.49-48 48-48h102c26.51 0 48 21.49 48 48z"
                                        fill="#ffebd2" />
                                    <path
                                        d="m217.616 274.121c16.277 10.183 3.442 35.156-14.376 28.004-36.634-14.704-62.208-50.404-62.208-91.932v-64.9c0-10.084 3.11-19.442 8.423-27.168 6.514-9.473 21.577-5.288 21.577 7.168v64.9c0 36.51 19.192 66.79 46.584 83.928z"
                                        fill="#fff3e4" />
                                    <path
                                        d="m279.162 318.483c-24.637 10.313-51.712 11.113-78.26 0 1.356-5.626 1.13-9.27 1.13-16.42l.15-.37c24.082 9.996 51.571 10.016 75.7 0l.15.37c0 7.153-.226 10.796 1.13 16.42z"
                                        fill="#ffd6a6" />
                                    <path
                                        d="m200.913 374.39c-3.698 1.163-7.664 1.804-11.916 1.841-41.296.364-74.966 33.017-74.966 74.315v7.517c0 7.732-6.268 14-14 14h-6c-4.418 0-8-3.582-8-8v-39.26c0-41.191 33.395-74.555 74.585-74.57 14.564-.005 27.387-7.504 34.765-18.86 2.974 2.54 6.158 4.823 9.66 6.822 14.753 8.791 12.402 31.044-3.98 36.195z"
                                        fill="#ff6d7a" />
                                    <path
                                        d="m279.15 374.39c3.698 1.163 7.664 1.804 11.916 1.841 41.296.364 74.966 33.017 74.966 74.315v7.517c0 7.732 6.268 14 14 14h6c4.418 0 8-3.582 8-8v-39.26c0-41.191-33.395-74.555-74.585-74.57-14.564-.005-27.387-7.504-34.765-18.86-2.974 2.54-6.158 4.823-9.66 6.822-14.753 8.791-12.402 31.044 3.98 36.195z"
                                        fill="#e84857" />
                                    <path
                                        d="m313.142 27.783c-11.758 4.839-13.434 5.906-17.508 5.274-65.674-10.18-123.294 16.993-142.862 80.786v.01c-7.32 8.42-11.74 19.42-11.74 31.44v37.523c0 16.188-25 17.315-25-.293v-41.56c-.32-14.47.34-65.5 37.2-101.03 42.86-41.31 110.78-37.93 159.98-15.83 1.6.72 1.55 3.01-.07 3.68z"
                                        fill="#4d4e59" />
                                    <path
                                        d="m402.032 424.806v47.257c0 4.418-3.582 8-8 8s-8-3.582-8-8v-47.257c0-36.795-29.775-66.572-66.573-66.571-17.411 0-33.208-8.87-42.259-23.728-2.298-3.773-1.103-8.696 2.671-10.994 3.773-2.299 8.695-1.103 10.994 2.671 6.122 10.051 16.811 16.051 28.594 16.051 45.637-.002 82.573 36.93 82.573 82.571zm-139.606-80.193c.941 4.317-1.796 8.579-6.113 9.52-21.054 4.587-42.467-.005-59.516-11.642-16.878 18.087-39.176 15.744-36.191 15.744-36.795-.001-66.573 29.773-66.573 66.571v47.257c0 4.418-3.582 8-8 8s-8-3.582-8-8v-47.257c0-45.636 36.929-82.571 82.571-82.571 18.462 0 33.429-14.875 33.429-33.342v-2.107c-34.919-16.697-59.429-51.784-60.923-92.643-14.37-3.455-25.077-16.317-25.077-31.62v-41.473c-.437-20.3 2.577-71.143 39.648-106.877 45.775-44.126 119.183-41.323 173.161-15.338 5.261 2.535 6.06 9.643 1.691 13.324 27.345 6.67 50.925 23.48 66.074 47.538.782 1.239 2.214 3.184 1.84 6.287-.232 1.931-.807 3.565-2.295 5.075-9.75 9.888-15.119 22.991-15.119 36.896v54.57c0 4.418-3.582 8-8 8s-8-3.582-8-8v-54.57c0-16.037 5.479-31.259 15.542-43.487-15.338-21.936-39.268-36.044-66.332-38.942l-14.061-1.506c-8.222-.88-9.835-12.207-2.194-15.352l6.395-2.633c-83.286-29.035-172.351 3.226-172.351 114.928v41.56c0 6.348 3.656 11.865 9 14.636v-51.863c0-30.878 25.122-56 56-56h102c30.878 0 56 25.12 56 55.997v65.503c0 69.574-67.988 122.42-137.17 102.053-.45 5.708-1.871 11.216-4.186 16.336 13.458 9.242 30.453 12.97 47.23 9.314 4.317-.94 8.579 1.797 9.52 6.114zm-22.394-43.425c50.178 0 91-40.822 91-91v-64.895c0-22.054-17.944-39.997-40-39.997h-102c-22.056 0-40 17.944-40 40v64.892c0 50.178 40.822 91 91 91zm81 137.875h-24c-4.418 0-8 3.582-8 8s3.582 8 8 8h24c4.418 0 8-3.582 8-8s-3.582-8-8-8z" />
                                </svg>
                            </div>
                            <div class="person-info">
                                <p>{{ $item->email }}</p>
                                <p>{{ $item->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                </table>
            </div>
        @endif
    @else
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="d-flex justify-content-around" style="width: 100%">
                        <div class="card border-dark mb-3 border-success border-bottom " style="width: 20%">
                            <div class="d-flex justify-content-between">
                                <div class="card-body text-dark">
                                    <h5 class="card-title">
                                        {{ __trans($language, 'All.totalRechargeAmountToday', 'Tổng nạp trong ngày') }}
                                    </h5>
                                    <p class="card-text">{{ currency_format($totalRechargeAmountToday) }}</p>
                                </div>
                                <div class="d-flex align-items-center" style="width: 10%; scale: 1.5">
                                    <span class="fa fa-credit-card checked"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card border-dark mb-3 border-bottom border-success" style="width: 20%">
                            <div class="d-flex justify-content-between">
                                <div class="card-body text-dark">
                                    <h5 class="card-title">
                                        {{ __trans($language, 'All.totalWithdrawAmountToday', 'Tổng rút trong ngày') }}
                                    </h5>
                                    <p class="card-text">{{ currency_format($totalWithdrawAmountToday) }}</p>
                                </div>
                                <div class="d-flex align-items-center" style="width: 10%; scale: 1.5">
                                    {{-- withdraw icon --}}
                                    <span class="fa fa-credit-card checked"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card border-dark mb-3 border-bottom border-success" style="width: 20%">
                            <div class="d-flex justify-content-between">
                                <div class="card-body text-dark">
                                    <h5 class="card-title">
                                        {{ __trans($language, 'All.totalUserRegisterToday', 'Số lượng user đăng ký mới') }}
                                    </h5>
                                    <p class="card-text">{{ $totalUserRegisterToday }}</p>
                                </div>
                                <div class="d-flex align-items-center" style="width: 10%; scale: 1.5">
                                    <span class="fa fa-star checked"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (count($topByReferralCode) > 0)
                    <div class=" border-bottom mt-3 text-center" style="width: 100%">
                        <span class="mb-sm-0 font-size-18">
                            {{ __trans($language, 'All.topByReferralCode', 'Top đại lý đông cấp dưới nhất') }}</span>
                        <table class="table table-hover table-striped">
                            <colgroup>
                                <col style="width: 10%">
                                <col style="width: 30%">
                                <col style="width: 40%">
                                <col style="width: 20%">
                            </colgroup>
                            <tr>
                                <th scope="col">{{ __trans($language, 'All.Id', 'Id') }}</th>
                                <th scope="col">{{ __trans($language, 'All.Name', 'Tên') }}</th>
                                <th scope="col">{{ __trans($language, 'All.display_name', 'Tên hiển thị') }}</th>
                                <th scope="col">{{ __trans($language, 'All.total_refer', 'Số lượng cấp dưới') }}
                                </th>
                            </tr>
                            @foreach ($topByReferralCode as $recharge)
                                <tr>
                                    <td>{{ $recharge->id }}</td>
                                    <td>{{ $recharge->name }}</td>
                                    <td>{{ $recharge->address }}</td>
                                    <td>{{ $recharge->user_count }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    @if (count($topByRechargeAmount) > 0)
                        <div class=" border-bottom mt-3 text-center" style="width: 100%">
                            <span class="mb-sm-0 font-size-18">
                                {{ __trans($language, 'All.totalRechargeAmountToday', 'Top đại lý có tổng nạp nhiều nhất') }}</span>
                            <table class="table table-hover table-striped">
                                <colgroup>
                                    <col style="width: 10%">
                                    <col style="width: 30%">
                                    <col style="width: 40%">
                                    <col style="width: 20%">
                                </colgroup>
                                <tr>
                                    <th scope="col">{{ __trans($language, 'All.Id', 'Id') }}</th>
                                    <th scope="col">{{ __trans($language, 'All.Name', 'Tên') }}</th>
                                    <th scope="col">{{ __trans($language, 'All.display_name', 'Tên hiển thị') }}
                                    </th>
                                    <th scope="col">{{ __trans($language, 'All.total_recharge', 'Tổng nạp') }}</th>
                                </tr>
                                @foreach ($topByRechargeAmount as $recharge)
                                    <tr>
                                        <td>{{ $recharge->id }}</td>
                                        <td>{{ $recharge->name }}</td>
                                        <td>{{ $recharge->address }}</td>
                                        <td>{{ currency_format($recharge->total_recharge_amount) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                    @if (count($topByWithdrawAmount) > 0)
                        <div class=" border-bottom mt-3 text-center" style="width: 100%">
                            <span class="mb-sm-0 font-size-18">
                                {{ __trans($language, 'All.totalWithdrawAmountToday', 'Top đại lý có tổng rút nhiều nhất') }}</span>
                            <table class="table table-hover table-striped">
                                <colgroup>
                                    <col style="width: 10%">
                                    <col style="width: 30%">
                                    <col style="width: 40%">
                                    <col style="width: 20%">
                                </colgroup>
                                <tr>
                                    <th scope="col">{{ __trans($language, 'All.Id', 'Id') }}</th>
                                    <th scope="col">{{ __trans($language, 'All.Name', 'Tên') }}</th>
                                    <th scope="col">{{ __trans($language, 'All.display_name', 'Tên hiển thị') }}
                                    </th>
                                    <th scope="col">
                                        {{ __trans($language, 'All.total_withdraw_amount', 'Tổng nạp') }}</th>
                                </tr>
                                @foreach ($topByWithdrawAmount as $recharge)
                                    <tr>
                                        <td>{{ $recharge->id }}</td>
                                        <td>{{ $recharge->name }}</td>
                                        <td>{{ $recharge->address }}</td>
                                        <td>{{ currency_format($recharge->total_withdraw_amount) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        @endif
    </div>
@endsection()
@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" defer>
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    @stack('c-script')
    <script>
        let startDate1 = '';
        let endDate1 = '';
        let startDate2 = '';
        let endDate2 = '';
        const handleFilter1 = () => {
            let url = window.location.href.split('?')[0];
            if (startDate1 && endDate1) {
                url +=
                    `?from1=${moment(startDate1).startOf('day').toISOString()}&to1=${moment(endDate1).endOf('day').toISOString()}`;
            }
            window.location.href = url;
        }
        const handleFilter2 = () => {
            let url = window.location.href.split('?')[0];
            if (startDate2 && endDate2) {
                url +=
                    `?from2=${moment(startDate2).startOf('day').toISOString()}&to2=${moment(endDate2).endOf('day').toISOString()}`;
            }
            window.location.href = url;
        }
        $(document).ready(function() {
            $("#input1").daterangepicker({},
                function(start, end, label) {
                    startDate1 = start.format("YYYY-MM-DD").toString();
                    endDate1 = end.format("YYYY-MM-DD").toString();
                }
            );
            $("#input2").daterangepicker({},
                function(start, end, label) {
                    startDate2 = start.format("YYYY-MM-DD").toString();
                    endDate2 = end.format("YYYY-MM-DD").toString();
                }
            );
        })
    </script>
    <script>
        $(document).ready(function() {

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
            @if (session()->has('login-current') && !empty($popup))

                $('.popup-banner-slick').slick({
                    arrows: false,
                    dots: true
                });
                $("#popup-banner-btn")[0].click();
                @php(session()->remove('login-current'))
            @endif
        });
    </script>
    <style>
        .contact-container {
            display: grid;
            grid-template-columns: repeat(3, 2fr);
            row-gap: 10px;
            width: 100%;
            background: #ffffff;
            box-shadow: 0px 24px 74px -20px rgba(130, 148, 173, 0.44);
            border-radius: 15px;
            padding: 59px 50px;
            margin-top: 20px;
        }



        .user-row {
            display: flex;
            position: relative;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .profile-photo {
            width: 66px;
            height: 66px;
            cursor: pointer;
        }

        .person-info {
            flex-grow: 1;
            margin-left: 15px;
        }

        .person-info p:nth-child(1) {
            font-size: 18px;
            font-weight: 500;
            line-height: 21px;
        }

        .person-info p:nth-child(2) {
            font-size: 14px;
            font-weight: 400;
            line-height: 16px;
        }

        .msg-icon {
            width: 34px;
            height: 34px;
            cursor: pointer;
        }


        .contact-container .view {
            position: relative;
            width: 165px;
            height: 120px;
            top: 35px;
            background: #000;
            color: #ffffff;
            border-radius: 60px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            outline: none;
            transition: all 0.4s ease;
        }


        .wrapper {
            min-height: 20vh;
            width: 100%;
            display: flex;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            display: flex;
            gap: 30px;
            flex-flow: column nowrap;
            align-items: center;
            justify-content: center;
        }

        .myrow {
            display: flex;
            flex-flow: row;
            justify-content: center;
            gap: 40px;
            width: 100%;
        }

        .mycard {
            display: flex;
            width: 100%;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
            color: #fcfcfc;
            padding: 32px;
            border-radius: 30%;
            position: relative;
            z-index: 1;
            box-shadow: 6px 28px 46px -6px #000;
        }

        .mycard::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            border-radius: 1rem;
            background: linear-gradient(135deg, #f27121, #000000 40%);
            z-index: -2;
        }

        .mycard::after {
            content: '';
            position: absolute;
            left: 1px;
            top: 1px;
            width: calc(100% - 1px);
            height: calc(100% - 1px);
            border-radius: 1rem;
            background: linear-gradient(90deg, #171721, #060609);
            transition: box-shadow 0.3s ease;
            z-index: -1;
        }

        .mycard .info {
            display: flex;
            flex-flow: column nowrap;
        }

        .mycard .info .sub {
            color: #ff7a00;
            line-height: 28px;
            font-size: 14px;
            font-weight: 400;
        }

        .mycard .info .title {
            max-width: 260px;
            line-height: 28px;
            font-size: 17px;
            font-weight: 500;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .mycard .info .btn {
            margin-top: 28px;
            color: #fff;
            background: transparent;
            border: unset;
            border-radius: 16px;
            overflow: hidden;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 16px;
            margin-right: auto;
            cursor: pointer;
            position: relative;
            z-index: 0;
            transition: background 0.3s ease;
        }

        .mycard .info .btn::before,
        .mycard .info .btn::after {
            content: '';
            position: absolute;
        }

        .mycard .info .btn::before {
            left: 50%;
            top: 50%;
            background: linear-gradient(90deg, #ff7a00 0%, transparent 45%, transparent 55%, #ff7a00 100%);
            transform: translate(-50%, -50%) rotate(55deg);
            width: 100%;
            height: 240%;
            border-radius: 16px;
            z-index: -2;
            opacity: 0.4;
            transition: all 0.3s ease;
        }

        .mycard .info .btn::after {
            left: 2px;
            top: 2px;
            background: #171721;
            width: calc(100% - 4px);
            height: calc(100% - 4px);
            border-radius: 16px;
            z-index: -1;
        }

        .mycard .info .btn:hover::before {
            animation: 5s move infinite linear;
            opacity: 1;
        }

        .mycard .image {
            min-width: 86px;
            min-height: 86px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: 8px 12px 16px #000;
            position: relative;
            z-index: 0;
        }

        .mycard .image::before {
            content: '';
            position: absolute;
            background: linear-gradient(110deg, #ff7a00 10%, #000000);
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            z-index: -2;
        }

        .mycard .image::after {
            content: '';
            position: absolute;
            left: 1px;
            top: 1px;
            width: calc(100% - 1px);
            height: calc(100% - 1px);
            border-radius: 50%;
            background: linear-gradient(90deg, #12121a, #030303);
            box-shadow: 6px 6px 14px -6px #f2712150 inset;
            z-index: -1;
        }

        .mycard .image>i {
            font-size: 30px;
            color: #ff7a00;
        }

        @keyframes move {
            0% {
                transform: translate(-50%, -50%) rotate(55deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(415deg);
            }
        }
    </style>
@endsection()
