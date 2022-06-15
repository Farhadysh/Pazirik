@extends('admin.master')

@section('content')
    @cannot('show-customers')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('show-customers')
        <div class="col-md-12 text-left">
            <a href="{{route('admin.customers.excel')}}"
               class="btn btn-outline-info btn-sm cursor-pointer"><i class="fa fa-list"></i> لیست مشتریان</a>
        </div>
        <div id="preloader"></div>
        <div id="all_page">
            <div class="col-md-12 text-center text-dark">
                <h4 class="font-weight-bold my-4 text-muted">لیست مشتریان</h4>
            </div>
            <div class="row">
                <div class="col-md-4 mx-auto">
                    <a id="btn_search" class="btn btn-outline-warning cursor-pointer fa fa-search"></a>
                </div>
                <div class="col-md-3 text-left mx-auto">
                    <a href="{{route('admin.customers.create')}}"
                       class="btn btn-outline-success cursor-pointer fa fa-plus"
                       data-toggle="tooltip"  data-placement="right" title="افزودن مشتری"></a>
                </div>
            </div>
            <div id="div_search" class="col-md-10 mx-auto">
                <form action="{{route('admin.customers.search')}}" class="border-0 rounded p-2 mt-3 mx-0 form-row">
                    <div class="form-group col-md-3">
                        <label for="last_name">نام مشتری</label>
                        <input type="text" class="form-control font-small" id="last_name" name="last_name"
                               placeholder="نام مشتری">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="mobile">موبایل</label>
                        <input type="text" class="form-control font-small" id="mobile" name="mobile"
                               placeholder="موبایل">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="phone">تلفن ثابت</label>
                        <input type="text" class="form-control font-small" id="phone" name="phone"
                               placeholder="تلفن ثابت">
                    </div>
                    <div class="form-group col-md-3 mt-1">
                        <button type="submit" class="btn btn-outline-info btn-sm" style="margin-top: 28px">جست و جو
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-10 table-responsive mx-auto">
                <table class="table table-bordered rounded mt-2">
                    <thead>
                    <tr class="bg-info text-light text-center small">
                        <th>نام</th>
                        <th>نام خانوادگی</th>
                        <th>شماره موبایل</th>
                        <th>تلفن ثابت</th>
                        <th>تنظیمات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="text-center small">
                            <td>{{$user->name}}</td>
                            <td>{{$user->last_name}}</td>
                            <td>{{$user->mobile}}</td>
                            <td>{{$user->phone}}</td>
                            <td>
                                <a href="{{route('admin.customers.edit',['id'=>$user->id])}}"
                                   class="btn btn-sm btn-outline-info fa fa-edit font-weight-bold"
                                   data-toggle="tooltip"  data-placement="right" title="ویرایش"></a>
                                    <a href="{{route('admin.customers.show',['id'=>$user->id])}}"
                                       class="btn btn-sm btn-outline-dark fa fa-user font-weight-bold"
                                       data-toggle="tooltip"  data-placement="right" title="نمایش آدرس"></a>
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
        </div>
    @endcan
@endsection