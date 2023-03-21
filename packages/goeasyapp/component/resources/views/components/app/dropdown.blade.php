<button type="button" class="btn header-item waves-effect text-white show-p" id="page-header-user-dropdown"
    ata-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
		<img alt="Header Avatar" onerror="this.onerror=null;this.src='{{asset('assets/images/users/avatar-1.jpg')}}';" class="rounded-circle header-profile-user" src="{{asset(Auth::user()->image)}}">
        <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{Auth::user()->name}}</span>
        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
</button>
<div class="dropdown-menu dropdown-menu-end view-p">
    <a class="dropdown-item" href="{{route('user.update', Auth::user()->id)}}"><i class="fas fa-pencil-alt font-size-14 align-middle me-1"></i> <span key="t-logout">{{ __trans($language, 'All.personal_information', 'Thông tin cá nhân') }}</span></a>
    <a class="dropdown-item text-danger" href="{{route('auth.signout')}}"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Đăng xuất</span></a>
</div>
