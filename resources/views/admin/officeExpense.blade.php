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
                        <div class="col-md-4" style=" height: 80vh; overflow: auto;">
                            <div class="card">
                            <!-- Card header -->
                            <div class="card-header">
                                <button type="button" class="btn btn-primary btn-lg w-50" data-toggle="modal" data-target="#expense-modal">ADD EXPENSE</button>

                                <!-- Modal -->
                                <div class="modal fade" id="expense-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Office Expence</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                        <form action="{{  route("admin.officeexpense") }}" method="POST">
                                        @csrf
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="example-text-input" class="form-control-label">Expense Details</label>
                                                            <input class="form-control" type="text"  id="example-text-input" name="expense_details" required>
                                                        </div>
                                                        <div class="form-row">

                                                            <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="example-date-input" class="form-control-label" >Date</label>
                                                                <input class="form-control" type="date" value="2018-11-23" name="date" id="example-date-input" required>
                                                            </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1" class="form-control-label">Remarks</label>
                                                                <select class="form-control" id="exampleFormControlSelect1" name="remarks">
                                                                @foreach($users as $item)
                                                                <option value={{ $item->name }} >{{ $item->name }}</option>
                                                                @endforeach
                                                                </select>
                                                            </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="example-text-input" class="form-control-label">Amount</label>
                                                            <input class="form-control" type="number"  id="example-text-input" name="amount" required>
                                                        </div>



                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" >Done</button>
                                                    </div>
                                            </form>
                                    </div>
                                </div>
                                </div>

                            </div>
                            <div class="table-responsive py-4">
                                <div class="container text-center">
                                <h2 class="card-title text-uppercase text-primary ml-2 mb-4">My Expense</h2>
                                </div>
                                <table class="table table-flush" id="datatable-basic">
                                <thead class="thead-light">
                                    <tr>
                                    <th>Expence Details</th>
                                    <th>Date</th>
                                    <th>Remarks</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myexpense as $item)
                                    <?php $count = 0; ?>
                                        <tr>
                                        <td> {{ $item->expense_details }} </td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->remarks }}</td>
                                        <td> &#2547; {{ $item->amount }}</td>
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
                                                <form autocomplete="off"  action="{{ route("admin.updateexpenseinfo" , $item->id) }}" method="POST"  >
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
                                                                    <form action="{{ route("admin.deleteexpenseinfo" , $item->id) }}" method="POST">
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

                        <div class="col-md-8" style=" height: 60vh; overflow: auto;">
                            <div class="card">
                            <!-- Card header -->
                            <div class="card-header text-center">
                                <h2 class="mb-0">All User Office Expence</h2>
                            </div>
                            <div class="table-responsive py-4">
                                <table class="table table-flush" id="datatable-basic">
                                <thead class="thead-light">
                                    <tr>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Expence Details</th>
                                    <th>Date</th>
                                    <th>Position</th>
                                    <th>Department</th>



                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($allexpense as $item)
                                    <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->expense_details }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->designation }}</td>
                                    <td>{{ $item->department }}</td>



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
