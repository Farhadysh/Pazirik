@extends('admin.master')

@section('content')
    @cannot('edit-users')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('edit-users')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">ویرایش کاربر</h4>
        </div>
        <div class="col-md-10 shadow-sm bg-white mx-auto rounded d-flex justify-content-center">
            <form action="{{route('admin.users.update',['id' => $user->id])}}" method="post"
                  class="border-0 rounded p-2 mt-3 mx-0 form-row">
                @csrf
                @method('PATCH')
                <div class="form-group col-md-3">
                    <label for="name">نام</label>
                    <input type="text" class="form-control font-small" id="name" name="name"
                           placeholder="نام" value="{{$user->name}}">
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
                    <label for="username">نام کاربری</label>
                    <input type="text" class="form-control font-small" id="username" name="username"
                           placeholder="نام کاربری" value="{{$user->username}}">
                    @if ($errors->has('username'))
                        <strong class="error">{{$errors->first('username')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="mobile">تلفن همراه</label>
                    <input type="text" class="form-control font-small" id="mobile" name="mobile"
                           placeholder="تلفن همراه" value="{{$user->mobile}}">
                    @if ($errors->has('mobile'))
                        <strong class="error">{{$errors->first('mobile')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="phone">تلفن ثابت</label>
                    <input type="text" class="form-control font-small" id="phone" name="phone"
                           placeholder="تلفن ثابت" value="{{$user->phone}}">
                    @if ($errors->has('phone'))
                        <strong class="error">{{$errors->first('phone')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="national_code">کد ملی</label>
                    <input type="text" class="form-control font-small" id="national_code" name="national_code"
                           placeholder="کد ملی" value="{{$user->national_code}}">
                    @if ($errors->has('national_code'))
                        <strong class="error">{{$errors->first('national_code')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="level">نوع کاربری</label>
                    <select name="level" class="form-control">
                        <option value="admin" {{$user->level == 'admin' ? 'selected' : ''}}>مدریریت</option>
                        <option value="driver" {{$user->level == 'driver' ? 'selected' : ''}}>راننده</option>
                    </select>
                    @if ($errors->has('level'))
                        <strong class="error">{{$errors->first('level')}}</strong>
                    @endif
                </div>
                @if($user->level == 'admin')
                    <div class="form-group col-md-3">
                        <label for="roles">نقش</label>
                        <select name="role" class="form-control col-md-12">
                            @foreach($roles as $role)
                                <option value="{{$role->id}}" {{$role->id == $user->roles->first()->id ? 'selected' : ''}}>{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="form-group col-md-3">
                        <label for="car_number">شماره پلاک ماشین</label>
                        <input type="text" class="form-control font-small col-md-12" id="car_number" name="car_number"
                               placeholder="شماره پلاک ماشین" value="{{$user->car_number}}">
                    </div>
                @endif

                <div class="form-group col-md-12 mt-1">
                    <button type="submit" class="btn btn-outline-info mt-3 btn-sm">ویرایش</button>
                </div>
            </form>
        </div>

        <div class="col-md-12 text-center text-dark">
            <h5 class="font-weight-bold my-4 text-muted">ویرایش کلمه عبور</h5>
        </div>
        <div class="col-md-10 shadow-sm bg-white mx-auto rounded p-4">
            <form class="form-row" action="{{route('admin.users.changePassword',['id'=>$user->id])}}" method="get">
                @csrf
                <div class="col-md-3">
                    <label for="password">کلمه عبور جدید</label>
                    <input name="password" type="text" class="form-control" placeholder="کلمه عبور جدید">
                    @if ($errors->has('password'))
                        <strong class="error">{{$errors->first('password')}}</strong>
                    @endif
                </div>
                <div class="col-md-3">
                    <label for="config_password">تکرار کلمه عبور</label>
                    <input name="config_password" type="text" class="form-control" placeholder="تکرار کلمه عبور">
                    @if ($errors->has('config_password'))
                        <strong class="error">{{$errors->first('config_password')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-12 mt-1">
                    <button type="submit" class="btn btn-outline-info mt-3 btn-sm">تغییر کلمه عبور</button>
                </div>
            </form>
        </div>
    @endcan
@endsection