
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="TheDevGarden Management Bank.">
  <meta name="author" content="TheDevGarden Dev Team">
  <title>TDG Admin Dashboard</title>
 <!-- Favicon -->
 <link rel="icon" href="{{ asset("assets/img/brand/favicon.png") }}" type="image/png">
 <!-- Fonts -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
 <!-- Icons -->
 <link rel="stylesheet" href="{{ asset("assets/vendor/nucleo/css/nucleo.css") }}" type="text/css">
 <link rel="stylesheet" href="{{ asset("assets/vendor/@fortawesome/fontawesome-free/css/all.min.css") }}" type="text/css">
  <!-- for datatable -->
  <link rel="stylesheet" href="{{ asset("assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css") }}">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset("assets/css/argon.css?v=1.1.0") }}" type="text/css">
</head>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="/{{ Auth::user()->role }}/dashboard">
          <img src="{{ asset("/assets/img/brand/blue.jpg") }}" class="navbar-brand-img" alt="...">
        </a>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">

            <li class="nav-item">
              <a class="nav-link <?php if(request()->route()->getName() == "admin.dashboard") { echo "active";} ?>" href="/{{ Auth::user()->role }}/dashboard">
                <i class="ni ni-box-2 text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if(request()->route()->getName() == "admin.addamount") { echo "active";} ?>" href="{{ route("admin.addamount") }}">
                  <i class="ni ni-money-coins text-primary"></i>
                  <span class="nav-link-text">Add Amount</span>
                </a>
            </li>

            <li class="nav-item">
              <a class="nav-link <?php if(request()->route()->getName() == "admin.addmember" || request()->route()->getName() == "admin.viewMember") { echo "active";} ?>" href="{{ route("admin.addamount") }}" href="#navbar-member" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-sallery">
                <i class="fas fa-users text-warning"></i>
                <span class="nav-link-text">Member</span>
              </a>

              <div class="collapse" id="navbar-member">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{ route("admin.addmember") }}" class="nav-link">Add Member</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route("admin.viewMember") }}" class="nav-link">View All Members</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link <?php if(request()->route()->getName() == "admin.paysallary") { echo "active";} ?>" href="{{ route("admin.sallaryRecord") }}" href="#navbar-sallery" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-sallery">
                <i class="fas fa-hand-holding-usd text-info"></i>
                <span class="nav-link-text">Sallary</span>
              </a>
              <div class="collapse" id="navbar-sallery">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{ route("admin.paysallary") }}" class="nav-link">Pay Sallery</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route("admin.sallaryRecord") }}" class="nav-link">Sallery Record</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link " href="#navbar-expence" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-expence">
                <i class="ni ni-bag-17 text-danger"></i>
                <span class="nav-link-text">Expense</span>
              </a>
              <div class="collapse" id="navbar-expence">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{ route("admin.officeexpense") }}" class="nav-link">Office Expense</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route("admin.foodexpense") }}" class="nav-link">Food Expense</a>
                  </li>
                </ul>
              </div>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </nav>


  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-12 col-1">
                  <!-- Navbar links -->
                  <ul class="navbar-nav align-items-center ml-md-auto">
                    <li class="nav-item d-xl-none">
                      <!-- Sidenav toggler -->
                      <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                          <i class="sidenav-toggler-line"></i>
                          <i class="sidenav-toggler-line"></i>
                          <i class="sidenav-toggler-line"></i>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="col-lg-6 col-6">
                  <h6 class="h2 text-white d-inline-block mb-0">Admin</h6>
                  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                      <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}"><i class="fas fa-home"></i></a></li>
                    </ol>
                  </nav>
                </div>
                <div class="col-lg-5 col-5 text-right">
                  <!-- admin dashboards profile part -->
                  <nav class="navbar navbar-top navbar-expand navbar-dark">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav align-items-center ml-auto">
                        <li class="nav-item dropdown">
                          <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="media align-items-center">
                              <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" src="../assets/img/theme/team-4.jpg">
                              </span>
                              <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->name }}</span>
                              </div>
                            </div>
                          </a>

                          <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header noti-title">
                              <h6 class="text-overflow m-0">Welcome!</h6>
                            </div>
                            <a href="{{ route("admin.profile")  }}" class="dropdown-item">
                              <i class="ni ni-single-02"></i>
                              <span>My profile</span>
                            </a>
                            <a href="{{ route("admin.editprofile") }}" class="dropdown-item">
                              <i class="fa fa-edit"></i>
                              <span>Edit Profile</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route("logout") }}" class="dropdown-item">
                              <i class="ni ni-user-run"></i>
                              <span>Logout</span>
                            </a>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </nav>
                </div>
              </div>
            </div>

          <!-- Card stats -->

          @yield('content')


  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset("assets/vendor/jquery/dist/jquery.min.js") }}"></script>
  <script src="{{ asset("assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js") }}"></script>
  <script src="{{ asset("assets/vendor/js-cookie/js.cookie.js") }}"></script>
  <script src="{{ asset("assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js") }}"></script>
  <script src="{{ asset("assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js") }}"></script>
  <!-- Argon JS -->
  <script src="{{ asset("assets/js/argon.js") }}"></script>

</body>
</html>
