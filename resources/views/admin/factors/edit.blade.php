@extends('admin.master')

@section('content')
    @cannot('edit-handFactor')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('edit-handFactor')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">ویرایش فاکتور دستی</h4>
        </div>
        <div class="col-md-10 mx-auto">
            <form action="{{route('admin.factors.update',['id'=>$factor->id])}}" method="post">
                @csrf
                @method('PATCH')
                <div class="card shadow-sm border-0">
                    <div class="text-center text-dark">
                        <h6 class="font-weight-bold my-4 text-muted ">ویرایش مشخصات مشتری</h6>
                    </div>
                    <div class="col-md-6 mx-auto">
                        <label for="mobile" class=" font-weight-bold">کد اشتراک</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control font-small mobile" id="mobile" name="mobile"
                                   placeholder="تلفن همراه" value="{{$factor->order->user->mobile}}">
                        </div>
                        <strong class="error" id="mobile_error"></strong>
                    </div>
                    <div class="row px-4">
                        <div class="col-md-4 py-3 input_user_id">
                            <label for="name" class=" font-weight-bold">نام</label>
                            <input type="text" class="form-control font-small" id="name" name="name"
                                   placeholder="نام" value="{{$factor->order->user->name}}">
                            <strong class="error" id="name_error"></strong>
                        </div>
                        <input name="user_id" value="{{$factor->order->user->id}}" type="hidden">
                        <div class="col-md-4 py-3">
                            <label for="last_name" class=" font-weight-bold">نام خانوادگی</label>
                            <input type="text" class="form-control font-small" id="last_name" name="last_name"
                                   placeholder="نام خانوادگی" value="{{$factor->order->user->last_name}}">
                            <strong class="error" id="last_name_error"></strong>
                        </div>
                        <div class="col-md-4 py-3">
                            <label for="phone" class=" font-weight-bold">تلفن ثابت</label>
                            <input type="text" class="form-control font-small" id="phone" name="phone"
                                   placeholder="تلفن ثابت" value="{{$factor->order->user->phone}}">
                            <strong class="error" id="phone_error"></strong>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 mt-2 py-4">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-content-center">
                            <h6 class="font-weight-bold text-muted">آدرس ها</h6>
                            <button class="btn btn-sm btn-outline-info fa fa-plus cursor-pointer add_address">
                            </button>
                        </div>
                        <div class="row mt-2 div_address">
                            <div class="col-md-12">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 mt-2">
                    <div class="col-md-10 mx-auto">
                        <div class="col-md-12 text-center text-dark">
                            <h6 class="font-weight-bold my-4 text-muted">اطلاعات</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="transport" class=" font-weight-bold small">حمل و نقل</label>
                                <input type="text" class="money form-control font-small" id="transport" name="transport"
                                       placeholder="حمل و نقل" value="{{$factor->transport}}">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="service" class=" font-weight-bold small">رفو ریشه و سردوز</label>
                                <input type="text" class="money form-control font-small" id="service" name="service"
                                       placeholder="رفو ریشه و سردوز" value="{{$factor->service}}">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="date" class=" font-weight-bold small">تاریخ دریافت فرش</label>
                                <input type="text" class="form-control font-small" id="date" name="date"
                                       placeholder="تاریخ دریافت فرش" value="{{$factor->date}}">
                                <strong class="error" id="date_error"></strong>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="col-md-4 form-group">
                                <label for="receive_in" class=" font-weight-bold small">تحویل در:</label>
                                <select class="form-control small" id="receive_in" name="receive_in">
                                    @foreach($offices as $office)
                                        <option value="{{$office->id}}" {{$office->id == $factor->order->office_id ? 'selected' : ''}}>{{$office->office_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-info mt-3 btn-sm final_btn">ویرایش مشخصات</button>
                </div>
            </form>
            <div class="card shadow-sm border-0 mt-4">
                <div class="col-md-10 mx-auto">
                    <div class="col-md-12 text-center text-dark">
                        <h6 class="font-weight-bold my-4 text-muted">ویرایش کالا</h6>
                    </div>
                    <form action="{{route('admin.factors.ProductFactor_create')}}" method="post">
                        @csrf
                        <div class="d-flex">
                            <div class="col-md-4 form-group">
                                <label for="products" class="small font-weight-bold">لیست کالا ها</label>
                                <select class="form-control font-small" id="products" name="products">
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}"
                                                price="{{$product->price}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="count" class=" font-weight-bold">تعداد</label>
                                <input type="text" class="form-control font-small" id="count" name="count"
                                       placeholder="تعداد">
                                @if ($errors->has('count'))
                                    <strong class="error">{{$errors->first('count')}}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="defection" class="small font-weight-bold">توضیحات و نقص</label>
                            <textarea type="text" class="form-control font-small" id="defection" name="defection"
                                      placeholder="توضیحات و نقص"></textarea>
                        </div>
                        <input type="hidden" value="{{$factor->id}}" name="factor_id">
                        <div class="col-md-12 form-group">
                            <button type="submit" class="btn btn-sm btn-outline-success cursor-pointer">افزودن کالا
                            </button>
                        </div>
                    </form>
                    <table class="table table-bordered mb-5">
                        <thead>
                        <tr class="bg-warning small text-center">
                            <th>نام کالا</th>
                            <th>تعداد کالا</th>
                            <th>قیمت</th>
                            <th>توضیحات</th>
                            <th>تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody class="product_table">
                        @foreach($factor->factorProducts as $factorProduct)
                            <tr>
                                <td>{{$factorProduct->product->name}}</td>
                                <td>{{$factorProduct->count}}</td>
                                <td>{{$factorProduct->price}}</td>
                                <td>{{$factorProduct->defection}}</td>
                                <td class="text-center">
                                    <form action="{{route('admin.factors.ProductFactor_destroy',['id'=>$factorProduct->id])}}"
                                          method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger fa fa-trash"></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <strong class="error" id="product_list_error"></strong>
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-outline-info mt-3 btn-sm final_btn">ویرایش کالا</button>
            </div>
        </div>
    @endcan
@endsection