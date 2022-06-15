@extends('admin.master')

@section('content')
    @cannot('add-users')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('add-users')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">افزودن کاربر</h4>
        </div>
        <div class="col-md-10 shadow-sm bg-white mx-auto rounded d-flex justify-content-center">
            <form action="{{route('admin.users.store')}}" method="post"
                  class="border-0 rounded p-2 mt-3 mx-0 form-row">
                @csrf

                <div class="col-md-3">
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

                <div class="form-group col-md-3 input_user_id">
                    <label for="name">نام</label>
                    <input type="text" class="form-control font-small" id="name" name="name" placeholder="نام">
                    @if ($errors->has('name'))
                        <strong class="error">{{$errors->first('name')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="last_name">نام خانوادگی</label>
                    <input type="text" class="form-control font-small" id="last_name" name="last_name"
                           placeholder="نام خانوادگی">
                    @if ($errors->has('last_name'))
                        <strong class="error">{{$errors->first('last_name')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="username">نام کاربری</label>
                    <input type="text" class="form-control font-small" id="username" name="username"
                           placeholder="نام کاربری">
                    @if ($errors->has('username'))
                        <strong class="error">{{$errors->first('username')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="password">کلمه عبور</label>
                    <input type="text" class="form-control font-small" id="password" name="password"
                           placeholder="کلمه عبور">
                    @if ($errors->has('password'))
                        <strong class="error">{{$errors->first('password')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="phone">تلفن ثابت</label>
                    <input type="text" class="form-control font-small" id="phone" name="phone" placeholder="تلفن ثابت">
                    @if ($errors->has('phone'))
                        <strong class="error">{{$errors->first('phone')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="national_code">کد ملی</label>
                    <input type="text" class="form-control font-small" id="national_code" name="national_code"
                           placeholder="کد ملی">
                    @if ($errors->has('national_code'))
                        <strong class="error">{{$errors->first('national_code')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="level">نوع کاربری</label>
                    <select name="level" class="form-control select_level">
                        <option value="" selected>انتخاب کنید</option>
                        <option value="admin">مدریریت</option>
                        <option value="driver">راننده</option>
                    </select>
                    @if ($errors->has('level'))
                        <strong class="error">{{$errors->first('level')}}</strong>
                    @endif
                </div>

                <div class="form-group col-md-3 admin_roles">
                    <label for="national_cod">نقش</label>
                    <select name="role" class="form-control col-md-12">
                        <option></option>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3 car_number">
                    <label for="car_number">شماره پلاک ماشین</label>
                    <input type="text" class="form-control font-small col-md-12" id="car_number" name="car_number"
                           placeholder="شماره پلاک ماشین">
                </div>


                <div class="form-group col-md-12 mt-1">
                    <button type="submit" class="btn btn-outline-info mt-4">افزودن</button>
                </div>
            </form>
        </div>
    @endcan
@endsection