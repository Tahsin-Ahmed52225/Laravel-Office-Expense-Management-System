@extends('layouts.admin_layout')
@section('content')

    <!-- All Members Data -->
    <div class="tdg_all_members_data mt--6">
        <div class="container-fluid">
          <!-- Table -->
          <div class="row">
            <div class="col" style=" height: 80vh; overflow: auto;">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
                @endforeach
              <div class="card">
                <!-- Card header -->
                <div class="card-header">
                  <h3 class="mb-0">All Members</h3>
                </div>

                <div class="table-responsive py-4">
                  <table class="table table-flush" id="datatable-buttons">
                    <!-- Table Head -->
                    <thead class="thead-light">
                      <tr>
                        <th width="20%">Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Salary</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
        <?php $cout=1; ?>
        @foreach($user as $users)
                      <tr>
                        <td>{{ $users->name }}</td>
                        <td>{{ $users->department }}</td>
                        <td>{{ $users->designation }}</td>
                        <td>{{ $users->email }}</td>
                        <td>{{ $users->number }}</td>
                        <td>{{ $users->salary }}</td>
                        <td>
                          <div class="input-group">
                            <div class="input-group-prepend" id="button-addon3">

                                 @if($users->stage == 0)
                                    <button id="lock1"class="btn btn-icon btn-warning" type="button" data-toggle="modal"  data-target="#enable-member<?php echo $cout;?>" onclick="sendclick(event)">
                                        <span class="btn-inner--icon"><i id="lock1icon" class="fas fa-lock"></i></span>
                                    </button>
                                @else
                                    <button id="lock2" class="btn btn-icon btn-success" type="button" data-toggle="modal"  data-target="#disable-member<?php echo $cout;?>" onclick="sendclick(event)">
                                        <span class="btn-inner--icon"><i id="lock2icon" class="fas fa-unlock"></i></span>
                                    </button>
                                @endif
                                  <button class="btn btn-icon btn-primary" type="button" data-toggle="modal" data-target="#edit-member<?php echo $cout;?>">
                                    <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                                  </button>
                                  <button class="btn btn-icon btn-danger" type="button" data-toggle="modal" data-target="#delete-member<?php echo $cout;?>">
                                    <span class="btn-inner--icon"><i class="fas fa-trash"></i></span>
                                  </button>

                            </div>
                          </div>

                          <!--Edit Member Modal -->
                          <div class="modal fade" id="edit-member<?php echo $cout;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Edit Member</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>

                                <div class="modal-body">
                                  <form autocomplete="off"  action="{{ route('admin.updateinfo', $users->id) }}" method="POST"  >
                                    @csrf
                                    <div class="form-row">
                                      <div class="col-md-6 mb-3">
                                        <label class="form-control-label" for="validationCustom01">Member Name :</label>
                                        <input type="text" class="form-control" id="validationCustom01" placeholder="{{ $users->name }}" name="name" autocomplete="off" >

                                      </div>
                                      <div class="col-md-6 mb-3">
                                        <label class="form-control-label" for="validationCustom02">Member Email : </label>
                                        <input type="email" class="form-control" id="validationCustom02" placeholder="{{ $users->email }}" name="email" autocomplete="off" >
                                      </div>
                                      <div class="col-md-6 mb-3">
                                        <label class="form-control-label" for="validationCustomUsername">Phone Number : </label>
                                        <input type="tel" class="form-control" id="validationCustomUsername" placeholder="{{ $users->number }}" name="number" autocomplete="off">
                                      </div>
                                      <div class="col-md-6">
                                        <label class="form-control-label" for="validationCustomUsername">Department : </label>
                                        {{-- <div class=""> --}}
                                            <div class="form-group">
                                                <select class="form-control" id="exampleFormControlSelect1" name="department">
                                                    <option selected disabled>Select Department..</option>
                                                    <option value="Web Development">Web Development</option>
                                                    <option value="Graphices Design">Graphices Design</option>
                                                    <option value="Content & Marketing">Content & Manageing </option>
                                                  </select>
                                            </div>
                                        {{-- </div> --}}
                                      </div>
                                      <div class="col-md-6 mb-3">
                                        <label class="form-control-label" for="validationCustomUsername">Position : </label>
                                     {{-- <div class=""> --}}
                                            <div class="form-group">
                                                <select class="form-control" id="exampleFormControlSelect1" name="positon">
                                                    <option selected disabled>Select Position..</option>
                                                    <option>Jr. Web Developer</option>
                                                    <option>Jr. Designer</option>
                                                    <option>Jr. Frontend Developer</option>
                                                    <option>Jr. Content Writer</option>
                                                  </select>
                                            {{-- </div> --}}
                                        </div>
                                      </div>

                                      <div class="col-md-6 mb-3">
                                        <label class="form-control-label" for="validationCustomeSalary">Salary : </label>
                                        <input type="number" class="form-control" id="validationCustomeSalary" placeholder="{{ $users->salary }}" name="salary" autocomplete="off">
                                       </div>

                                      <div class="col-md-6 mb-3">
                                        <label class="form-control-label" for="validationCustomUsername">Change password</label>
                                        <input type="password" class="form-control" id="validationCustomUsername" placeholder="Please Enter password" name="password" autocomplete="off">
                                      </div>


                                    </div>

                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary" >Save changes</button>
                                </div>
                            </form>
                              </div>
                            </div>
                          </div>
                    @if($users->stage == 1)
                         {{-- Disable Modal --}}
                          <div class="modal fade" id="disable-member<?php echo $cout;?>" tabindex="-1" role="dialog" aria-labelledby="delete-member" aria-hidden="true">
                            <div class="modal-dialog modal-warning modal-dialog-centered modal-" role="document">
                              <div class="modal-content bg-gradient-warning">
                                <div class="modal-header">
                                  <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="py-3 text-center">
                                    <i class="fa-3x fas fa-lock"></i>
                                    <h4 class="heading mt-4">You should read this!</h4>
                                    <p>Are You Sure To disable The Member? <br>This will disable all functionalites of this member</p>
                                    <p> </p>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-white" data-user="{{ $users->id }}"  id="DeleteButton" onclick="changeStage(this.getAttribute('data-user'))" data-dismiss="modal">Ok, Disable</button>
                                  <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Cancel</button>
                                </div>
                              </div>
                            </div>
                          </div>
                @else
                         {{-- Enable modal --}}
                          <div class="modal fade" id="enable-member<?php echo $cout;?>" tabindex="-1" role="dialog" aria-labelledby="enable-member" aria-hidden="true">
                            <div class="modal-dialog modal-success modal-dialog-centered modal-" role="document">
                              <div class="modal-content bg-gradient-success">
                                <div class="modal-header">
                                  <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="py-3 text-center">
                                    <i class="fa-3x fas fa-lock"></i>
                                    <h4 class="heading mt-4">You should read this!</h4>
                                    <p>Are You Sure To enable The Member? <br>This will enable all functionalites of this member</p>
                                    <p> </p>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-white" id="DeleteButton" data-user="{{ $users->id }}"  onclick="changeStage(this.getAttribute('data-user'))"data-dismiss="modal">Ok, Enable</button>
                                  <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Cancel</button>
                                </div>
                              </div>
                            </div>
                          </div>
                @endif
                {{-- Delete member modal --}}
                <div class="modal fade" id="delete-member<?php echo $cout;?>" tabindex="-1" role="dialog" aria-labelledby="delete-member" aria-hidden="true">
                    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                      <div class="modal-content bg-gradient-danger">
                        <div class="modal-header">
                          <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="py-3 text-center">
                            <i class="fa-3x fas fa-trash"></i>
                            <h4 class="heading mt-4">You should read this!</h4>
                            <p>Are You Sure To delete <b style="font-size:18px; font-weight:600;"> <u>{{ $users->name }}</u></b> account ? <br>This will delete all records and transectios of this member</p>
                            <p> </p>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <form action="{{ route("admin.deletemember", $users->id) }}" method="POST">
                          @csrf
                            <button type="submit" class="btn btn-white"  id="DeleteButton" >Ok, Delete</button>
                          </form>

                          <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                    </div>
                  </div>
                        </td>
                      </tr>
                      <script>
                        var button = null;
                        function sendclick(e){
                            console.log(e);
                            button = e.target.id;
                            //alert(button);
                        }
                        function changeStage(data){
                                        var id = data
                                        $.ajax({
                                            headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },

                                    type: 'POST',
                                    url: '/admin/changeStage',
                                    data: {
                                    'id':id,
                                    },
                                    success: function () {
                                        location.reload(true);
                                    },
                                    error: function (data, textStatus, errorThrown) {
                                        console.log("Error:".errorThrown);
                                        console.log(data);


                                    },
                                })
                          }





                      </script>

       <?php  $cout++;?>
        @endforeach


                    </tbody>
                    </table>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
@endsection

