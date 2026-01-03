<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- Favicon icon -->
    <link
        rel="icon"
        type="image/png"
        sizes="16x16"
        href="{{ asset('image/icon_univ_bsi.png') }}" />
    <title>tokoonline</title>

    <!-- Custom CSS -->
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet" />

    {{-- ================== STYLE LOGIN MODERN ================== --}}
    <style>
        body.login-page {
            min-height: 100vh;
            background: radial-gradient(circle at top, #1e293b, #020617);
        }

        .login-page .auth-wrapper {
            min-height: 100vh;
            padding: 32px 16px;
            background: linear-gradient(
                135deg,
                rgba(37, 99, 235, 0.10),
                rgba(56, 189, 248, 0.10)
            );
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-page .auth-box {
            max-width: 420px;
            width: 100%;
            border-radius: 24px;
            background: rgba(15, 23, 42, 0.96);
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 28px 60px rgba(15, 23, 42, 0.6);
            padding: 32px 34px 28px;
        }

        .login-page .auth-box .db img {
            max-width: 120px;
            filter: drop-shadow(0 12px 25px rgba(37, 99, 235, 0.7));
        }

        .login-page .auth-box .text-white,
        .login-page .auth-box span,
        .login-page .auth-box label {
            font-size: 13px;
        }

        /* INPUT GROUP */
        .login-page .auth-box .input-group {
            margin-bottom: 14px;
        }

        .login-page .auth-box .input-group-prepend .input-group-text {
            border-radius: 999px 0 0 999px;
            border: 1px solid rgba(148, 163, 184, 0.7);
            border-right: none;
            background: transparent;
            color: #e5e7eb;
        }

        .login-page .auth-box .form-control-lg {
            border-radius: 0 999px 999px 0;
            border: 1px solid rgba(148, 163, 184, 0.7);
            border-left: none;
            background: rgba(15, 23, 42, 0.7);
            color: #e5e7eb;
            font-size: 13px;
        }

        .login-page .auth-box .form-control-lg::placeholder {
            color: #6b7280;
        }

        .login-page .auth-box .form-control-lg:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 1px rgba(37, 99, 235, 0.7);
            background: rgba(15, 23, 42, 0.9);
        }

        /* BUTTONS */
        .login-page .auth-box .btn-info#to-recover {
            background: transparent;
            border: none;
            padding-left: 0;
            color: #9ca3af;
            font-size: 12px;
        }

        .login-page .auth-box .btn-info#to-recover:hover {
            color: #f9fafb;
            text-decoration: underline;
            box-shadow: none;
        }

        .login-page .auth-box .btn-success {
            border-radius: 999px;
            padding: 9px 26px;
            font-size: 13px;
            font-weight: 600;
            background: linear-gradient(90deg, #22c55e, #16a34a);
            border: none;
            box-shadow: 0 16px 35px rgba(34, 197, 94, 0.35);
        }

        .login-page .auth-box .btn-success:hover {
            filter: brightness(1.06);
        }

        .login-page .auth-box .border-top.border-secondary {
            border-color: rgba(55, 65, 81, 0.9) !important;
        }

        .login-page #recoverform .btn-success {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            box-shadow: 0 16px 35px rgba(37, 99, 235, 0.38);
        }

        @media (max-width: 575px) {
            .login-page .auth-box {
                padding: 26px 20px 22px;
            }
        }
    </style>
    {{-- ================== END STYLE LOGIN MODERN ================== --}}

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-page">
    <div class="main-wrapper">
        <!-- Preloader -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>

        <!-- Login box -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center">
            <div class="auth-box border-top border-secondary">
                <div id="loginform">
                    <div class="text-center p-t-20 p-b-20">
                        <span class="db">
                            <img src="{{ asset('image/logo.png') }}" alt="logo" width="40%" />
                        </span>
                    </div>

                    {{-- error --}}
                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>{{ session('error')}} </strong>
                        </div>
                    @endif
                    {{-- /error --}}

                    <!-- Form login -->
                    <form class="form-horizontal m-t-20"
                          action="{{ route('backend.login') }}" method="post">
                        @csrf
                        <div class="row p-b-30">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ti-user"></i>
                                        </span>
                                    </div>
                                    <input
                                        type="text"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        placeholder="email" name="email"
                                        aria-label="email"
                                        aria-describedby="basic-addon1" />
                                    @error('email')
                                        <span class="invalid-feedback alert-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ti-pencil"></i>
                                        </span>
                                    </div>
                                    <input
                                        type="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        placeholder="password" name="password"
                                        aria-label="password"
                                        aria-describedby="basic-addon1" />
                                    @error('password')
                                        <span class="invalid-feedback alert-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <button class="btn btn-info" id="to-recover" type="button">
                                            <i class="fa fa-lock m-r-5"></i>
                                            Lost password?
                                        </button>
                                        <button class="btn btn-success float-right" type="submit">
                                            Login
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Form recover --}}
                <div id="recoverform">
                    <div class="text-center">
                        <span class="text-white">
                            Enter your e-mail address below and we will send you
                            instructions how to recover a password.
                        </span>
                    </div>
                    <div class="row m-t-20">
                        <form class="col-12" action="index.html">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white" id="basic-addon1">
                                        <i class="ti-email"></i>
                                    </span>
                                </div>
                                <input
                                    type="text"
                                    class="form-control form-control-lg"
                                    placeholder="Email Address"
                                    aria-label="Username"
                                    aria-describedby="basic-addon1" />
                            </div>
                            <div class="row m-t-20 p-t-20 border-top border-secondary">
                                <div class="col-12">
                                    <a class="btn btn-success" href="#" id="to-login" name="action">
                                        Back To Login
                                    </a>
                                    <button class="btn btn-info float-right" type="button" name="action">
                                        Recover
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- /Form recover --}}
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();

        $("#to-recover").on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
        $("#to-login").click(function() {
            $("#recoverform").hide();
            $("#loginform").fadeIn();
        });
    </script>
</body>

</html>
