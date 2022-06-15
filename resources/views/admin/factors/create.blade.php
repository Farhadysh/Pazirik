@extends('admin.master')

@section('content')
    @cannot('add-handFactor')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('add-handFactor')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">ایجاد فاکتور دستی</h4>
        </div>
        <div class="col-md-10 mx-auto">
            <form class="form_submit">
                @csrf
                <div class="card shadow-sm border-0">
                    <div class="text-center text-dark">
                        <h6 class="font-weight-bold my-4 text-muted ">مشخصات مشتری</h6>
                    </div>
                    <div class="col-md-6 mx-auto">
                        <label for="mobile" class=" font-weight-bold">کد اشتراک</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control font-small mobile" id="mobile" name="mobile"
                                   placeholder="تلفن همراه">
                            <div class="input-group-append">
                                <button class="text-info input-group-text cursor-pointer fa fa-search btn_search_mobile"></button>
                            </div>
                        </div>
                        <strong class="error" id="mobile_error"></strong>
                    </div>
                    <div class="row px-4">
                        <div class="col-md-4 py-3 input_user_id">
                            <label for="name" class=" font-weight-bold">نام</label>
                            <input type="text" class="form-control font-small" id="name" name="name"
                                   placeholder="نام">
                            <strong class="error" id="name_error"></strong>
                        </div>
                        <div class="col-md-4 py-3">
                            <label for="last_name" class=" font-weight-bold">نام خانوادگی</label>
                            <input type="text" class="form-control font-small" id="last_name" name="last_name"
                                   placeholder="نام خانوادگی">
                            <strong class="error" id="last_name_error"></strong>
                        </div>
                        <div class="col-md-4 py-3">
                            <label for="phone" class=" font-weight-bold">تلفن ثابت</label>
                            <input type="text" class="form-control font-small" id="phone" name="phone"
                                   placeholder="تلفن ثابت">
                            <strong class="error" id="phone_error"></strong>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 mt-4 py-4">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-content-center">
                            <h6 class="font-weight-bold text-muted">آدرس تحویل</h6>
                            <button class="btn btn-sm btn-outline-info fa fa-plus cursor-pointer add_address">
                            </button>
                        </div>
                        <div class="row mt-2 div_address">
                            <div class="col-md-12">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 mt-4">
                    <div class="col-md-10 mx-auto">
                        <div class="col-md-12 text-center text-dark">
                            <h6 class="font-weight-bold my-4 text-muted">اطلاعات</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="transport" class="font-weight-bold small">حمل و نقل</label>
                                <input type="text" class="money form-control font-small" id="transport" name="transport"
                                       placeholder="حمل و نقل">
                                <strong class="error" id="transport_error"></strong>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="service" class=" font-weight-bold small">رفو ریشه و سردوز</label>
                                <input type="text" class="money form-control font-small" id="service" name="service"
                                       placeholder="رفو ریشه و سردوز">
                                <strong class="error" id="service_error"></strong>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="date" class=" font-weight-bold small">تاریخ دریافت فرش</label>
                                <input autocomplete="off" type="text" class="form-control font-small" id="date"
                                       name="date"
                                       placeholder="تاریخ دریافت فرش">
                                <strong class="error" id="date_error"></strong>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="col-md-4 form-group">
                                <label for="receive_in" class=" font-weight-bold small">تحویل به:</label>
                                <select class="form-control small" id="receive_in" name="receive_in">
                                    <option value="" selected>انتخاب کنید</option>
                                    @foreach($offices as $office)
                                        <option value="{{$office->id}}">{{$office->office_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 mt-4">
                    <div class="col-md-10 mx-auto">
                        <div class="col-md-12 text-center text-dark">
                            <h6 class="font-weight-bold my-4 text-muted">افزودن کالا</h6>
                        </div>
                        <div class="d-flex">
                            <div class="col-md-4 form-group">
                                <label for="products" class="small font-weight-bold">لیست کالا ها</label>
                                <select class="form-control font-small" id="products" name="products">
                                    <option value="" selected>انتخاب کنید</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}"
                                                price="{{$product->price}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="count" class=" font-weight-bold">تعداد</label>
                                {{--<input type="text" class="form-control font-small" id="count" name="count"
                                       placeholder="تعداد">--}}
                                <input class="form-control font-small" type="number" id="count" name="count"
                                       pattern="([0-9]{1,3}).([0-9]{1,3})" title="" placeholder="تعداد"
                                       autocomplete="off" min="1">
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
                        <div class="col-md-12 form-group">
                            <a class="btn btn-sm btn-outline-success cursor-pointer product_save">افزودن کالا</a>
                        </div>
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
                            <strong class="error" id="product_list_error"></strong>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-outline-info mt-3 btn-sm final_btn">ثبت نهایی</button>
                </div>
            </form>
        </div>
    @endcan
@endsection