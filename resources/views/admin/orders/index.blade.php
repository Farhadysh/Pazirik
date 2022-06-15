@extends('admin.master')

@section('content')
    @cannot('show-orders')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('show-orders')
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">لیست سفارشات</h4>
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <a id="btn_search" class="btn btn-outline-warning cursor-pointer fa fa-search mr-3"></a>
            </div>
            <div class="col-md-6 mx-auto pl-5 text-left">
                <a href="{{route('admin.orders.orderExcel')}}" class="btn btn-outline-info cursor-pointer btn-sm">دریافت
                    فایل اکسل</a>
            </div>
        </div>
        <div id="div_search" class="col-md-12 mx-auto">
            <form action="{{route('admin.orders.search')}}"
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
                    <label for="phone">تلفن</label>
                    <input type="text" class="form-control font-small" id="phone" name="phone" placeholder="تلفن">
                </div>
                <div class="form-group col-md-2">
                    <label for="phone">تاریخ ثبت سفارش</label>
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
                <div class="form-group col-md-3">
                    <label for="status" class="small font-weight-bold">وضعیت سفارش</label>
                    <select class="form-control font-small" id="status" name="status">
                        <option value="" selected></option>
                        <option value="3">دریافت کالا</option>
                        <option value="4">تحویل به کارخانه</option>
                        <option value="5">تحویل به مشتری</option>
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
                    <th>مارک</th>
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>شماره موبایل</th>
                    <th>تلفن ثابت</th>
                    <th>شاخص آدرس</th>
                    <th>تاریخ ثبت سفارش</th>
                    <th>راننده</th>
                    <th>وضعیت</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="text-center small">
                        <td class="px-0 pt-1"><input class="{{$order->mark->description == null ? 'star' : 'star text-success'}}" type="checkbox"
                                                     data-id="{{$order->id}}" {{$order->mark && $order->mark->status == 1 ? '' : 'checked'}} >
                        </td>
                        <td>
                            <a href="{{route('admin.customers.show',['id'=>$order->user->id])}}">{{$order->user->name}}</a>
                        </td>
                        <td>{{$order->user->last_name}}</td>
                        <td>{{$order->user->mobile}}</td>
                        <td>{{$order->user->phone}}</td>
                        @if($order->address)
                            <td>{{$order->address->address_index}}</td>
                        @else
                            <td>آدرس ندارد</td>
                        @endif
                        <td>{{ $order->created_at}}</td>
                        @if($order->driver)
                            <td>{{$order->driver->name}} {{$order->driver->last_name}}</td>
                        @else
                            <td class="text-primary">فاکتور دستی</td>
                        @endif
                        <td class="font-weight-bold text-{{$order->status['color']}}">{{$order->status['title']}}</td>
                        <td>
                            <form class="form_destroy" data-id="{{$order->id}}" data-name="orders">
                                @csrf
                                @if($order->getOriginal('status') > 3)
                                    <a class="btn btn-sm btn-outline-{{$order->factor->description == null ? 'warning' : 'success'}} fa fa-sticky-note" href=""
                                       data-toggle="modal" data-target="#exampleModalCenter{{$order->id}}"></a>
                                @endif
                                <a href="{{route('admin.orders.edit',['id'=>$order->id])}}"
                                   class="btn btn-sm btn-outline-info fa fa-edit font-weight-bold"
                                   data-toggle="tooltip" data-placement="right" title="ویرایش"></a>

                                <a href="{{route('admin.orders.show',['id'=>$order->id])}}"
                                   class="btn btn-sm btn-outline-dark fa fa-list font-weight-bold"
                                   data-toggle="tooltip" data-placement="right" title="جزئیات سفارش"></a>
                                @can('delete-orders')
                                    <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger fa fa-trash font-weight-bold"
                                            data-toggle="tooltip" data-placement="right" title="حذف"></button>
                                @endcan
                            </form>

                        </td>
                    </tr>

                    <div class="modal fade" id="exampleModalCenter{{$order->id}}" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content col-md-10 mr-0">
                                <div class="background-header-modal">
                                    <div class="cover-header-modal text-center p-4">
                                        <span class="line"></span>
                                        <h5 class="mx-2 font-weight-bold">متن پیام</h5>
                                        <span class="line"></span>
                                    </div>
                                </div>
                                <div class="modal-body text-center">
                                    <form action="{{route('admin.factors.addNote')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="factor_id" value="{{$order->factor->id}}">
                                        <div class="form-group col-md-9 mx-auto">
                                            <label for="description">متن یادداشت</label>
                                            <textarea type="text" class="form-control font-small" id="description"
                                                      name="description" rows="4"
                                                      cols="35" placeholder="متن یادداشت">{{$order->factor->description}}</textarea>
                                            @if ($errors->has('description'))
                                                <strong class="error">{{$errors->first('description')}}</strong>
                                            @endif
                                        </div>
                                        <button class="btn btn-outline-info btn-sm" type="submit">ثبت</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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