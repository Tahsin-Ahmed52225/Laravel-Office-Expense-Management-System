
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="TheDevGarden Management Bank.">
  <meta name="author" content="TheDevGarden Dev Team">
  <title>Tdg | Bank</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ asset("assets/img/brand/favicon.png") }}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset("assets/vendor/nucleo/css/nucleo.css") }}" type="text/css">
  <link rel="stylesheet" href="{{ asset("assets/vendor/@fortawesome/fontawesome-free/css/all.min.css") }}" type="text/css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset("assets/css/argon.css?v=1.1.0") }}" type="text/css">
</head>

<body class="bg-default">
  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white">TheDevGarden Bank</h1> <br>

            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4 d-flex flex-column">

                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                @if(Session::has('alert-' . $msg))
                                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                @endif
                @endforeach
                <small>Or sign in with credentials</small>
              </div>
            <form method="POST" action="{{ route('login') }}">
            @csrf
                <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" placeholder="Email" type="email"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" placeholder="Password" type="password" name="password" required autocomplete="current-password">
                  </div>
                </div>
                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin">
                    <span class="text-muted">Remember me</span>
                  </label>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary my-4">{{ __('Login') }}</button>
                </div>
              </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">

                                @if (Route::has('password.request'))
                                     <a class="text-light" href="{{ route('password.request') }}">
                                        <small>Forgot password?</small>
                                     </a>
                                @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset("assets/vendor/jquery/dist/jquery.min.js") }}"></script>
  <script src="{{ asset("assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js") }}"></script>

</body>

</html>

