@extends('admin.master')

@section('content')
    @cannot('SMS')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('SMS')
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">لیست پیام ها</h4>
        </div>
        <div class="col-md-10 table-responsive mx-auto">
            <table class="table table-bordered rounded mt-2">
                <thead>
                <tr class="bg-info text-light text-center small">
                    <th>تاریخ پیام</th>
                    <th>شماره موبایل</th>
                    <th>متن</th>
                    <th>ادامه متن</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-center small">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <a href="" class="btn btn-outline-info btn-sm fa fa-eye"
                           data-toggle="modal" data-target="#myModal"></a>
                    </td>
                </tr>
                </tbody>
            </table>
            {{--<div class="col-md-12 mx-auto text-center" >
                @if($shifts_count == 0)
                    <h5 class="text-danger"> موردی یافت نشد!</h5>
                @else
                    <h6 class="text-danger float-left">{{$shifts_count}} مورد یافت شد</h6>
                @endif
            </div>
            <div class="d-flex justify-content-center mr-n5">
                {{$shifts->links()}}
            </div>--}}


            <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">متن کامل پیام</h4>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            Modal body..
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection