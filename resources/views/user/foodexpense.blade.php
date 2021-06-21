@extends('layouts.user_layout')
@section('content')

<div class="container-fluid mt--5">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <p class="alert alert-{{ $msg }} ">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
    @endforeach
    <!-- Table -->
    <div class="row">
      <div class="col-md-8 offset-2"style=" height: 60vh; overflow: auto;">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#exampleModal">ADD FOOD EXPENSE</button>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Food expense with details :</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">
                  <form action={{ route("user.foodexpense") }} method="POST" >
                  @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-control-label" for="exampleFormControlInput1">Items</label>
                          <textarea rows=3 type="text" class="form-control" id="exampleFormControlInput1" name="expense_details" required> </textarea>
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="form-group">
                          <label class="form-control-label" for="exampleFormControlSelect1">Remark</label>
                          <select class="form-control" id="exampleFormControlSelect1" name="remarks" disabled>

                                  <option>---</option>

                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md">
                        <div class="form-group">
                          <label class="form-control-label" for="exampleFormControlInput1">Date</label>
                          <input type="date" class="form-control" id="exampleFormControlInput1" name="date" placeholder="" required>
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="form-group">
                          <label class="form-control-label" for="exampleFormControlInput1">Amount</label>
                          <input type="number" class="form-control" id="exampleFormControlInput1" name="amount" placeholder="" required>
                        </div>
                      </div>
                    </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="table-responsive py-4 ">
            <h2 class="text-muted ml-4 mb-3">User Food Expense: </h2>
            <table class="table table-flush  text-center" id="datatable-basic">
              <thead class="thead-light">
                <tr>
                    <th>Expense Details</th>
                    <th>Remarks</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ( $myexpense as $item )

                <?php $count = 1; ?>
                    <tr>
                        <td>{{$item->expense_details	}}</td>
                        <td>{{ $item->remarks }}</td>
                        <td>{{ Carbon\Carbon::parse($item->date)->format('M d Y') }}</td>
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
                            <form autocomplete="off"  action="{{ route("user.updateexpenseinfo" , $item->id) }}" method="POST"  >
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
                                            <select class="form-control" id="exampleFormControlSelect1" name="remarks" disabled >
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
                                                <form action="{{ route("user.deleteexpenseinfo" , $item->id) }}" method="POST">
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
</div>






@endsection
