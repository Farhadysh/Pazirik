@extends('admin.master')

@section('content')
    @cannot('show-handFactor')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('show-handFactor')
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">لیست فاکتور دستی ها</h4>
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <a id="btn_search" class="btn btn-outline-warning cursor-pointer fa fa-search mr-3"></a>
            </div>
            <div class="col-md-6 mx-auto pl-5 text-left">
                <a href="{{route('admin.factors.factorExcel')}}" class="btn btn-outline-info cursor-pointer btn-sm">دریافت فایل اکسل</a>
            </div>
        </div>
        <div id="div_search" class="col-md-12 mx-auto">
            <form action="{{route('admin.factors.search')}}"
                  class="border-0 rounded p-2 mt-3 form-row" method="get">
                <div class="form-group col-md-2">
                    <label for="last_name">نام خانوادگی</label>
                    <input type="text" class="form-control font-small" id="last_name" name="last_name"
                           placeholder="نام خانوادگی">
                </div>
                <div class="form-group col-md-2">
                    <label for="mobile">موبایل</label>
                    <input type="text" class="form-control font-small" id="mobile" name="mobile" placeholder="موبایل">
                </div>
                <div class="form-group col-md-2">
                    <label for="phone">تاریخ ثبت سفارش</label>
                    <input type="text" class="form-control font-small" id="date" name="date"
                           placeholder="تاریخ ثبت سفارش">
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-outline-info btn-sm">جست و جو</button>
                </div>
            </form>
        </div>
        <div class="col-md-12 table-responsive mx-auto">
            <table class="table table-bordered rounded mt-2">
                <thead>
                <tr class="bg-info text-light text-center small">
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>شماره موبایل</th>
                    <th>تلفن ثابت</th>
                    <th>تاریخ ثبت سفارش</th>
                    <th>وضعیت</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="text-center small">
                        <td><a href="{{route('admin.customers.show',['id'=>$order->user->id])}}">{{$order->user->name}}</a></td>
                        <td>{{$order->user->last_name}}</td>
                        <td>{{$order->user->mobile}}</td>
                        <td>{{$order->user->phone}}</td>
                        <td>{{$order->created_at}}</td>
                        <td class="font-weight-bold text-{{$order->status['color']}}">{{$order->status['title']}}</td>
                        <td>
                            <form class="form_destroy" data-id="{{$order->id}}" data-name="orders">
                                @csrf
                                <a href="{{route('admin.factors.edit',['id' => $order->factor->id])}}"
                                   class="btn btn-sm btn-outline-info fa fa-edit font-weight-bold"
                                   data-toggle="tooltip" data-placement="right" title="ویرایش"></a>

                                <a href="{{route('admin.factors.driver_factor',['id'=>$order->factor->id])}}" target="_blank"
                                   class="btn btn-sm btn-outline-primary fa fa-truck font-weight-bold"
                                   data-toggle="tooltip" data-placement="right" title="نمایش فاکتور راننده"></a>

                                <a href="{{route('admin.factors.show',['id'=>$order->factor->id])}}" target="_blank"
                                   class="btn btn-sm btn-outline-dark fa fa-print font-weight-bold"
                                   data-toggle="tooltip" data-placement="right" title="نمایش فاکتور"></a>
                                @can('delete-handFactor')
                                    <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger fa fa-trash font-weight-bold"
                                            data-toggle="tooltip" data-placement="right" title="حذف فاکتور"></button>
                                @endcan
                                @if($order->getOriginal('status') == 3)
                                    <a href="{{route('admin.orders.Delivery_To_Factory',['id'=>$order->id])}}"
                                       class="btn btn-sm btn-outline-warning fa font-weight-bold" data-toggle="tooltip"
                                       data-placement="right" title="تحویل به کارخانه">تحویل به
                                        کارخانه  <span
                                                class="fa fa-arrow-left"></span>
                                    </a>
                                @else
                                    <a href="{{route('admin.orders.Delivery_To_customer',['id'=>$order->id])}}"
                                       class="btn btn-sm btn-outline-info fa font-weight-bold" data-toggle="tooltip"
                                       data-placement="right" title="تحویل به مشتری">تحویل به مشتری  <span
                                                class="fa fa-arrow-left"></span>
                                    </a>
                                @endif
                            </form>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="col-md-12 mx-auto text-center">
                @if($orders_count == 0)
                    <h5 class="text-danger"> موردی یافت نشد!</h5>
                @else
                    <h6 class="text-danger float-left">{{$orders_count}} مورد یافت شد</h6>
                @endif
            </div>
            <div class="d-flex justify-content-center mr-n5">
                {{$orders->links()}}
            </div>
        </div>
    @endcan
@endsection