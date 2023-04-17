<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __trans($language, 'sign_in_admin_meta_title', 'MCCANNAISA - Sign in') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="">
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Đăng ký</h5>
                                        <p>McCann Asia hoàn toàn miễn phí việc đăng ký tài khoản. Hãy cẩn
                                            trọng với các hành vi lừa đảo yêu cầu nộp phí để đăng ký tài
                                            khoản.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <x-component::html.image-full image="assets/images/profile-img.png" />
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="{{ route('auth.login') }}" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <x-component::html.image-rounded-circle image="assets/images/logo-light.svg"
                                                height="34" />
                                        </span>
                                    </div>
                                </a>

                                <a href="{{ route('auth.login') }}" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <x-component::html.image-rounded-circle image="assets/images/logo-light.svg"
                                                height="34" />
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <x-component::form.error />
                                <form id="register-form" action="{{ route('auth.login.store') }}" method="POST"
                                    class="form-submit" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="username">Tên hiển thị</label>
                                                <input id="username" name="username" type="text"
                                                    class="form-control mb-2" value="" autocomplete="off">
                                                <span id="username-err" class="text-danger d-none">Đây là trường bắt
                                                    buộc</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="email">Email</label>
                                                <input id="email" name="email" type="text"
                                                    class="form-control mb-2" value="" autocomplete="off">
                                                <span id="email-err" class="text-danger d-none">Đây là trường bắt
                                                    buộc</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="phone">Số điện thoại</label>
                                                <input id="phone" name="phone" type="text"
                                                    class="form-control mb-2" value="" autocomplete="off">
                                                <span id="phone-err" class="text-danger d-none">Đây là trường bắt
                                                    buộc</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="password">Mật khẩu</label>
                                                <input id="password" name="password" type="password"
                                                    class="form-control mb-2" value="" autocomplete="off">
                                                <span id="password-err" class="text-danger d-none">Đây là trường bắt
                                                    buộc</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="repassword">Nhập lại mật khẩu</label>
                                                <input id="repassword" name="repassword" type="password"
                                                    class="form-control mb-2" value="" autocomplete="off">
                                                <span id="repassword-err" class="text-danger d-none">Đây là trường bắt
                                                    buộc</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="name">Họ và Tên</label>
                                                <input id="name" name="name" type="text"
                                                    class="form-control mb-2" value="" autocomplete="off">
                                                <span id="name-err" class="text-danger d-none">Đây là trường bắt
                                                    buộc</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="gender">Giới tính</label>
                                                <select name="gender" class="form-control mb-2" id="gender">
                                                    <option value="Male">Nam</option>
                                                    <option value="Female">Nữ</option>
                                                </select>
                                                <span id="gender-err" class="text-danger d-none">Đây là trường bắt
                                                    buộc</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="productname">Mã giới thiệu</label>
                                                <input id="productname" name="parent_referral_code" type="text"
                                                    class="form-control" value="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 d-grid">
                                        <div class="g-recaptcha" id="feedback-recaptcha"
                                            data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                                        <button class="btn btn-danger waves-effect waves-light" type="submit"
                                            style="margin-top: 10px" onclick="return handleValidate()">Đăng
                                            ký</button>
                                    </div>

                                    <div class="mt-3 d-grid">
                                        <a href="{{ route('auth.login') }}"
                                            class="btn btn-primary waves-effect waves-light" type="button"
                                            style="margin-top: 10px"
                                            onclick="return confirm('Bạn có chắc chắn muốn hủy đăng ký?')">Đăng
                                            nhập</a>
                                    </div>
                                </form>
                                <div class="mt-4 text-center">
                                    <h5 class="font-size-14 mb-3">Đăng nhập với</h5>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="{{ route('auth.facebook') }}"
                                                class="social-list-item bg-primary text-white border-primary">
                                                <i class="mdi mdi-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{ route('auth.google') }}"
                                                class="social-list-item bg-danger text-white border-danger">
                                                <i class="mdi mdi-google"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="mt-4 text-center">
                                    <a href="{{ route('auth.google') }}" class="text-muted"><i
                                            class="mdi mdi-lock me-1"></i> Quên mật khẩu?</a>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
    <script>
        var botmanWidget = {
            aboutText: 'Botman',
            introMessage: "Hello! How may we help you?"
        };
    </script>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        const validateFieldsId = ["username", "phone", "address", "gender"];
        $(document).ready(function() {
            $("#password").on("input", function() {
                const password = $(this).val();
                const passwordErr = $("#password-err");
                if (password.length < 8) {
                    passwordErr.text("Mật khẩu phải có ít nhất 8 ký tự");
                    passwordErr.removeClass("d-none");
                } else if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/.test(password)) {
                    passwordErr.text(
                        "Mật khẩu phải có ít nhất 1 ký tự viết hoa, 1 ký tự số và 1 ký tự đặc biệt"
                    );
                    passwordErr.removeClass("d-none");
                } else {
                    passwordErr.addClass("d-none");
                }
            });
            $("#repassword").on("input", function() {
                const password = $("#password").val();
                const repassword = $(this).val();
                const repasswordErr = $("#repassword-err");
                if (password !== repassword) {
                    repasswordErr.text("Mật khẩu nhập lại không khớp");
                    repasswordErr.removeClass("d-none");
                } else {
                    repasswordErr.addClass("d-none");
                }
            });
            $("#email").on("input", function() {
                const email = $(this).val();
                const emailErr = $("#email-err");
                if(!email){
                    emailErr.text("Email không được để trống");
                    emailErr.removeClass("d-none");
                }
                if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email)) {
                    emailErr.text("Email không hợp lệ");
                    emailErr.removeClass("d-none");
                } else {
                    emailErr.addClass("d-none");
                }
            });
        });

        function handleValidate() {
            let isValid = true;
            validateFieldsId.forEach((fieldId) => {
                const field = document.getElementById(fieldId);
                const fieldErr = document.getElementById(`${fieldId}-err`);
                if (field.value === "") {
                    fieldErr.classList.remove("d-none");
                    isValid = false;
                } else {
                    fieldErr.classList.add("d-none");
                }
                if (!$("#password-err").hasClass("d-none") || !$("#repassword-err").hasClass(
                        "d-none")) {
                    isValid = false;
                }
            });
            return isValid;
        }
    </script>
</body>

</html>
