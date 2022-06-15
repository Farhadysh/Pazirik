@extends('admin.master')

@section('content')
    @cannot('edit-waitingList')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('edit-waitingList')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">ویرایش سفارش</h4>
        </div>
        <div class="col-md-10 mx-auto">
            <form action="{{route('admin.waits.update',['id' => $order->id])}}" method="post">
                @csrf
                <div class="card shadow-sm border-0">
                    <div class="text-center text-dark">
                        <h6 class="font-weight-bold my-4 text-muted ">مشخصات مشتری</h6>
                    </div>
                    <div class="col-md-6 mx-auto">
                        <input type="hidden" name="order_id" value="{{$order->id}}">
                        <label for="mobile" class=" font-weight-bold">کد اشتراک</label>
                        <input type="text" class="form-control font-small mobile" id="mobile" name="mobile"
                               placeholder="تلفن همراه" value="{{$order->user->mobile}}">
                        @if ($errors->has('mobile'))
                            <strong class="error">{{$errors->first('mobile')}}</strong>
                        @endif
                    </div>
                    <div class="d-flex">
                        <div class="col-md-4 py-3 input_user_id">
                            <label for="name" class=" font-weight-bold">نام</label>
                            <input type="text" class="form-control font-small" id="name" name="name"
                                   placeholder="نام" value="{{$order->user->name}}">
                            @if ($errors->has('name'))
                                <strong class="error">{{$errors->first('name')}}</strong>
                            @endif
                        </div>
                        <div class="col-md-4 py-3">
                            <label for="last_name" class=" font-weight-bold">نام خانوادگی</label>
                            <input type="text" class="form-control font-small" id="last_name" name="last_name"
                                   placeholder="نام خانوادگی" value="{{$order->user->last_name}}">
                            @if ($errors->has('last_name'))
                                <strong class="error">{{$errors->first('last_name')}}</strong>
                            @endif
                        </div>
                        <div class="col-md-4 py-3">
                            <label for="phone" class=" font-weight-bold">تلفن ثابت</label>
                            <input type="text" class="form-control font-small" id="phone" name="phone"
                                   placeholder="تلفن ثابت" value="{{$order->user->phone}}">
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
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="col-md-5 border rounded-lg mx-auto my-3">
                                    <input type="hidden" name="adr_id" value="{{$order->address->id}}">
                                    <input name="address_index" type="text" class="form-control my-2 col-md-4 small"
                                           height="5px" placeholder="شاخص آدرس"
                                           value="{{$order->address->address_index}}">
                                    <textarea name="address" class="form-control mb-1" rows="1"
                                              placeholder="آدرس">{{$order->address->address}}</textarea>
                                    <textarea name="description_adr" class="form-control mb-1" rows="2"
                                              placeholder="توضیحات">{{$order->address->description}}</textarea>
                                </div>
                                @if ($errors->has('address'))
                                    <strong class="error">{{$errors->first('address')}}</strong>
                                @endif
                            </div>
                            @foreach($order->user->addresses as $address)
                                <div class="col-md-5 border my-2 mx-auto rounded-lg">
                                    <div class="row">
                                        <input type="radio" name="address_id" class="mx-3 my-auto"
                                               value="{{$address->id}}">
                                        <div class="d-flex flex-column">
                                            <strong class="py-1">{{$address->address_index}}</strong>
                                            <span class="small py-1">{{$address->address}}</span>
                                            <span class="small py-1 text-danger">{{$address->description == null ? 'توضیحات ندارد!' : $address->description}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 mt-4">
                    <div class="col-md-10 mx-auto">
                        <div class="col-md-12 text-center text-dark">
                            <h6 class="font-weight-bold my-4 text-muted">سرویس دهی</h6>
                        </div>
                        <div class="d-flex">
                            <div class="col-md-4 py-4">
                                <label for="driver" class="small font-weight-bold">راننده</label>
                                <select class="form-control font-small" id="driver" name="driver_id">
                                    @foreach($drivers as $driver)
                                        <option value="{{$driver->id}}" {{$order->driver_id == $driver->id ? 'selected' : ''}}> {{$driver->name}} {{$driver->last_name}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-4 py-4">
                                <label for="shift" class="small font-weight-bold">شیفت</label>
                                <select class="form-control font-small" id="shift" name="shift_id">
                                    @foreach($shifts as $shift)
                                        <option value="{{$shift->id}}" {{$order->shift_id == $shift->id ? 'selected' : ''}}>
                                            از {{$shift->from}} تا {{$shift->to}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-4 py-4">
                                <label for="date" class="small font-weight-bold">تاریخ ثبت سفارش</label>
                                <input autocomplete="off" type="text" class="form-control font-small" id="date"
                                       name="date"
                                       value="{{$order->date}}">

                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="description" class="small font-weight-bold">توضیحات</label>
                            <textarea type="text" class="form-control font-small" id="description" name="description"
                                      placeholder="توضیحات">{{$order->description}}</textarea>
                        </div>
                        <div class="col-md-10 py-4">
                            <button type="submit" class="btn btn-outline-info">ویرایش</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    @endcan
@endsection