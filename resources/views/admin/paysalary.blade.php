@extends('layouts.admin_layout')
@section('content')

<!-- Salary Pay Area -->
  <div class="tdg_pay_salary mt--6">
    <div class="container-fluid">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach

      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0 text-center">Pay employee sallery : </h3>
            </div>

            <div class="table-responsive py-4">
              <table class="table table-flush text-center" id="datatable-buttons">
                <thead class="thead-light">
                  <tr>
                    <th width="20%">Name</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Salary </th>
                    <th>Due </th>
                    <th>State-<span class="text-info">({{ now()->format('M') }})</span></th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
               <?php $cout =1 ?>
                @foreach($user as $value)
                <?php $paid = 0;
                $due = 0;
                 ?>
                  <tr>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->designation }}</td>
                    <td>{{ $value->department }}</td>
                    <td>{{ $value->salary }}</td>
                    <td>
                        @foreach($salary as $salarys)
                            @if($salarys->user_ID == $value->id)
                                 <?php $paid = $paid + $salarys->amount ?>
                            @endif
                        @endforeach
                        <?php $due = $value->salary - $paid;
                        if($due>0){
                            echo $due;

                        }else{
                            echo "-";
                        }
                        ?>
                    </td>
                    <td>
                     @if($due == 0 )
                     <span class="text-success">Paid</span>
                     @elseif($due == $value->salary )
                     <span class="text-danger">Unpaid</span>
                     @else
                     <span class="text-info">Partially Paid</span>
                     @endif
                    </td>
                    <form method="POST" action="{{ route("admin.paysallaryIn",$value->id) }}">
                    @csrf
                    <td>
                      <input class="form-control" type="number" id="example-number-input<?php echo $cout; ?>" name="amount" min=0>
                      <script>

                      function check(){
                          var input = document.getElementById("example-number-input"+{!! $cout !!});
                         if(input.value >  {!! $due !!}){
                            $("#payin"+{!! $cout !!}). prop('disabled', true);
                         }else{
                            $("#payin"+{!! $cout !!}). prop('disabled', false);
                         }


                      }
                      //document.getElementById("example-number-input"+{!! $cout !!}).addEventListener("change",check);
                      document.getElementById("example-number-input"+{!! $cout !!}).addEventListener("keyup",check);
                      </script>
                    </td>
                    <td>
                      <button id="payin<?php echo $cout; ?>" class="btn btn-icon btn-primary" type="submit">
                        <span class="btn-inner--icon"><i class="ni ni-send"></i></span>
                      </button>
                    </td>
                    </form>
                  </tr>
                  <?php $cout++; ?>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
    <div class="text-right pb-5">
  {{-- <form action="{{ route("admin.payallsallary") }}" method="POST"> --}}
     {{-- @csrf --}}
        <button class="btn btn-icon btn-primary tdg_pay_btn" type="button" data-toggle="modal"  data-target="#paysallary" >
            <span class="btn-inner--icon"><i class="fas fa-wallet"></i></span>
            <span class="btn-inner--text"  >PAY ALL</span>
        </button>
     {{-- </form> --}}


    {{-- pay all salary modal  --}}
    <div class="modal fade" id="paysallary" tabindex="-1" role="dialog" aria-labelledby="examplemodal" aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered " role="document">
          <div class="modal-content bg-gradient-danger">
            <div class="modal-header">
              <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="py-3 text-center">
                <i class="fa-3x fas fa-wallet"></i>
                <h4 class="heading mt-4">Pay All Salary!</h4>
                <p>Are You Sure About this Action <br>This will add default salary for all the active members</p>
                <p> </p>
              </div>
            </div>
            <div class="modal-footer">
              <form action="{{ route("admin.payallsallary") }}" method="POST">
                 @csrf
                <button type="submit" class="btn btn-white">Yes,Sure </button>
               </form>
              <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
    </div>

    </div>
</div>

     {{-- <script src="{{ asset("assets/vendor/datatables.net/js/jquery.dataTables.min.js") }}"></script>
     <script src="{{ asset("assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js") }}"></script> --}}


  @endsection
