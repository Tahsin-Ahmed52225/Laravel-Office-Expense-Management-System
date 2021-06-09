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
        <div class="col-md-8 offset-md-2" style=" height: 60vh; overflow: auto;">
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
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $count=1; ?>
                    @foreach ($Gain as $item)
                    <tr>
                        <td>  {{ $item->gain_details }}</td>
                        <td>{{ Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                        <td> &#2547; {{ $item->amount }}</td>
                        <td>
                              <button class="btn btn-icon btn-primary" type="button" data-toggle="modal" data-target="#edit-member<?php echo $count;?>">
                                <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                              </button>
                              <button class="btn btn-icon btn-danger" type="button" data-toggle="modal" data-target="#delete-gain<?php echo $count;?>">
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
                                            <form autocomplete="off"  action="{{ route("admin.updategaininfo", $item->id)}}" method="POST"  >
                                                @csrf
                                                <div class="form-row">


                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-control-label" for="validationCustomUsername">Update Description</label>
                                                        <textarea  class="form-control" id="validationCustomUsername" placeholder="{{ $item->gain_details }}" name="gain_description" autocomplete="off"></textarea>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-control-label" for="validationCustomUsername">Update Amount</label>
                                                        <input type="number" class="form-control" id="validationCustomUsername" placeholder="{{ $item->amount }}" name="gain_amount" autocomplete="off">
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

            {{-- Delete transection Modal --}}
             <div class="modal fade" id="delete-gain<?php echo $count;?>" tabindex="-1" role="dialog" aria-labelledby="delete-gain" aria-hidden="true">
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
                        <p>Are you sure to remove <b style="font-size:18px; font-weight:600;"> <u>{{ $item->amount }}</u></b> record ? <br>This will delete transaction history of this amount</p>
                        <p> </p>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <form action="{{ route("admin.deletegaininfo", $item->transection_id) }}" method="POST">
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
