@extends('layouts.admin_layout')
@section('content')


    <div class="container-fluid mt--6">
      <div class="card">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <p class="alert alert-{{ $msg }} ">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
        @endforeach
        <div class="card-body mx-auto">
          <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#exampleModal">Add Amount</button>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Amount</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{ route("admin.addamount") }}" method="POST">
                @csrf
                <div class="modal-body">

                  <div class="form-group">
                    <label for="example-number-input" class="form-control-label" >Amount</label>
                    <input class="form-control" type="number" placeholder="Enter your amount" id="example-number-input" name="amount" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1" class="form-control-label" >Description</label>
                    <textarea class="form-control" type="textarea"  placeholder="Enter Description"  id="exampleFormControlTextarea1" rows="2" name="description" required></textarea>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" >Add Amount</button>
                </div>
               </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <div class="card">
              <!-- Card header -->
              <div class="card-header">
                <h3 class="mb-0">Amount debited:</h3>
              </div>
              <div class="table-responsive py-4">
                <table class="table table-flush text-center" id="datatable-buttons">
                  <thead class="thead-light">
                    <tr >
                      <th>Description</th>
                      <th>Issue Date</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($Gain as $item)
                    <tr>
                        <td>  {{ $item->gain_details }}</td>
                        <td>{{ Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                        <td> &#2547; {{ $item->amount }}</td>
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
