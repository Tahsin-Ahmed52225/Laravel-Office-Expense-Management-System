@extends('layouts.admin_layout')
@section('content')
<div class="container-fluid mt--6">
@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))
        <p class="alert alert-{{ $msg }} ">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
@endforeach
    <!-- Table -->
    <div class="row">
      <div class="col-lg-8 offset-lg-2" style=" height: 80vh; overflow: auto;">

        <div class="card">
          <!-- Card header -->
          <div class="card-header text-center">
            <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#food-expense-modal" onclick="lend()">LEND</button>
            <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#food-expense-modal" onclick="receive()">RECEIVE</button>
          </div>
          <script>
            function lend(){
                $("#advanceForm").attr("action", '{!! route("admin.advance") !!}' );
            }
            function receive(){
                $("#advanceForm").attr("action", '{!! route("admin.receive") !!}' );
            }
        </script>
          <!-- Modal -->
            <div class="modal fade" id="food-expense-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lend Advance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form id="advanceForm" action="{{ route("admin.advance") }}" method='POST'>
                    @csrf
                  <div class="modal-body">
                      <div class="form-row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="exampleFormControlSelect1" class="form-control-label">Name</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="remarks" required>
                                @foreach($users as $item)
                                <option value={{ $item->id }} >{{ $item->name }}</option>
                                @endforeach
                            </select>

                          </div>
                        </div>

                      </div>

                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Amount</label>
                        <input class="form-control" type="number" name="amount" id="example-text-input" required>
                      </div>



                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Done</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
        </div>

        <div class="card">
          <!-- Card header -->
          <div class="card-header text-center">
            <h2 class="mb-0">Advance Record</h2>
          </div>
          <div class="table-responsive py-4">
            <table class="table table-flush" id="datatable-buttons">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($allexpense as $item)
                <?php $count = 1; ?>
                <tr class="<?php if ($item->type == 0) echo "text-danger"; else echo "text-success"?>">
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->designation }}</td>
                  <td>{{ Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                  <td>{{ $item->amount }}</td>
                  <td>
                      <button class="btn btn-icon btn-primary" type="button" data-toggle="modal" data-target="#edit-member<?php echo $count;?>">
                        <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                      </button>
                      <button class="btn btn-icon btn-danger" type="button" data-toggle="modal" data-target="#delete-food<?php echo $count;?>">
                        <span class="btn-inner--icon"><i class="fas fa-trash"></i></span>
                      </button>
                  </td>
                </tr>
             {{-- Edit record --}}
             <div class="modal fade" id="edit-member<?php echo $count;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>

                    <div class="modal-body">
                    <form autocomplete="off"  action="{{ route("admin.updatefoodexpenseinfo" , $item->id) }}" method="POST"  >
                        @csrf
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="exampleFormControlTextarea1" class="form-control-label">Description</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1"  rows="2" name="expense_details" placeholder="{{ $item->expense_details }}" ></textarea>
                                </div>

                              </div>

                              <div class="form-row">

                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="example-date-input" class="form-control-label">Date</label>
                                    <input class="form-control" type="date" name="date" id="example-date-input" >
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="exampleFormControlSelect1" class="form-control-label">Remarks</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="remarks" >
                                        @foreach($users as $items)
                                        <option value={{ $items->name }} >{{ $items->name }}</option>
                                        @endforeach
                                    </select>

                                  </div>
                                </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Amount</label>
                                    <input class="form-control" type="number" name="amount" id="example-text-input" placeholder="{{ $item->amount }}" >
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
        </div>

                    {{-- Delete transection Modal --}}
                    <div class="modal fade" id="delete-food<?php echo $count;?>" tabindex="-1" role="dialog" aria-labelledby="delete-food" aria-hidden="true">
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
                                        <p>Are you sure to delete <b style="font-size:18px; font-weight:600;"> <u>{{ $item->amount }}</u></b> record ? <br>This will delete transaction history of this amount</p>
                                        <p> </p>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                        <form action="{{ route("admin.deletefoodexpenseinfo" , $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-white"  id="DeleteButton" >Ok, Delete</button>
                                        </form>

                                        <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                    </div>
            <?php $count++; ?>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    </div>

@endsection
