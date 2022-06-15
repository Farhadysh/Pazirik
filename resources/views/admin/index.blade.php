@extends('admin.master')

@section('content')
    <div class="col-md-12 bg-white p-2">

        <div class="row col-md-12 mr-1">
            <div class="col-md-4 bg-light text-center my-1 p-4 border shadow-sm">
                <h2 class="text-muted mx-auto py-5">New Orders</h2>
            </div>
            <div id="data_chart" data-countuser="{{$user_count}}" data-counttrans="{{$Transmitted}}" class="col-md-8 bg-light text-center my-1 p-4 border shadow-sm">
                <canvas id="myChart" width="400" height="100"></canvas>
            </div>
        </div>

        <div class="row col-md-12 mr-1">
            <div class="col-md-8 bg-light text-center my-1 p-5 border shadow-sm">
                <h3 class="text-info">Shortcuts</h3>
            </div>
            <div class="col-md-4 bg-light text-center my-1 p-5 border shadow-sm">
                <h3 class="text-warning">Information</h3>
            </div>
        </div>
        <div class="row col-md-12 mr-1">
            <div class="col-md-5 bg-light text-center my-1 p-5 border shadow-sm">
                <h3 class="text-danger">Alarm</h3>
            </div>
            <div class="col-md-7 bg-light text-center my-1 p-5 border shadow-sm">
                <h3 class="text-primary">Details</h3>
            </div>
        </div>
        <div class="row col-md-12 mr-1">
            <div class="col-md-7 bg-light text-center my-1 p-5 border shadow-sm">
                <h3 class="text-muted">Chart 2</h3>
            </div>
            <div class="col-md-5 bg-light text-center my-1 p-5 border shadow-sm">
                <h3 class="text-muted">Chart 3</h3>
            </div>
        </div>

    </div>
@endsection