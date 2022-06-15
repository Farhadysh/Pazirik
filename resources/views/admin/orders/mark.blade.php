@extends('admin.master')

@section('content')
    @cannot('show-orders')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('show-orders')
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">لیست سفارشات ستاره دار</h4>
        </div>
            <form class="form-row" action="{{route('admin.marks.mark_filter')}}" method="get">
                <div class="col-md-2 mr-3 pl-1">
                    <label for="mark_filter" class="small font-weight-bold">فیلتر</label>
                    <select class="form-control font-small" id="mark_filter" name="mark_filter">
                        <option value=""></option>
                        <option value="1">برسی نشده</option>
                        <option value="2">برسی شده</option>
                    </select>
                </div>
                <div class="col-md-2 mt-4 pt-2 pr-0">
                    <button class="btn btn-outline-info btn-sm" type="submit">جستوجو</button>
                </div>
            </form>
        <div class="col-md-12 table-responsive mx-auto">
            <table class="table table-bordered rounded mt-2">
                <thead>
                <tr class="bg-info text-light text-center small">
                    <th>مارک</th>
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>شماره موبایل</th>
                    <th>تلفن ثابت</th>
                    <th>شاخص آدرس</th>
                    <th>تاریخ ثبت سفارش</th>
                    <th>راننده</th>
                    <th>وضعیت</th>
                    <th>توضیحات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="text-center small">
                        <td class="px-0 pt-1"><input class="{{$order->mark->description == null ? 'star' : 'star text-success'}}" type="checkbox"
                                                     data-id="{{$order->id}}" {{$order->mark ? '' : 'checked'}} ></td>
                        <td>{{$order->user->name}}</td>
                        <td>{{$order->user->last_name}}</td>
                        <td>{{$order->user->mobile}}</td>
                        <td>{{$order->user->phone}}</td>
                        @if($order->address)
                            <td>{{$order->address->address_index}}</td>
                        @else
                            <td>آدرس ندارد</td>
                        @endif
                        <td>{{ $order->created_at}}</td>
                        @if($order->driver)
                            <td>{{$order->driver->name}} {{$order->driver->last_name}}</td>
                        @else
                            <td class="text-primary">فاکتور دستی</td>
                        @endif
                        <td class="text-{{$order->status['color']}}">{{$order->status['title']}}</td>
                        <td>
                            <button type="button" class="btn btn-outline-info btn-sm fa fa-sticky-note btn_modal_star"
                                    data-toggle="modal" data-target="#exampleModal" data-id="{{$order->mark->id}}"
                                    data-title="{{$order->mark->description}}"></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="col-md-12 mx-auto text-center">
                @if($orders_count == 0)
                    <h5 class="text-danger"> موردی یافت نشد!</h5>
                @else
                    <h6 class="text-danger float-left">{{$orders_count}} مورد یافت شد</h6>
                @endif
            </div>
            <div class="d-flex justify-content-center mr-n5">
                {{$orders->links()}}
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-info" id="exampleModalLabel">ثبت توضیحات</h5>
                    </div>
                    <form action="{{route('admin.marks.update_des')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <label for="description" class="small font-weight-bold">توضیحات</label>
                            <textarea type="text" class="form-control font-small" id="description" name="description"
                                      placeholder="توضیحات"></textarea>
                            <input class="mark_id" type="hidden" name="mark_id">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-success btn-sm ml-3">ثبت</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">بستن
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endcan
@endsection