@extends('layouts.user_dashboard')
@section('content')

{{-- <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="alert alert-secondary alert-dismissible fade show" role="alert">
        <span class="alert-icon"><i class="ni ni-bell-55"></i></span>
        <span class="alert-text"><strong>Secondary!</strong> This is a secondary alert—check it out!</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
</div> --}}
<div class="row">
    <div class="col-xl-6 col-md-6">

      <div class="card card-stats<?php if($amount<=0) {echo ' bg-danger ';}?>">
        <!-- Card body -->
        <div class="card-body p-5">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0 <?php if($amount<=0) {echo ' text-light ';}?>">Available Balance</h5>
              <span class="h2 font-weight-bold mb-0 <?php if($amount<=0) {echo ' text-white ';}?>"> &#2547; {{ $amount }}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                <i class="ni ni-money-coins"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-6 col-md-6">
      <div class="card card-stats">
        <!-- Card body -->
        <div class="card-body p-5">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Monthly Expense</h5>
              <span class="h2 font-weight-bold mb-0"> &#2547;{{  $expense }}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                <i class="ni ni-chart-pie-35"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<!-- Page content -->
<div class="container-fluid mt--6">
<div class="row">
<!-- Timeline notification start -->
<div class="col-md">
  <div class="card">
    <!-- Card header -->
    <div class="card-header">
      <!-- Title -->
      <div class="row">
          <div class="col-12">
             <h5 class="h3 mb-0">Latest notifications</h5>
          </div>

      </div>
    </div>
    <!-- Card body -->
    <div class="card-body">
      <div class="timeline timeline-one-side " data-timeline-content="axis" data-timeline-axis-style="dashed">
        <!-- notification single block content start -->
        @foreach ($notification as $item)
        <div class="timeline-block ">
            <span class="timeline-step badge-info">
              <i class="ni ni-bell-55"></i>
            </span>
            <div class="timeline-content">
              <div class="d-flex justify-content-between pt-1">
                <div>
                  <span class="text-sm font-weight-bold<?php if($item->type == 1) echo " text-success"; else  echo " text-danger";?>">{{ $item->notification }}</span>
                </div>
                <div class="text-right">
                  <small class="text-muted"><i class="fas fa-clock mr-1"></i>
                    <?php
                    $to = now();
                    $from = $item->created_at;
                    $diff_in_days = $to->diffInDays($from);
                    $diff_in_hours = $to->diffInHours($from);
                    if($diff_in_days > 0){
                    echo($diff_in_days." days ago");
                    }elseif($diff_in_hours > 0){
                    echo($diff_in_hours." hours ago");
                    }else{
                        $diffInMinutes = $to->diffInMinutes($from);
                        echo($diffInMinutes." mins ago");
                    }
                     ?>


                   </small>
                </div>
              </div>
              <h6 class="text-sm mt-1 mb-0">{{ $item->name}} had a expense of  &#2547;{{ $item->amount }}</h6>
            </div>
          </div>
        @endforeach

        <!-- notification single block content end -->


      </div>
    </div>
  </div>
</div>
<!-- Timeline notification end -->


<!-- timeline to-do List start -->
<div class="col-md">
  <!-- Checklist -->
  <div class="card">
    <!-- Card header -->
    <div class="card-header">
      <!-- Title -->
      <h5 class="h3 mb-0">To do list</h5>
    </div>
    <!-- Card body -->
    <div class="card-body p-0">
      <!-- List group -->
      <ul class="list-group list-group-flush" data-toggle="checklist">
        <li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
          <div class="checklist-item checklist-item-success">
            <div class="checklist-info">
              <h5 class="checklist-title mb-0">Call with Dave</h5>
              <small>10:30 AM</small>
            </div>
            <div>
              <div class="custom-control custom-checkbox custom-checkbox-success">
                <input class="custom-control-input" id="chk-todo-task-1" type="checkbox" checked>
                <label class="custom-control-label" for="chk-todo-task-1"></label>
              </div>
            </div>
          </div>
        </li>
        <li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
          <div class="checklist-item checklist-item-warning">
            <div class="checklist-info">
              <h5 class="checklist-title mb-0">Lunch meeting</h5>
              <small>10:30 AM</small>
            </div>
            <div>
              <div class="custom-control custom-checkbox custom-checkbox-warning">
                <input class="custom-control-input" id="chk-todo-task-2" type="checkbox">
                <label class="custom-control-label" for="chk-todo-task-2"></label>
              </div>
            </div>
          </div>
        </li>
        <li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
          <div class="checklist-item checklist-item-info">
            <div class="checklist-info">
              <h5 class="checklist-title mb-0">Argon Dashboard Launch</h5>
              <small>10:30 AM</small>
            </div>
            <div>
              <div class="custom-control custom-checkbox custom-checkbox-info">
                <input class="custom-control-input" id="chk-todo-task-3" type="checkbox">
                <label class="custom-control-label" for="chk-todo-task-3"></label>
              </div>
            </div>
          </div>
        </li>
        <li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
          <div class="checklist-item checklist-item-danger">
            <div class="checklist-info">
              <h5 class="checklist-title mb-0">Winter Hackaton</h5>
              <small>10:30 AM</small>
            </div>
            <div>
              <div class="custom-control custom-checkbox custom-checkbox-danger">
                <input class="custom-control-input" id="chk-todo-task-4" type="checkbox" checked>
                <label class="custom-control-label" for="chk-todo-task-4"></label>
              </div>
            </div>
          </div>
        </li>
        <li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
          <div class="checklist-item checklist-item-success">
            <div class="checklist-info">
              <h5 class="checklist-title mb-0">Dinner with Family</h5>
              <small>10:30 AM</small>
            </div>
            <div>
              <div class="custom-control custom-checkbox custom-checkbox-success">
                <input class="custom-control-input" id="chk-todo-task-5" type="checkbox" checked>
                <label class="custom-control-label" for="chk-todo-task-5"></label>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>
<!-- timeline to-do List end -->
</div>
</div>
@endsection
