@extends('layouts.admin_layout')
@section('content')
<div class="container-fluid mt--6">
    <!-- Table -->
    <div class="row">
      <div class="col" style=" height: 80vh; overflow: auto;">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
              <div class="row">
                  <div class="col-12">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                @if(Session::has('alert-' . $msg))
                                    <p class="alert alert-{{ $msg }} ">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                @endif
                    @endforeach
                    <h3 class="mb-0 text-center">Datatable For Salary Records: </h3>
                  </div>
              </div>

                <div class="row pt-4 ">
                    <div class="col-3 d-flex justify-content-end">
                        <div class="dropdown">
                          <select id="sort" class="form-control" onchange="sortform()">
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                          </select>

                        </div>
                    </div>
                    <div class="col-6">
                        <form id="monthly" target="_blank" name="yearly2" method="POST" action="{{ route("admin.SalaryPDFrecordM") }}">
                        @csrf
                            <div class="row ">
                              <div class="col">
                                  <select class="form-control" id="monthly_month" name="month">
                                    <option value='01'>January</option>
                                    <option value='02'>February</option>
                                    <option value='03'>March</option>
                                    <option value='04'>April</option>
                                    <option value='05'>May</option>
                                    <option value='06'>June</option>
                                    <option value='07'>July</option>
                                    <option value='08'>August</option>
                                    <option value='09'>September</option>
                                    <option value='10'>October</option>
                                    <option value='11'>November</option>
                                    <option value='12'>December  </option>
                                  </select>

                              </div>
                              <div class="col">
                                <select class="form-control" id="monthly_year" name="myear">
                                    <option value='2024'>2024</option>
                                    <option value='2023'>2023</option>
                                    <option value='2022'>2022</option>
                                    <option value='2021'>2021</option>
                                </select>
                              </div>
                            </div>
                          </form>

                          <form id="yearly" target="_blank" name="yearly1" style="display: none;" method="POST" action="{{ route("admin.SalaryPDFrecord") }}">
                          @csrf
                            <div class="row ">

                              <div class="col">
                                <select id="yearly_year"class="form-control" name="year">
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                </select>
                              </div>
                            </div>
                          </form>

                    </div>
                    <div class="col-2">
                       <div class="">
                          <i type="submit" onclick="download_pdf()"  class="fas fa-file-pdf fa-2x m-2"   title="Download PDF"></i>
                          <i type="submit" class="fas fa-file-csv fa-2x m-2" onclick="download_csv()"title="Download CSV"></i>
                       </div>

                    </div>
                </div>

                <script>

                  function sortform(){
                    var x = document.getElementById("sort").value;
                    if(x == "monthly"){
                      document.getElementById("monthly").style.display = "block";
                      document.getElementById("yearly").style.display = "none";
                    }else{
                      document.getElementById("monthly").style.display = "none";
                      document.getElementById("yearly").style.display = "block";
                    }
                  }
                  function download_pdf(){
                      var x = document.getElementById("sort").value;
                    if(x == "yearly"){
                        $("#yearly").attr("action", '{!! route("admin.SalaryPDFrecord") !!}' );
                        document.yearly1.submit();
                    }
                   else if(x == "monthly"){
                    $("#monthly").attr("action", '{!! route("admin.SalaryPDFrecordM") !!}' );
                        document.yearly2.submit();
                    }
                  }
                  function download_csv(){
                    var x = document.getElementById("sort").value;
                    if(x == "yearly"){
                      //  var hello = document.getElementById("yearly").getAttribute("action");
                        $("#yearly").attr("action", '{!! route("admin.SalaryCSVrecord") !!}' );
                        document.yearly1.submit();
                    }
                   else if(x == "monthly"){
                        $("#monthly").attr("action", '{!! route("admin.SalaryCSVrecordM") !!}' );
                        document.yearly2.submit();
                    }
                  }
               </script>



          </div>
          <div class="table-responsive py-4">
            <table class="table table-flush" id="datatable-basic">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th>Designation</th>
                  <th>Department</th>
                  <th>Category</th>
                  <th>Amount</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
              <?php $count = 1 ?>
              @foreach ($transaction_Record as $item)

                    <tr class="<?php if ($item->type == 0) echo "text-danger"; else echo "text-success"?>">
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->designation }}</td>
                        <td>{{ $item->department }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y') }}</td>
                    </tr>
              @endforeach

              </tbody>
            </table>
          </div>
        </div>
    </div>
  </div>
</div>


@endsection
