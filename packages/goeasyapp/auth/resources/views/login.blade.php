<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{__trans($language, 'sign_in_admin_meta_title', 'MCCANNAISA - Sign in')}}</title>
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body class="">
        <div class="account-pages my-5 pt-sm-5">

			<form method="POST" action="{{ route('auth.login.check') }}">
            @csrf
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Đăng nhập</h5>
                                            <p>McCann Asia hoàn toàn miễn phí việc đăng ký tài khoản. Hãy cẩn trọng với các hành vi lừa đảo yêu cầu nộp phí để đăng ký tài khoản.</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <x-component::html.image-full image="assets/images/profile-img.png"/>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <div class="auth-logo">
                                    <a href="{{ route('auth.login') }}" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <x-component::html.image-rounded-circle image="assets/images/logo-light.svg" height="34"/>
                                            </span>
                                        </div>
                                    </a>

                                    <a href="{{ route('auth.login') }}" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <x-component::html.image-rounded-circle  image="assets/images/logo-light.svg" height="34"/>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                    <x-component::form.error />
                                    <x-component::form.text id="username" key="username" default="Số Điện Thoại" placeholder="enter_username" defaultplaceholder="" name="email" value="{{old('email')}}"/>
                                    <x-component::form.password id="password" key="password" default="Password" placeholder="enter_password" defaultplaceholder="" name="password" value=""/>
                                    <div class="mt-3 d-grid">
                                        <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY')  }}"></div>
                                        <x-component::form.submit key="log_in" default="Đăng nhập"/>
                                    </div>
                                    <div class="mt-3 d-grid">
                                        <a href="{{ route('auth.register') }}" class="btn btn-danger waves-effect waves-light" type="button" style="margin-top: 10px">Đăng ký</a>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <h5 class="font-size-14 mb-3">Đăng Nhập Với</h5>

                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="{{route('auth.facebook')}}" class="social-list-item bg-primary text-white border-primary">
                                                    <i class="mdi mdi-facebook"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="{{route('auth.google')}}" class="social-list-item bg-danger text-white border-danger">
                                                    <i class="mdi mdi-google"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <a href="{{ route('auth.google') }}" class="text-muted"><i class="mdi mdi-lock me-1"></i> Quên mật khẩu?</a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
			</form>
        </div>
		<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
    </body>
</html>






