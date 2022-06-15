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
            <h4 class="font-weight-bold my-4 text-muted">افزودن دفتر یا کارخانه</h4>
        </div>
        <div class="col-md-10 shadow-sm bg-white mx-auto rounded d-flex justify-content-center">
            <form action="{{route('admin.offices.store')}}" method="post"
                  class="border-0 rounded p-2 mt-3 mx-0 form-row">
                @csrf
                <div class="form-group col-md-3">
                    <label for="office_name">نام دفتر</label>
                    <input type="text" class="form-control font-small" id="office_name" name="office_name"
                           placeholder="نام دفتر">
                    @if ($errors->has('office_name'))
                        <strong class="error">{{$errors->first('office_name')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="user">نام مسئول دفتر</label>
                    <select class="form-control" name="user">
                        <option value="" selected>انتخاب کنید</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}} {{$user->last_name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('user'))
                        <strong class="error">{{$errors->first('user')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="type_office">دفتر یا کارخانه:</label>
                    <select class="form-control" name="type_office" id="type_office">
                        <option value="3">دفتر</option>
                        <option value="4">کارخانه</option>
                    </select>
                    @if ($errors->has('user'))
                        <strong class="error">{{$errors->first('user')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="phone">شماره تلفن دفتر</label>
                    <input type="text" class="form-control font-small" id="phone" name="phone"
                           placeholder="شماره تلفن دفتر">
                    @if ($errors->has('phone'))
                        <strong class="error">{{$errors->first('phone')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="address">آدرس</label>
                    <textarea type="text" class="form-control font-small" id="address" name="address"
                              placeholder="آدرس"></textarea>
                    @if ($errors->has('address'))
                        <strong class="error">{{$errors->first('address')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3 mt-1">
                    <button type="submit" class="btn btn-outline-info mt-4">افزودن</button>
                </div>
            </form>
        </div>
    @endcan
@endsection