@extends('admin.master')

@section('content')
    @cannot('show-product-list')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('show-product-list')
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">گزارشات کالا</h4>
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <a id="btn_search" class="btn btn-outline-warning cursor-pointer fa fa-search mr-3"></a>
            </div>
            <div class="col-md-6 mx-auto pl-5 text-left">
                <a href="{{route('admin.reports.accounting.productExcel')}}" class="btn btn-outline-info cursor-pointer btn-sm">دریافت
                    فایل اکسل</a>
            </div>
        </div>

        <div id="div_search" class="col-md-12 mx-auto">
            <form action="{{route('admin.reports.products.search')}}"
                  class="border-0 rounded p-2 mt-3 form-row" method="get">
                <div class="form-group col-md-2">
                    <label for="date">تاریخ از</label>
                    <input type="text" class="form-control font-small" id="date" name="start_date"
                           placeholder="از">
                </div>
                <div class="form-group col-md-2">
                    <label for="date">تاریخ تا</label>
                    <input type="text" class="form-control font-small" id="date" name="end_date"
                           placeholder="تا">
                </div>
                <div class="form-group col-md-2">
                    <label for="address_index">شاخص آدرس</label>
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
                    <th>نام کالا</th>
                    <th>تعداد شسته شده ها</th>
                    <th>واحد</th>
                    <th>فی</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr class="text-center small">
                        <td>{{$product->name}}</td>
                        <td>{{$product->finalProducts}}</td>
                        <td>{{$product->unit}}</td>
                        <td>{{$product->price}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- <div class="col-md-12 mx-auto mb-5 text-center">
                 @if($orders_count == 0)
                     <h5 class="text-danger"> موردی یافت نشد!</h5>
                 @else
                     <h6 class="text-danger float-left">{{$orders_count}} مورد یافت شد</h6>
                 @endif
             </div>
             <div class="d-flex justify-content-center mr-n5">
                 {{$orders->links()}}
             </div>--}}
        </div>
    @endcan
@endsection