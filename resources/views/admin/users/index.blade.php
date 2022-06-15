@extends('admin.master')

@section('content')
    @cannot('show-users')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('show-users')
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">لیست کاربران</h4>
        </div>
        <div class="row">
            <div class="col-md-4 mx-auto">
                <a href="{{route('admin.users.create')}}" class="btn btn-outline-info btn-sm cursor-pointer"
                   data-toggle="tooltip" data-placement="right" title="افزودن کاربر">افزودن
                    کاربر</a>
            </div>
            <div class="col-md-3 text-left mx-auto">
                <a href="{{route('admin.roles.create')}}" class="btn btn-outline-success btn-sm cursor-pointer"
                   data-toggle="tooltip" data-placement="right" title="افزودن سطح دسترسی">افزودن
                    سطح
                    دسترسی</a>
            </div>
        </div>
        <div class="col-md-10 table-responsive mx-auto">
            <table class="table table-bordered rounded mt-2">
                <thead>
                <tr class="bg-info text-light text-center small">
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>نام کاربری</th>
                    <th>تلفن همراه</th>
                    <th>کد ملی</th>
                    <th>شماره پلاک</th>
                    <th>نقش</th>
                    <th>وضعیت</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="text-center small">
                        <td>{{$user->name}}</td>
                        <td>{{$user->last_name}}</td>
                        <td>{{$user->username}}</td>
                        <td>{{$user->mobile}}</td>
                        <td>{{$user->national_code ? $user->national_code : 'ندارد'}}</td>
                        <td>{{$user->car_number == null ? '----------' : $user->car_number}}</td>
                        @if($user->roles->first())
                            <td>{{$user->roles->first()->name}}</td>
                        @else
                            <td>راننده</td>
                        @endif
                        <td>
                            <label class="cl-switch">
                                <input class="check_active" type="checkbox" data-id="{{$user->id}}"
                                        {{$user->active == 1 ? 'checked' : ''}}>
                                <span class="switcher"></span>
                            </label>
                        </td>
                        <td>
                            <a href="{{route('admin.users.edit',['id' => $user->id])}}"
                               class="btn btn-outline-info btn-sm fa fa-edit" data-toggle="tooltip"
                               data-placement="right" title="ویرایش"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="col-md-12 mx-auto text-center">
                @if($users_count == 0)
                    <h5 class="text-danger"> موردی یافت نشد!</h5>
                @else
                    <h6 class="text-danger float-left">{{$users_count}} مورد یافت شد</h6>
                @endif
            </div>
            <div class="d-flex justify-content-center mr-n5">
                {{$users->links()}}
            </div>
        </div>
    @endcan
@endsection