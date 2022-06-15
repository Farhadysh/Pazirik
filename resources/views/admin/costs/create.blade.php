@extends('admin.master')

@section('content')
    @cannot('add-costs')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('add-costs')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">افزودن هزینه</h4>
        </div>
        <div class="col-md-10 shadow-sm bg-white mx-auto rounded d-flex justify-content-center">
            <form action="{{route('admin.costs.store')}}" method="post"
                  class="border-0 rounded p-2 mt-3 mx-0 form-row">
                @csrf
                <div class="form-group col-md-3">
                    <label for="name">عنوان</label>
                    <input type="text" class="form-control font-small" id="name" name="name" placeholder="عنوان">
                    @if ($errors->has('name'))
                        <strong class="error">{{$errors->first('name')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="price">فی</label>
                    <input type="text" class="form-control font-small money" id="price" name="price"
                           placeholder="فی">
                    @if ($errors->has('price'))
                        <strong class="error">{{$errors->first('price')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="count">تعداد</label>
                    <input type="number" class="form-control font-small" id="count" name="count"
                           placeholder="تعداد">
                    @if ($errors->has('count'))
                        <strong class="error">{{$errors->first('count')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="date">تاریخ</label>
                    <input autocomplete="off" type="text" class="form-control font-small" id="date" name="date"
                           placeholder="تاریخ">
                    @if ($errors->has('date'))
                        <strong class="error">{{$errors->first('date')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-7">
                    <label for="description">توضیحات</label>
                    <textarea type="text" class="form-control font-small" id="description" name="description"
                              placeholder="توضیحات"></textarea>
                    @if ($errors->has('description'))
                        <strong class="error">{{$errors->first('description')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3 mt-1">
                    <button type="submit" class="btn btn-outline-info mt-4">افزودن</button>
                </div>
            </form>
        </div>
    @endcan
@endsection