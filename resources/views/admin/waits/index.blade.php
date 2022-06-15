@extends('admin.master')

@section('content')
    @cannot('show-waitingList')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('show-waitingList')
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">لیست انتظار</h4>
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <a id="btn_search" class="btn btn-outline-warning cursor-pointer fa fa-search mr-3"></a>
            </div>
            <div class="col-md-6 mx-auto text-left">
                @can('address-transport')
                    <a href="" id="btn_transport" class="btn btn-outline-info cursor-pointer btn-sm px-4 ml-2">
                        <i class="fa fa-truck"></i>
                    </a>
                    <a href="" id="notTransmitted" class="btn btn-sm btn-outline-danger cursor-pointer"> <i
                                class="fa fa-arrow-right"></i> بازگشت انتقال</a>
                    <a href="" id="Transmitted" class="btn btn-sm btn-outline-success cursor-pointer ml-3">انتقال
                        دادن <i
                                class="fa fa-arrow-left"></i></a>
                @endcan
            </div>
        </div>
        <div id="div_transport" class="col-md-12 mx-auto">
            <form action="{{route('admin.waits.transport_all')}}"
                  class="border-0 rounded p-2 mt-3 form-row" method="get">
                <div class="form-group col-md-2">
                    <label for="date">تاریخ</label>
                    <input autocomplete="off" type="text" class="form-control font-small" id="date" name="date"
                           placeholder="تاریخ ثبت سفارش">
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
                <div class="form-group col-md-2">
                    <label for="shift" class="small font-weight-bold">شیفت</label>
                    <select class="form-control font-small" id="shift" name="shift_id">
                        <option value="" selected></option>
                        @foreach($shifts as $shift)
                            <option value="{{$shift->id}}">از {{$shift->from}} تا {{$shift->to}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-outline-info btn-sm">انتقال</button>
                </div>
            </form>
        </div>
        <div id="div_search" class="col-md-12 mx-auto">
            <form action="{{route('admin.waits.search')}}"
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
                    <label for="date">تاریخ ثبت سفارش</label>
                    <input autocomplete="off" type="text" class="form-control font-small" id="date" name="date"
                           placeholder="تاریخ ثبت سفارش">
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
                <div class="form-group col-md-2">
                    <label for="shift" class="small font-weight-bold">شیفت</label>
                    <select class="form-control font-small" id="shift" name="shift_id">
                        <option value="" selected></option>
                        @foreach($shifts as $shift)
                            <option value="{{$shift->id}}">از {{$shift->from}} تا {{$shift->to}}</option>
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
                    <th>
                        <label class="label" style="font-family: 'Lato', monospace;
                                    font-size: 11px;">
                            <input class="label__checkbox" type="checkbox" id="checkAll">
                            <span class="label__text">
                             <span class="label__check">
                             <i class="fa fa-check icon"></i>
                             </span>
                            </span>
                        </label>
                    </th>
                    <th>نام و نام خانوادگی</th>
                    <th>شماره موبایل</th>
                    <th>شاخص آدرس</th>
                    <th>تاریخ ثبت سفارش</th>
                    <th>راننده</th>
                    <th>شیفت</th>
                    <th>وضعیت</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="text-center small">
                        <td>
                            <label class="label" style="font-family: 'Lato', monospace;
                                    font-size: 11px;">
                                <input class="change_status label__checkbox" type="checkbox" name="change_status"
                                       value="{{$order->id}}">
                                <span class="label__text">
                             <span class="label__check">
                             <i class="fa fa-check icon"></i>
                             </span>
                            </span>
                            </label>
                            {{--<input class="change_status" type="checkbox" name="change_status" value="{{$order->id}}">--}}
                        </td>
                        <td>
                            <a href="{{route('admin.customers.show',['id'=>$order->user->id])}}">{{$order->user->name}} {{$order->user->last_name}}</a>
                        </td>
                        <td>{{$order->user->mobile}}</td>
                        <td>{{$order->address->address_index}}</td>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->driver->name}} {{$order->driver->last_name}}</td>
                        <td>{{$order->shift->from}} تا {{$order->shift->to}}</td>
                        <td class="font-weight-bold text-{{$order->status['color']}}">{{$order->status['title']}}</td>
                        <td>
                            <form class="form_destroy csrf" data-id="{{$order->id}}" data-name="orders">
                                @csrf
                                <a href="{{route('admin.waits.edit',['id'=>$order->id])}}"
                                   class="btn btn-sm btn-outline-info fa fa-edit font-weight-bold"
                                   data-toggle="tooltip" data-placement="right" title="ویرایش"></a>
                                @can('delete-waitingList')
                                    <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger fa fa-trash font-weight-bold"
                                            data-toggle="tooltip" data-placement="right" title="حذف"></button>
                                @endcan
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