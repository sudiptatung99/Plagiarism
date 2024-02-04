
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('image/favicon.ico') }}" type="image/x-icon">
    <title>{{ config('app.name', 'eAarjav') }} - Login</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
</head>
<body class="nk-body" data-sidebar-collapse="lg" data-navbar-collapse="lg">
    <div class="nk-app-root">
        <div class="nk-main">
            <div class="nk-wrap align-items-center justify-content-center">
                <div class="container p-2 p-sm-4">
                    <div class="wide-xs mx-auto">
                        <div class="text-center mb-5">
                            <div class="brand-logo mb-1">
                                <a href="{{ url('/') }}" class="logo-link">
                                    <div class="logo-wrap">
                                       <img src="{{asset('image/logo.svg')}}" alt="" style="width: auto; height: 65px;" />
                                    </div>
                                </a>
                            </div>

                        </div>
                        <div class="card card-gutter-lg rounded-4 card-auth">
                            <div class="card-body">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title mb-1">Login to Account</h3>
                                        <p class="small">Please sign-in to your account and start the adventure.</p>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="text-danger h6 text-center" />
                                <form method="POST" action="{{ route('login') }}">
                                @csrf
                                    <div class="row gy-3">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Email</label>
                                                <div class="form-control-wrap">
                                                    <input type="email" class="form-control" name="email" :value="old('email')" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Password</label>
                                                <div class="form-control-wrap">
                                                    <input type="password" class="form-control" name="password" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-wrap justify-content-between">
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                                    <label class="form-check-label" for="remember_me">Remember Me</label>
                                                </div>
                                                {{-- <a href="{{ route('password.request') }}" class="small">Forgot Password?</a> --}}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid"><button class="btn btn-primary" type="submit">Login to account</button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('admin/assets/js/bundle.js') }}"></script>
<script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
</html>

