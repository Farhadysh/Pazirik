@extends('admin.master')

@section('content')
    @cannot('show-customers')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('edit-customer')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">ویرایش مشتری</h4>
        </div>
        <div class="col-md-10 shadow-sm bg-white mx-auto rounded d-flex justify-content-center">
            <form action="{{route('admin.customers.update',['id'=>$user->id])}}"
                  class="border-0 rounded p-2 mt-3 mx-0 form-row" method="post">
                @csrf
                @method('PATCH')
                <div class="form-group col-md-3">
                    <label for="name">نام</label>
                    <input type="text" class="form-control font-small" id="name" name="name" placeholder="نام"
                           value="{{$user->name}}">
                    @if ($errors->has('name'))
                        <strong class="error">{{$errors->first('name')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="last_name">نام خانوادگی</label>
                    <input type="text" class="form-control font-small" id="last_name" name="last_name"
                           placeholder="نام خانوادگی" value="{{$user->last_name}}">
                    @if ($errors->has('last_name'))
                        <strong class="error">{{$errors->first('last_name')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="mobile">موبایل</label>
                    <input type="text" class="form-control font-small" id="mobile" name="mobile" placeholder="موبایل"
                           value="{{$user->mobile}}">
                    @if ($errors->has('mobile'))
                        <strong class="error">{{$errors->first('mobile')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="phone">تلفن ثابت</label>
                    <input type="text" class="form-control font-small" id="phone" name="phone" placeholder="تلفن ثابت"
                           value="{{$user->phone}}">
                    @if ($errors->has('phone'))
                        <strong class="error">{{$errors->first('phone')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3 mt-1">
                    <button type="submit" class="btn btn-outline-info mt-4">ویرایش/بازگشت</button>
                </div>
            </form>
        </div>
        <div class="col-md-10 shadow-sm bg-white mx-auto my-3 rounded d-flex justify-content-center">
            <div class="row">
                <div class="col-md-12 text-muted my-4 text-center">
                    ویرایش آدرس ها
                </div>
                @foreach($user->addresses as $address)
                    <form action="{{route('admin.addresses.update',['id'=>$address->id])}}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="col-md-12 border rounded-lg my-3"
                             style="margin-right: 90px">
                            <input name="address_index" type="text" class="form-control my-2 col-md-4 small"
                                   height="5px"
                                   placeholder="شاخص آدرس" value="{{$address->address_index}}">
                            <textarea name="address" class="form-control mb-1" rows="1"
                                      placeholder="آدرس">{{$address->address}}</textarea>
                            <button type="submit" class="btn btn-sm btn-outline-info mb-1">ویرایش</button>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    @endcan
@endsection