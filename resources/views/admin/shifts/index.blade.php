@extends('admin.master')

@section('content')
    @cannot('show-shift')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('show-shift')
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">لیست شیفت ها</h4>
        </div>
        <div class="col-md-10 mx-auto">
            <div class=mx-auto">
                <a id="btn_search" class="btn btn-outline-info cursor-pointer fa fa-plus" data-toggle="tooltip"
                   data-placement="right" title="افزودن شیفت"></a>
            </div>
        </div>
        <div id="div_search" class="col-md-10 mx-auto p-3">
            @can('add-shift')
                <form action="{{route('admin.shifts.store')}}" class="form-row" method="post">
                    @csrf
                    <div class="form-group col-md-3">
                        <label for="from">ساعت شروع</label>
                        <input type="text" class="form-control font-small" id="from" name="from"
                               placeholder="از">
                        @if ($errors->has('from'))
                            <strong class="error small">{{$errors->first('from')}}</strong>
                        @endif
                    </div>
                    <div class="form-group col-md-3">
                        <label for="to">ساعت پایان</label>
                        <input type="text" class="form-control font-small" id="to" name="to" placeholder="تا">
                        @if ($errors->has('to'))
                            <strong class="error small">{{$errors->first('to')}}</strong>
                        @endif
                    </div>
                    <div class="form-group col-md-2 pt-2">
                        <button type="submit" class="btn btn-outline-info btn-sm mt-4">ثبت شیفت</button>
                    </div>
                </form>
            @endcan
        </div>
        <div class="col-md-10 table-responsive mx-auto">
            <table class="table table-bordered rounded mt-2">
                <thead>
                <tr class="bg-info text-light text-center small">
                    <th>از</th>
                    <th>تا</th>
                    <th>وضعیت</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shifts as $shift)
                    <tr class="text-center small">
                        <td>{{$shift->from}}</td>
                        <td>{{$shift->to}}</td>
                        <td class="{{$shift->getOriginal('active') == 1 ? 'text-success' : 'text-danger'}}">{{$shift->active}}</td>
                        <td>
                            <a href="{{route('admin.shifts.edit',['id' => $shift->id])}}"
                               class="btn btn-outline-info btn-sm fa fa-edit" data-toggle="tooltip"
                               data-placement="right" title="ویرایش"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="col-md-12 mx-auto text-center">
                @if($shifts_count == 0)
                    <h5 class="text-danger"> موردی یافت نشد!</h5>
                @else
                    <h6 class="text-danger float-left">{{$shifts_count}} مورد یافت شد</h6>
                @endif
            </div>
            <div class="d-flex justify-content-center mr-n5">
                {{$shifts->links()}}
            </div>
        </div>
    @endcan
@endsection