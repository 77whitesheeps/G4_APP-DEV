<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Register - Plant-O-Matic</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* Make background soft green */
        body {
            background: #eaf5e1;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- Center Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-7 col-md-9"> <!-- made narrower to center -->
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">

                        <!-- App Title -->
                        <div class="text-center mb-4">
                            <h1 class="h3 font-weight-bold" style="color:#68af2C;"> Plant-O-Matic</h1>
                            <h2 class="h5 text-gray-900">Create an Account!</h2>
                        </div>

                        {{-- Success message --}}
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        {{-- Registration Form --}}
                        <form class="user" action="{{ url('/register') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control form-control-user" placeholder="Full Name">
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control form-control-user" placeholder="Email Address">
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="text" name="username" value="{{ old('username') }}"
                                    class="form-control form-control-user" placeholder="Username">
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" name="password" class="form-control form-control-user"
                                        placeholder="Password">
                                    @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="password_confirmation"
                                        class="form-control form-control-user" placeholder="Repeat Password">
                                </div>
                            </div>

                            <!-- Main Register Button -->
                            <button type="submit" class="btn btn-user btn-block"
                                style="background-color:#68af2C; border-color:#68af2C; color:white;">
                                Register Account
                            </button>

                            <hr>
                            <a href="#" class="btn btn-google btn-user btn-block">
                                <i class="fab fa-google fa-fw"></i> Register with Google
                            </a>
                        </form>

                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ url('/forgot-password') }}">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{ url('/login') }}">Already have an account? Login!</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                    </div>

                                    {{-- Success message --}}
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    {{-- Registration Form --}}
                                    <form class="user" action="{{ url('/register') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control form-control-user"
                                                placeholder="Full Name">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                class="form-control form-control-user"
                                                placeholder="Email Address">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" name="password"
                                                    class="form-control form-control-user"
                                                    placeholder="Password">
                                                @error('password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" name="password_confirmation"
                                                    class="form-control form-control-user"
                                                    placeholder="Repeat Password">
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Register Account
                                        </button>

                                        <hr>
                                        <a href="#" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Register with Google
                                        </a>
                                        <a href="#" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                        </a>
                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ url('/forgot-password') }}">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{ url('/login') }}">Already have an account? Login!</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
