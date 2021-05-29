@extends('layouts.admin_layout')
@section('content')

  <!-- Page content -->
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <div class="card-wrapper">
          <!-- Custom form validation -->
          <div class="card">

            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0 text-center">Add a New Member</h3>
            </div>
             @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                @if(Session::has('alert-' . $msg))
                                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                @endif
             @endforeach
             @if ($errors->any())

                            @foreach ($errors->all() as $error)
                                  <p class="alert alert-warning"> {{ $error }}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>

                            @endforeach

            @endif
            <!-- Card body -->
            <div class="card-body">
              <form autocomplete="off" class="needs-validation" method="POST" action={{ route("admin.addmember") }}>
                @csrf
                <div class="form-row">
                  <div class="col-md-6 mb-3">
                    <label class="form-control-label" for="validationCustom01">Member Name :</label>
                    <input type="text" class="form-control" id="validationCustom01" placeholder="Name.." value="" name="m_name" required>
                    <div class="valid-feedback">
                      Looks good!
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-control-label" for="validationCustom02">Member Email : </label>
                    <input type="email" class="form-control" id="validationCustom02" placeholder="Enter Email.." value="" name=m_email required>
                    <div class="valid-feedback">
                      Please Enter Email.
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-control-label" for="validationCustomUsername">Phone Number : </label>
                    <input type="tel" class="form-control" id="validationCustomUsername" placeholder="Contact Number.." aria-describedby="inputGroupPrepend" name="m_num" required>
                    <div class="invalid-feedback">
                      Please Enter Number.
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-control-label" for="validationCustomUsername">Department : </label>
                        <div class="form-group">
                          <select class="form-control" id="exampleFormControlSelect1" name="m_department">
                            <option selected disabled>Select Department..</option>
                            <option value="Web Development">Web Development</option>
                            <option value="Graphices Design">Graphices Design</option>
                            <option value="Content & Marketing">Content & Manageing </option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="validationCustomUsername">Position : </label>
                        <div class="form-group">
                          <select class="form-control" id="exampleFormControlSelect1" name="m_positon">
                            <option selected disabled>Select Position..</option>
                            <option>Jr. Web Developer</option>
                            <option>Jr. Designer</option>
                            <option>Jr. Frontend Developer</option>
                            <option>Jr. Content Writer</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="validationCustomeSalary">Salary : </label>
                        <input type="number" class="form-control" id="validationCustomeSalary" placeholder="Add Salary Ammount" aria-describedby="inputGroupPrepend" name="m_sal" required>
                        <div class="invalid-feedback">
                          Please Enter Salary Amount
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="validationCustomUsername">Create Member password</label>
                        <input type="password" class="form-control" id="validationCustomUsername" placeholder="Please Enter password" aria-describedby="inputGroupPrepend" required name="m_passoword">
                        <div class="invalid-feedback">
                            Please Enter password
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-center justify-content-center">
                        <div class="custom-control custom-radio ">
                            <input  class="custom-control-input" id="customRadio5" type="radio" name="m_stage" value='1'>
                            <label class="custom-control-label" for="customRadio5">Enable</label>
                        </div>
                        <div class="custom-control custom-radio ml-3">
                            <input class="custom-control-input" id="customRadio6"  type="radio"  name="m_stage" value='0' >
                            <label class="custom-control-label" for="customRadio6">Disable</label>
                        </div>
                    </div>
                </div>
                <div class="form_btn">
                  <button class="btn btn-primary w-100" type="submit">Add Member</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





@endsection
