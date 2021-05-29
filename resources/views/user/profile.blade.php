@extends('layouts.user_layout')
@section('content')

<div class="container-fluid mt--5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card card-profile">
                <img src="../assets/img/theme/img-1-1000x600.jpg" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="../assets/img/theme/team-4.jpg" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route("user.editprofile") }}" class="btn btn-sm btn-default float-right">Edit Info</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    {{-- <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center">
                                <div>
                                    <span class="heading">22</span>
                                    <span class="description">Members</span>
                                </div>
                                <div>
                                    <span class="heading">10</span>
                                    <span class="description">Core Member</span>
                                </div>
                                <div>
                                    <span class="heading">2</span>
                                    <span class="description">Intern</span>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="text-center">
                        <h5 class="h3">
                            {{ Auth::user()->name }}
                        </h5>
                        <div class="h5 mt-4">
                            <i class="fas fa-briefcase mr-2"></i></i>{{ strtoupper(Auth::user()->designation) }} - {{ Auth::user()->department }}
                        </div>
                        <div>
                            <i class="fas fa-envelope mr-2"></i>{{ Auth::user()->email }}   <i class="fas fa-phone   ml-2 mr-2"></i>{{ Auth::user()->number }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






@endsection
