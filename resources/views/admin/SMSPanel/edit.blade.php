@extends('admin.master')

@section('content')
    @cannot('edit-Sms')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('edit-Sms')
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">ویرایش پیام ها</h4>
        </div>
        <div class="col-md-10 table-responsive mx-auto">
            <table class="table table-bordered rounded mt-2">
                <thead>
                <tr class="bg-info text-light text-center small">
                    <th>وضعیت</th>
                    <th>وضعیت ارسال</th>
                    <th>متن</th>
                    <th class="w-25">ادامه و ویرایش متن</th>
                </tr>
                </thead>
                <tbody>
                @foreach($smses as $sms)
                    <tr class="text-center small">
                        <td>{{$sms->title}}</td>
                        <td>
                            <label class="cl-switch">
                                <input class="check_status" type="checkbox" data-id="{{$sms->status}}"
                                        {{$sms->active == 1 ? 'checked' : ''}}>
                                <span class="switcher"></span>
                            </label>
                        </td>
                        <td></td>
                        <td>
                            <a href="" class="btn btn-outline-info btn-sm fa fa-eye"
                               data-toggle="modal" data-target="#myModal"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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