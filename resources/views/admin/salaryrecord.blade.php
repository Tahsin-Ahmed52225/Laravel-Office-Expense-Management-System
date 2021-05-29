@extends('layouts.admin_layout')
@section('content')

<div class="container-fluid mt--6">
    <!-- Table -->
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h3 class="mb-0 text-center">Datatable For Salary Records: </h3>
          </div>
          <div class="table-responsive py-4">
            <table class="table table-flush" id="datatable-basic">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th>Designation</th>
                  <th>Department</th>
                  <th>Amount</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($salary_Record as $item)

                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->designation }}</td>
                        <td>{{ $item->department }}</td>
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
