
<?php
use App\Models\Category;
$cas = Category::all();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-component::app.header/>
    <body class="">
		<body data-sidebar="dark">
		<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <div class="navbar-brand-box" style="background: #fff !important;">
                            <x-component::app.navbar/>
                        </div> 
                        
                        <button type="button" class="btn btn-sm px-3 font-size-14 header-item dnm-cs waves-effect" id="">
                            <a style="color: #fff;"  href="{{route('campain.statistical')}}"><i class='bx bx-notification'></i> <span style="">{!!__trans($language, 'All.statistical', 'Statistical')!!}</span></a>
                        </button>
						<button type="button" class="btn btn-sm px-3 font-size-14 header-item dnm-cs waves-effect" id="">
                            <a style="color: #fff;"  href="{{route('campain.day')}}"><i class='bx bx-notification'></i> <span style="">{!!__trans($language, 'All.campain_day', 'Campain Day')!!}</span></a>
                        </button>
                       <button type="button" class="btn btn-sm px-3 font-size-14 header-item dnm-cs waves-effect" id="">
                           <a style="color: #fff;" href="{{route('campain.my')}}"><i class='bx bxs-customize' ></i> <span style="">{!!__trans($language, 'All.campain_my', 'My Campain')!!}</span></a>
                       </button>   
                       <button type="button" class="btn btn-sm px-3 font-size-14 header-item dnm-cs waves-effect" id="">
                        <a style="color: #fff;" href="{{route('campain.payment')}}"><i class='bx bxs-customize' ></i> <span style="">{!!__trans($language, 'All.payment', 'Payment')!!}</span></a>
                    </button>   
                    </div>
                    <div class="d-flex">
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect text-white" id="page-header-user-dropdown"
                                ata-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                <a href="{{ route('admin.locale.cn') }}" class="mr-3">Cn</a>
                            </button>
                            <button type="button" class="btn header-item waves-effect text-white" id="page-header-user-dropdown"
                                ata-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                <a href="{{ route('admin.locale.en') }}" class="mr-3">En</a>
                            </button>
                            <button type="button" class="btn header-item waves-effect text-white" id="page-header-user-dropdown"
                                ata-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                <a href="{{ route('admin.locale.vi') }}" class="mr-3">Vi</a>
                            </button>
                            <x-component::app.dropdown/>
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
                            @if(Auth::user()->type != 'agency')
                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="bx bxs-briefcase-alt-2"></i>
                                    <span key="t-dashboards">{!!__trans($language, 'All.bank', 'Bank')!!}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="{{route('config.list')}}" key="t-default">{!!__trans($language, 'All.list', 'List')!!}</a></li>	
                                    <li><a href="{{route('config.create')}}" key="t-default">{!!__trans($language, 'All.add_new', 'Add New')!!}</a></li>	
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="bx bxs-briefcase-alt-2"></i>
                                    <span key="t-dashboards">{!!__trans($language, 'All.language', 'Language')!!}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="{{route('language.list')}}" key="t-default">{!!__trans($language, 'All.list', 'List')!!}</a></li>	
                                    <li><a href="{{route('language.create')}}" key="t-default">{!!__trans($language, 'All.add_new', 'Add New')!!}</a></li>	
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="bx bxs-briefcase-alt-2"></i>
                                    <span key="t-dashboards">{!!__trans($language, 'All.banner', 'Banner')!!}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="{{route('banner.list')}}" key="t-default">{!!__trans($language, 'All.list', 'List')!!}</a></li>	
                                    <li><a href="{{route('banner.create')}}" key="t-default">{!!__trans($language, 'All.add_new', 'Add New')!!}</a></li>	
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="bx bxs-briefcase-alt-2"></i>
                                    <span key="t-dashboards">{!!__trans($language, 'All.category_new', 'Category New')!!}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="{{route('category-new.list')}}" key="t-default">{!!__trans($language, 'All.list', 'List')!!}</a></li>	
                                    <li><a href="{{route('category-new.create')}}" key="t-default">{!!__trans($language, 'All.add_new', 'Add New')!!}</a></li>	
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="bx bxs-briefcase-alt-2"></i>
                                    <span key="t-dashboards">{!!__trans($language, 'All.blog', 'Blog')!!}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="{{route('blog.list')}}" key="t-default">{!!__trans($language, 'All.list', 'List')!!}</a></li>	
                                    <li><a href="{{route('blog.create')}}" key="t-default">{!!__trans($language, 'All.add_new', 'Add New')!!}</a></li>	
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="bx bxs-briefcase-alt-2"></i>
                                    <span key="t-dashboards">{!!__trans($language, 'All.campain', 'Campain')!!}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="{{route('campain.list')}}" key="t-default">{!!__trans($language, 'All.list', 'List')!!}</a></li>	
                                    <li><a href="{{route('campain.create')}}" key="t-default">{!!__trans($language, 'All.add_new', 'Add New')!!}</a></li>	
                                    <li><a href="{{route('campain.resuft.list')}}" key="t-default">{!!__trans($language, 'All.resuft', 'Resuft')!!}</a></li>	
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="bx bxs-briefcase-alt-2"></i>
                                    <span key="t-dashboards">{!!__trans($language, 'All.agency', 'Agency')!!}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="{{route('user')}}" key="t-default">{!!__trans($language, 'All.list', 'List')!!}</a></li>	
                                    <li><a href="{{route('user.create')}}" key="t-default">{!!__trans($language, 'All.add_new', 'Add New')!!}</a></li>	
                                </ul>
                            </li>
							<li>
                                <a href="{{route('payment.list')}}" class="waves-effect">
                                    <i class="bx bxs-briefcase-alt-2"></i>
                                    <span key="t-dashboards">{!!__trans($language, 'All.payment', 'Payment')!!}</span>
                                </a>

                            </li>
                            @else
                            <li class="menu-title" key="t-menu">Menus</li>
                            <li>
                                <a href="{{route('campain.hot')}}" class="waves-effect">
                                    <i class="bx bxs-briefcase-alt-2"></i>
                                    <span key="t-dashboards">{!!__trans($language, 'All.campain_hot', 'Campain Hot')!!}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('campain.my')}}" class="waves-effect">
                                    <i class="bx bxs-briefcase-alt-2"></i>
                                    <span key="t-dashboards">{!!__trans($language, 'All.campain_use', 'Campain Using')!!}</span>
                                </a>

                            </li>
                            <li class="menu-title" key="t-menu">Category</li>
                            @foreach($cas as $ca)
                            
                            <li>
                                <a href="{{route('campain.category', $ca->id)}}" class="waves-effect">
                                    <i class="bx bxs-briefcase-alt-2"></i>
                                    <span key="t-dashboards">{{$ca->name}}</span>
                                </a>

                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="main-content">
				<div class="page-content">
                    <x-component::form.error/>
				@if(session()->has('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-left: 13px;margin-right: 13px;">
                        <i class="mdi mdi-check-all me-2"></i>
                            {!! session()->get('success') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>						
				@endif
				@yield('content')
				</div>
            </div>
			@yield('modal')
        </div>
		<x-component::app.footer/>
    </body>
</html>
