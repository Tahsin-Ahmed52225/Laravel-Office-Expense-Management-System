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
                        <div class="col-md-4">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myexpense as $item)
                                        <tr>
                                        <td> {{ $item->expense_details }} </td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->remarks }}</td>
                                        <td> &#2547; {{ $item->amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                            </div>
                        </div>

                        <div class="col-md-8">
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
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Expence Details</th>
                                    <th>Remarks</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($allexpense as $item)
                                    <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->designation }}</td>
                                    <td>{{ $item->department }}</td>
                                    <td>{{ $item->expense_details }}</td>
                                    <td>{{ $item->remarks }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->amount }}</td>
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
