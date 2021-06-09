@extends('layouts.admin_layout')
@section('content')
<div class="container-fluid mt--6">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
    @endforeach
    <div class="row">
      <div class="col-md-8 offset-2">
        <div class="card">
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col-8">
                <h3 class="mb-0">Edit profile </h3>
              </div>
              <div class="col-4 text-right">
                <a href="{{  route("admin.profile") }}" class="btn btn-sm btn-primary">Profile</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <form autocomplete="off" action="{{ route("admin.editprofile") }}" method="POST" enctype="multipart/form-data">
            @csrf
              <h6 class="heading-small text-muted mb-4">User information</h6>
              <div class="">
                  <div class="row">
                      <div class="col-lg-6">
                          <div class="form-group">
                              <label class="form-control-label" for="input-username">Name</label>
                              <input autocomplete="off" name="name" type="search" id="input-username" class="form-control" placeholder="{{ Auth::user()->name }}">
                          </div>
                      </div>
                      <div class="col-lg-6">
                          <div class="form-group">
                              <label class="form-control-label" for="input-email">Email address</label>
                              <input autocomplete="off" name="email" type="email" id="input-email" class="form-control" placeholder="{{ Auth::user()->email }}">
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="exampleFormControlSelect12">Change Designation</label>
                            <select class="form-control" id="exampleFormControlSelect12" name="designation">
                              <option selected disabled>Change Position..</option>
                              <option>Jr. Web Developer</option>
                              <option>Jr. Designer</option>
                              <option>Jr. Frontend Developer</option>
                              <option>Jr. Content Writer</option>
                            </select>
                          </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="exampleFormControlSelect1">Change Department</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="department">
                              <option selected disabled>Change Department..</option>
                              <option value="Web Development">Web Development</option>
                              <option value="Graphices Design">Graphices Design</option>
                              <option value="Content & Marketing">Content & Manageing </option>
                            </select>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-email">Phone</label>
                            <input name="number" type="tel" id="input-email" class="form-control" placeholder="{{ Auth::user()->number }}">
                        </div>

                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-email">Change Password</label>
                            <input type="password" id="input-email" class="form-control" name="password" >
                        </div>

                      </div>

                  </div>
                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-control-label" for="input-email">Upload Profile Image</label>
                            <input type="file"  id="input-file" name="profile_image" class="form-control" >
                        </div>

                      </div>
                  </div>
              </div>
              <div class="text-center">
                  <button class="btn btn-primary w-100" type="submit">Save Changes</button>
              </div>
              <hr class="my-4" />
            </form>
          </div>
        </div>
    </div>
  </div>
</div>



@endsection
