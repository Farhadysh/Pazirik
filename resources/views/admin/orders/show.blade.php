@extends('admin.master')

@section('content')
    @cannot('show-detail-orders')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('show-detail-orders')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">جزئیات سفارش</h4>
        </div>
        <div class="col-md-10 bg-white shadow-sm mx-auto">
            <div class="col-md-12 text-center text-dark p-3">
                <h6 class="font-weight-bold text-muted">جزئیات تغییر وضعیت ها</h6>
            </div>
            <div class="d-flex">
                <table class="table table-bordered rounded mt-2">
                    <thead>
                    <tr class="bg-info text-light text-center small">
                        <th>نام تغییر دهنده</th>
                        <th>تغییر وضعیت به</th>
                        <th>تاریخ تغییر وضعیت</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->ChangeStatuses as $change)
                        <tr class="text-center small">
                            <td>{{$change->user->name}}-{{$change->user->last_name}}</td>
                            <td class="text-{{$change->status['color']}}">{{$change->getOriginal('status') == 1 ? 'ثبت سفارش' : $change->status['title']}}</td>
                            <td>{{$change->date}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-10 shadow-sm bg-white mx-auto mt-2 mb-5">
            <div class="col-md-12 text-center p-3 text-dark">
                <h6 class="font-weight-bold text-muted">اطلاعات سفارش</h6>
            </div>


            <table class="table table-bordered rounded mt-2">
                <thead>
                <tr class="bg-info text-light text-center small">
                    <th>نوع فرش و اندازه</th>
                    <th>تعداد-متر</th>
                    <th>نقص</th>
                    <th>فی</th>
                    <th>اجرت کل</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->factor->factorProducts as $products)
                    <tr class="text-center">
                        <td>{{$products->product->name}}</td>
                        <td>{{$products->count}}</td>
                        <td>{{$products->defection ?? 'ندارد'}}</td>
                        <td>{{number_format($products->price)}}</td>
                        <td>{{number_format($products->price * $products->count)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <table class="table table-bordered rounded mt-2">
                <thead>
                <tr class="bg-info text-light text-center small">
                    <th>حمل و نقل</th>
                    <th>رفو،ریشه،سردوز،لکه گیری</th>
                    <th>جمع آوری فرشها و انتقال آنها از طبقات</th>
                    <th>تخفیف</th>

                </tr>
                </thead>
                <tbody>
                <tr class="text-center">
                    <td>{{number_format($order->factor->transport)}}</td>
                    <td>{{number_format($order->factor->service)}}</td>
                    <td>{{number_format($order->factor->collecting)}}</td>
                    <td>{{number_format($order->factor->discount)}}</td>
                </tr>
                </tbody>
            </table>
            <div class="col-md-12 text-left">
                <a href="{{route('admin.factors.show',['id'=>$order->factor->id])}}" class="btn btn-outline-dark btn-sm"
                   target="_blank"><i
                            class="fa fa-print"></i> نمایش فاکتور</a>
            </div>
        </div>
    @endcan
@endsection