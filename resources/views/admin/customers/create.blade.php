@extends('admin.master')

@section('content')
    @cannot('add-customer')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('add-customer')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">افزودن مشتری</h4>
        </div>
        <div class="col-md-10 mx-auto">
            <form action="{{route('admin.customers.store')}}" method="post">
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
                        @if ($errors->has('mobile'))
                            <strong class="error">{{$errors->first('mobile')}}</strong>
                        @endif
                    </div>
                    <div class="row px-4">
                        <div class="col-md-4 py-3 input_user_id">
                            <label for="name" class=" font-weight-bold">نام</label>
                            <input type="text" class="form-control font-small" id="name" name="name"
                                   placeholder="نام">
                            @if ($errors->has('name'))
                                <strong class="error">{{$errors->first('name')}}</strong>
                            @endif
                        </div>
                        <div class="col-md-4 py-3">
                            <label for="last_name" class=" font-weight-bold">نام خانوادگی</label>
                            <input type="text" class="form-control font-small" id="last_name" name="last_name"
                                   placeholder="نام خانوادگی">
                            @if ($errors->has('last_name'))
                                <strong class="error">{{$errors->first('last_name')}}</strong>
                            @endif
                        </div>
                        <div class="col-md-4 py-3">
                            <label for="phone" class=" font-weight-bold">تلفن ثابت</label>
                            <input type="text" class="form-control font-small" id="phone" name="phone"
                                   placeholder="تلفن ثابت">
                            @if ($errors->has('phone'))
                                <strong class="error">{{$errors->first('phone')}}</strong>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 mt-4 py-4">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-content-center">
                            <h6 class="font-weight-bold text-muted">آدرس ها</h6>
                            <button class="btn btn-sm btn-outline-info fa fa-plus cursor-pointer add_address">
                            </button>
                        </div>
                        <div class="row mt-3 div_address">
                            <div class="col-md-12">
                                @if ($errors->has('address'))
                                    <strong class="error">{{$errors->first('address')}}</strong>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 mt-4">
                    <div class="col-md-10 mx-auto">
                        <div class="col-md-12 text-center text-dark">
                            <h6 class="font-weight-bold my-4 text-muted">سرویس دهی</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="driver" class="small font-weight-bold">راننده</label>
                                <select class="form-control font-small" id="driver" name="driver_id">
                                    <option value="" selected>انتخاب کنید</option>
                                    @foreach($drivers as $driver)
                                        <option value="{{$driver->id}}">{{$driver->name}} {{$driver->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="shift" class="small font-weight-bold">شیفت</label>
                                <select class="form-control font-small" id="shift" name="shift_id">
                                    <option value="" selected>انتخاب کنید</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{$shift->id}}">از {{$shift->from}} تا {{$shift->to}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="date" class=" font-weight-bold">تاریخ تحویل</label>
                                <input autocomplete="off" type="text" class="form-control font-small" id="date"
                                       name="date"
                                       placeholder="تاریخ تحویل">
                                @if ($errors->has('date'))
                                    <strong class="error">{{$errors->first('date')}}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-10 pb-5">
                            <button type="submit" class="btn btn-outline-success">ثبت</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    @endcan
@endsection