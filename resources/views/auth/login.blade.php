<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{$title}}</title>
    <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <script data-search-pseudo-elements="" defer=""
        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous">
    </script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 mt-5">
                            @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <span>{{session('error')}}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span>{{session('success')}}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header justify-content-center">
                                    <h3 class=" my-4 text-center">Login</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Login form-->
                                    <form action="{{route('auth.login.process')}}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputEmailAddress">Email</label>
                                            <input class="form-control" id="inputEmailAddress" type="email" name="email"
                                            value="{{ $email }}"
                                                placeholder="Enter email address" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputPassword">Password</label>
                                            <div class="input-group">
                                                <input class="form-control" id="inputPassword" type="password" name="password"
                                                value="{{ $password }}"
                                                    placeholder="Enter password" />
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" id="rememberPasswordCheck" type="checkbox" name="remember_me" value="{{$remember}}" {{$remember ? 'checked' : ''}}/>
                                                <label class="form-check-label" for="rememberPasswordCheck">Remember
                                                    password</label>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="{{route('auth.forgot_password')}}">Forgot Password?</a>
                                            <button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="footer-admin mt-auto footer-dark">
                <div class="container-xl px-4">
                    <div class="row">
                        <div class="col-md-6 small">
                            Rizky Kamil © Apotek-Web {{$tahun}}
                        </div>
                        <div class="col-md-6 text-md-end small">
                            <a href="auth-login-basic.html#!">Privacy Policy</a>
                            ·
                            <a href="auth-login-basic.html#!">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{asset('js/scripts.js')}}"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#inputPassword');
        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            if (type === 'password') {
                this.innerHTML = '<i class="fas fa-eye"></i>';
            } else {
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            }
        });
    </script>

    <script src="https://assets.startbootstrap.com/js/sb-customizer.js"></script>
</body>

</html>
