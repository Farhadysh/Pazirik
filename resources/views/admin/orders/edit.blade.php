@extends('admin.master')

@section('content')
    @cannot('edit-orders')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('edit-orders')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">ویرایش سفارش</h4>
        </div>
        <div class="col-md-10 shadow-sm bg-white mx-auto rounded d-flex justify-content-center">
            <form action="{{route('admin.orders.update',['id'=>$order->id])}}"
                  class="border-0 rounded p-2 mt-3 mx-0 form-row" method="post">
                @csrf
                @method('PATCH')
                <div class="form-group col-md-3">
                    <label for="name">نام</label>
                    <input type="text" class="form-control font-small" id="name" name="name" placeholder="نام"
                           value="{{$order->user->name}}" disabled>
                    @if ($errors->has('name'))
                        <strong class="error">{{$errors->first('name')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="last_name">نام خانوادگی</label>
                    <input type="text" class="form-control font-small" id="last_name" name="last_name"
                           placeholder="نام خانوادگی" value="{{$order->user->last_name}}" disabled>
                    @if ($errors->has('last_name'))
                        <strong class="error">{{$errors->first('last_name')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="mobile">موبایل</label>
                    <input type="text" class="form-control font-small" id="mobile" name="mobile" placeholder="موبایل"
                           value="{{$order->user->mobile}}" disabled>
                    @if ($errors->has('mobile'))
                        <strong class="error">{{$errors->first('mobile')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="phone">تلفن ثابت</label>
                    <input type="text" class="form-control font-small" id="phone" name="phone" placeholder="تلفن ثابت"
                           value="{{$order->user->phone}}" disabled>
                    @if ($errors->has('phone'))
                        <strong class="error">{{$errors->first('phone')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="phone">شاخص آدرس</label>
                    <input type="text" class="form-control font-small" id="address_index" name="address_index"
                           value="{{($order->address == '' ? '' : $order->address->address_index)}}" disabled>
                    @if ($errors->has('address_index'))
                        <strong class="error">{{$errors->first('address_index')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="phone">تاریخ ثبت سفارش</label>
                    <input type="text" class="form-control font-small" id="date" name="date"
                           value="{{$order->created_at}}" disabled>
                    @if ($errors->has('date'))
                        <strong class="error">{{$errors->first('date')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="phone">وضعیت سفارش</label>
                    <select class="form-control" name="status">
                        <option value="4" {{$order->status == 4 ? 'selected' : ''}}>دریافت کالا</option>
                        <option value="5" {{$order->status == 5 ? 'selected' : ''}}>تحویل به کارخانه</option>
                        <option value="6" {{$order->status == 6 ? 'selected' : ''}}>تحویل به مشتری</option>
                    </select>
                    @if ($errors->has('date'))
                        <strong class="error">{{$errors->first('date')}}</strong>
                    @endif
                </div>


                <div class="form-group col-md-10">
                    <label for="receive_address">آدرس تحویل</label>
                    <textarea class="form-control" id="receive_address"
                              name="receive_address">{{$order->address == '' ? '' :$order->address->receive_address}}</textarea>
                </div>
                <div class="form-group col-md-10">
                    <label for="phone">آدرس</label>
                    <textarea class="form-control"
                              disabled>{{$order->address == '' ? '' :$order->address->address}}</textarea>
                </div>


                <div class="form-group col-md-3 mt-1">
                    <button type="submit" class="btn btn-outline-info btn-sm mt-4">ویرایش/بازگشت</button>
                </div>
            </form>
        </div>
    @endcan
@endsection