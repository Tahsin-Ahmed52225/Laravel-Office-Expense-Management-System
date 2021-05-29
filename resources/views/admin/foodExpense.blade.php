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
      <div class="col-lg-8 offset-lg-2">

        <div class="card">
          <!-- Card header -->
          <div class="card-header text-center">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#food-expense-modal">ADD EXPENSE</button>
          </div>
          <!-- Modal -->
            <div class="modal fade" id="food-expense-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Food Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="{{ route("admin.foodexpense") }}" method='POST'>
                    @csrf
                  <div class="modal-body">

                      <div class="form-group">
                        <label for="exampleFormControlTextarea1" class="form-control-label">Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" Placeholder="Message" rows="2" name="expense_details" required></textarea>
                      </div>

                      <div class="form-row">

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="example-date-input" class="form-control-label">Date</label>
                            <input class="form-control" type="date" name="date" id="example-date-input" required>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleFormControlSelect1" class="form-control-label">Remarks</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="remarks" required>
                                @foreach($users as $item)
                                <option value={{ $item->name }} >{{ $item->name }}</option>
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
            <h2 class="mb-0">Food Expence</h2>
          </div>
          <div class="table-responsive py-4">
            <table class="table table-flush" id="datatable-buttons">
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
