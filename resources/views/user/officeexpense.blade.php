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
      <div class="col-md-8 offset-2">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#exampleModal">ADD OFFICE EXPENSE</button>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Office Expense  details :</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">
                  <form autocomplete="off" action="{{ route("user.officeexpense") }}" method="POST">
                  @csrf
                    <div class="row">
                      <div class="col-md">
                        <div class="form-group">
                          <label class="form-control-label" for="exampleFormControlInput1">Expense Details</label>
                          <input type="text" class="form-control" id="exampleFormControlInput1" name="expense_details" required >
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="form-group">
                          <label class="form-control-label" for="exampleFormControlSelect1">Remark</label>
                          <select class="form-control" id="exampleFormControlSelect1" name="remarks">
                            @foreach($users as $item)
                               <option value={{ $item->name }} >{{ $item->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md">
                        <div class="form-group">
                          <label class="form-control-label" for="exampleFormControlInput1">Date</label>
                          <input type="date" class="form-control" id="exampleFormControlInput1" placeholder="" name="date" required>
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="form-group">
                          <label class="form-control-label" for="exampleFormControlInput1">Amount</label>
                          <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="" name="amount" required>
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
            <h2 class="text-muted ml-4 mb-3">My office expense : </h2>
            <table class="table table-flush  text-center" id="datatable-basic">
              <thead class="thead-light">
                <tr>
                  <th>Office Details</th>
                  <th>Remarks</th>
                  <th>Date</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                @foreach ( $myexpense as $item )

                <tr>
                  <td>{{$item->expense_details	}}</td>
                  <td>{{ $item->remarks }}</td>
                  <td>{{ Carbon\Carbon::parse($item->date)->format('M d Y') }}</td>
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
</div>
@endsection
