@extends('admin.master')

@section('content')
    @cannot('show-customers')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('detail-customer')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">مشخصات مشتری</h4>
        </div>
        <div class="col-md-10 bg-white shadow-sm mx-auto">
            <div class="d-flex">
                <div class="col-md-4 py-4">
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item border-0 font-weight-bold px-0">نام:</li>
                        <li class="list-group-item border-0 px-2">{{$user->name}}</li>
                    </ul>
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item border-0 font-weight-bold px-0">نام خانوادگی:</li>
                        <li class="list-group-item border-0 px-2">{{$user->last_name}}</li>
                    </ul>
                </div>
                <div class="col-md-4 py-4">
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item border-0 font-weight-bold px-0">تلفن ثابت:</li>
                        <li class="list-group-item border-0 px-2">{{$user->phone}}</li>
                    </ul>
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item border-0 font-weight-bold px-0">شماره موبایل:</li>
                        <li class="list-group-item border-0 px-2">{{$user->mobile}}</li>
                    </ul>
                </div>
                <div class="col-md-4 py-4">
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item border-0 font-weight-bold px-0">وضعیت:</li>
                        <li class="list-group-item border-0 px-2">{{$user->level}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-10 bg-white shadow-sm mx-auto mt-2">
            <div class="col-md-12 text-center text-dark">
                <h6 class="font-weight-bold my-4 text-muted">آدرس ها</h6>
            </div>
            <div class="row">
                @foreach($user->addresses as $address)
                    <table class="table table-bordered col-md-5 mx-4 my-3">
                        <tr>
                            <th class="w-25 small">شاخص آدرس</th>
                            <th class="small">{{$address->address_index}}</th>
                        </tr>
                        <tr>
                            <th class="w-25 small">آدرس</th>
                            <th class="small">{{$address->address}}</th>
                        </tr>
                    </table>
                @endforeach
            </div>
        </div>
        <div class="col-md-10 shadow-sm bg-white mx-auto mt-2 mb-5">
            <div class="col-md-12 text-center text-dark">
                <h6 class="font-weight-bold my-4 text-muted">فاکتور ها</h6>
            </div>
            <div>
                <table class="table table-bordered text-center">
                    <thead>
                    <tr class="bg-info text-white small">
                        <th>کد سفارش</th>
                        <th>راننده</th>
                        <th>تاریخ ثبت سفارش</th>
                        <th>وضعیت</th>
                        <th>تنظیمات</th>
                    </tr>
                    </thead>
                    @foreach($orders as $order)
                        <tbody>
                        <tr class="small">
                            <td>{{$order->id}}</td>
                            @if($order->driver)
                                <td>{{$order->driver->name}} {{$order->driver->last_name}}</td>
                            @else
                                <td>فاکتور دستی</td>
                            @endif
                            <td>{{$order->created_at}}</td>
                            <td class="text-{{$order->status['color']}}">{{$order->status['title']}}</td>
                            <td>
                                @if($order->factor)
                                    <a href="{{route('admin.factors.show',['id'=>$order->factor->id])}}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-dark fa fa-print font-weight-bold text-dark"
                                       title="نمایش فاکتور"></a>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
                <div class="d-flex justify-content-center mr-n5">
                    {{$orders->links()}}
                </div>
            </div>
        </div>
    @endcan
@endsection