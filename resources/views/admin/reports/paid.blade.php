@extends('admin.master')

@section('content')
    {{--@cannot('admin_accounting')--}}
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    {{--@endcannot
    @can('admin_accounting')--}}
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">لیست مالی</h4>
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <a id="btn_search" class="btn btn-outline-warning cursor-pointer fa fa-search mr-3"></a>
            </div>
            <div class="col-md-6 mx-auto pl-5 text-left">
                <a href="{{route('admin.reports.accounting.paidExcel')}}" class="btn btn-outline-info cursor-pointer btn-sm">دریافت
                    فایل اکسل</a>
            </div>
        </div>
        <div id="div_search" class="col-md-12 mx-auto">
            <form action="{{route('admin.reports.accounting.paidSearch')}}"
                  class="border-0 rounded p-2 mt-3 form-row" method="get">
                <div class="form-group col-md-2">
                    <label for="last_name">نام خانوادگی</label>
                    <input type="text" class="form-control font-small" id="last_name" name="last_name"
                           placeholder="نام خانوادگی">
                </div>
                <div class="form-group col-md-2">
                    <label for="factor_id">شماره فاکتور</label>
                    <input type="text" class="form-control font-small" id="factor_id" name="factor_id"
                           placeholder="شماره فاکتور">
                </div>

                <div class="form-group col-md-2">
                    <label for="date">تاریخ از</label>
                    <input autocomplete="off" type="text" class="form-control font-small" id="date"
                           name="start_date"
                           placeholder="از">
                </div>
                <div class="form-group col-md-2">
                    <label for="date">تاریخ تا</label>
                    <input autocomplete="off" type="text" class="form-control font-small" id="date_2"
                           name="end_date"
                           placeholder="تا">
                </div>
                <div class="form-group col-md-2">
                    <label for="phone">شاخص آدرس</label>
                    <input type="text" class="form-control font-small" id="address_index" name="address_index"
                           placeholder="شاخص آدرس">
                </div>
                <div class="form-group col-md-2">
                    <label for="driver" class="small font-weight-bold">راننده</label>
                    <select class="form-control font-small" id="driver" name="driver_id">
                        <option value="" selected></option>
                        @foreach($drivers as $driver)
                            <option value="{{$driver->id}}">{{$driver->name}} {{$driver->last_name}}</option>
                        @endforeach
                    </select>
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
                    <th>نام خانوادگی</th>
                    <th>تلفن همراه</th>
                    <th>تاریخ</th>
                    <th>راننده</th>
                    <th>شماره فاکتور</th>
                    <th>جمع فاکتور</th>
                    <th>تخفیف</th>
                    <th>حمل و نقل</th>
                    <th>خدمات</th>
                    <th>انتقال از طبقات</th>
                    <th>روش و میزان پرداخت</th>
                    <th>صورتحساب اقساط</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="text-center small">
                        <td>
                            <a href="{{route('admin.customers.show',['id'=>$order->user->id])}}">{{$order->user->name}} {{$order->user->last_name}}</a>
                        </td>
                        <td>{{$order->user->mobile}}</td>
                        <td>{{$order->created_at}}</td>
                        @if($order->driver)
                            <td>{{$order->driver->name}}</td>
                        @else
                            <td class="text-primary">فاکتور دستی</td>
                        @endif
                        <td>
                            <a class="text-danger text-decoration-none fa fa-print" target="_blank"
                               href="{{route('admin.factors.show',['id'=>$order->factor->id])}}">
                                {{$order->factor->factor_id}}
                            </a>
                        </td>
                        <td>
                            {{number_format($order->factor->FactorProducts->sum(function ($p){
                              return  $p->price * $p->count;
                            })
                            - $order->factor->discount
                            + $order->factor->transport
                            + $order->factor->service
                            +$order->factor->collecting)}}
                        </td>
                        @if($order->factor->discount == null)
                            <td>0</td>
                        @else
                            <td>{{number_format($order->factor->discount)}}</td>
                        @endif
                        <td>{{number_format($order->factor->transport)}}</td>
                        <td>{{number_format($order->factor->service)}}</td>
                        <td>{{number_format($order->factor->collecting)}}</td>
                        <td class="text-{{$order->factor->type['color']}}">{{$order->factor->type['title']}}
                            @if($order->factor->getOriginal('status') == 2)
                                <br>(تسویه شده)
                            @else
                                <br>{{number_format($order->factor->debtors->sum('cost'))}}
                            @endif
                        </td>
                        <td>
                            @if($order->factor->getOriginal('type') == 2)
                                <a href="{{route('admin.factors.installmentEdit',['id'=> $order->factor->id])}}"
                                   class="btn btn-outline-warning btn-sm fa fa-sticky-note" data-toggle="tooltip"
                                   data-placement="right" title="نمایش صورتحساب"></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--<div class="col-md-12 mx-auto mb-5 text-center">
                @if($orders_count == 0)
                    <h5 class="text-danger"> موردی یافت نشد!</h5>
                @else
                    <h6 class="text-danger float-left">{{$orders_count}} مورد یافت شد</h6>
                @endif
            </div>--}}
            <div class="d-flex justify-content-center mr-n5">
                {{$orders->links()}}
            </div>
    {{--@endcan--}}
@endsection