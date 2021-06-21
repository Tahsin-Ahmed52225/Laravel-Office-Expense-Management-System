@extends('layouts.user_layout')
@section('content')

<div class="container-fluid mt--6">
    <!-- Table -->
    <div class="row">
      <div class="col" style="height: 80vh; overflow: auto;">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h3 class="mb-0 text-center"> My Salary Records: </h3>
          </div>
          <div class="table-responsive py-4">
            <table class="table table-flush" id="datatable-basic">
              <thead class="thead-light">
                <tr>
                  <th>Amount</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($salary as $item)
                <tr>
                  <td> &#2547; {{ $item->amount }}</td>
                  <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y') }} </td>
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
