@extends('admin.master')

@section('content')
    @cannot('show-changes')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('show-changes')
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">فاکتورهای تغییر یافته</h4>
        </div>
        <div class="row">
            <div class="col-md-12 mx-auto">
                <a id="btn_search" class="btn btn-outline-warning cursor-pointer fa fa-search mr-3"></a>
            </div>
        </div>
        <div id="div_search" class="col-md-12 mx-auto">
            <form action="{{route('admin.changes.search')}}"
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
                @foreach($factors as $factor)
                    <tr class="text-center small {{$factor->changeOrder->seen == 0 ? 'bg-low-danger' : ''}}">
                        <td>{{$factor->changeOrder->user->last_name}}</td>
                        <td>{{$factor->changeOrder->user->mobile}}</td>
                        <td>{{$factor->changeOrder->user->phone}}</td>
                        <td>{{$factor->changeOrder->changeAddress->address_index}}</td>
                        <td>{{$factor->changeOrder->created_at}}</td>
                        <td>{{$factor->changeOrder->driver->name}} {{$factor->changeOrder->driver->last_name}}</td>
                        <td class="text-{{$factor->changeOrder->status['color']}}">{{$factor->changeOrder->status['title']}}</td>
                        <td>
                            <a href="{{route('admin.changes.show',['id'=>$factor->id])}}" target="_blank"
                               class="btn btn-sm btn-outline-primary  font-weight-bold"
                               title="نمایش فاکتور">
                                <i class="fa fa-print"></i>
                                 فاکتور قدیمی</a>

                            <a href="{{route('admin.factors.show',['id'=>$factor->old_id])}}" target="_blank"
                               class="btn btn-sm btn-outline-success font-weight-bold"
                               title="نمایش فاکتور">
                                <i class="fa fa-print"></i>
                                 فاکتور جدید</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="col-md-12 mx-auto text-center">
                @if($factor_count == 0)
                    <h5 class="text-danger"> موردی یافت نشد!</h5>
                @else
                    <h6 class="text-danger float-left">{{$factor_count}} مورد یافت شد</h6>
                @endif
            </div>
            <div class="d-flex justify-content-center mr-n5">
                {{$factors->links()}}
            </div>
        </div>
    @endcan
@endsection