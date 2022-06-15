@extends('admin.master')

@section('content')
    @cannot('show-products')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('show-products')
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">لیست کالا ها</h4>
        </div>
        <div class="col-md-10 mx-auto">
            <div class=mx-auto">
                <a href="{{route('admin.products.create')}}" id="btn_search"
                   class="btn btn-outline-info cursor-pointer fa fa-plus"></a>
            </div>
        </div>
        <div class="col-md-10 table-responsive mx-auto">
            <table class="table table-bordered rounded mt-2">
                <thead>
                <tr class="bg-info text-light text-center small">
                    <th>شماره</th>
                    <th>نام کالا</th>
                    <th>واحد</th>
                    <th>قیمت</th>
                    <th>وضعیت</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr class="text-center small">
                        <td>{{$product->level}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->unit}}</td>
                        <td>{{number_format($product->price)}}</td>
                        <td>
                            <label class="cl-switch">
                                <input class="product_active" type="checkbox" data-id="{{$product->id}}"
                                        {{$product->active == 1 ? 'checked' : ''}}>
                                <span class="switcher"></span>
                            </label>
                        </td>                        <td>
                            <a href="{{route('admin.products.edit',['id' => $product->id])}}"
                               class="btn btn-outline-info btn-sm fa fa-edit" data-toggle="tooltip"
                               data-placement="right" title="ویرایش"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="col-md-12 mx-auto text-center">
                @if($products_count == 0)
                    <h5 class="text-danger"> موردی یافت نشد!</h5>
                @else
                    <h6 class="text-danger float-left">{{$products_count}} مورد یافت شد</h6>
                @endif
            </div>

            <div class="d-flex justify-content-center mr-n5">
                {{$products->links()}}
            </div>
        </div>
    @endcan
@endsection