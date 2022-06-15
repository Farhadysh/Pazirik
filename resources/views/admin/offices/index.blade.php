@extends('admin.master')

@section('content')
    @cannot('show-costs')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('show-costs')
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">لیست دفاتر و کارخانه ها</h4>
        </div>
        <div class="col-md-10 table-responsive mx-auto">
            <table class="table table-bordered rounded mt-2">
                <thead>
                <tr class="bg-info text-light text-center small">
                    <th>نام دفتر</th>
                    <th>نام مسئول دفتر</th>
                    <th>شماره تلفن</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($offices as $office)
                    <tr class="text-center">
                        <td>{{$office->office_name}}</td>
                        <td>{{$office->user->name}} {{$office->user->last_name}}</td>
                        <td>{{$office->phone}}</td>
                        <td>
                            <form class="form_destroy" data-id="{{$office->id}}" data-name="offices">
                                @csrf
                                <a href="{{route('admin.offices.edit',['id'=>$office->id])}}"
                                   class="btn btn-sm btn-outline-info fa fa-edit"
                                   data-toggle="tooltip"  data-placement="right" title="ویرایش"></a>
                                @can('delete-costs')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger fa fa-trash"
                                            data-toggle="tooltip"  data-placement="right" title="حذف"></button>
                                @endcan
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--<div class="col-md-12 mx-auto text-center">
                @if($costs_count == 0)
                    <h5 class="text-danger"> موردی یافت نشد!</h5>
                @else
                    <h6 class="text-danger float-left">{{$costs_count}} مورد یافت شد</h6>
                @endif
            </div>--}}

            <div class="d-flex justify-content-center mr-n5">
                {{--{{$costs->links()}}--}}
            </div>
        </div>
    @endcan
@endsection