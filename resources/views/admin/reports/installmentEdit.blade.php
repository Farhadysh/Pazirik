@extends('admin.master')

@section('content')
    @cannot('edit-installment')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('edit-installment')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">صورتحساب</h4>
        </div>
        <div class="col-md-8 shadow-sm bg-white mx-auto rounded p-4">


            <div class="mx-auto text-center p-4">
                <span class="font-weight-bold">نام مشتری:</span> <span>{{$factor->order->user->name}}</span>
                <span>{{$factor->order->user->last_name}}</span>
            </div>
            <div class="row my-3">
                <div class="col-md-4">
                    <span class="font-weight-bold">تاریخ ثبت سفارش:</span>
                    <span class="small">1/1/1397</span>
                </div>
                <div class="col-md-4">
                    <span class="font-weight-bold">شماره فاکتور:</span>
                    <span class="small">{{$factor->factor_id}}</span>
                </div>
                <div class="col-md-4">
                    <span class="font-weight-bold">نام راننده:</span>
                    @if($factor->order->driver)
                        <span class="small">{{$factor->order->driver->name}} {{$factor->order->driver->last_name}}</span>
                    @else
                        <span class="small">فاکتور دستی</span>
                    @endif
                </div>
            </div>
            <div class="row my-5">
                <div class="col-md-4">
                    <span class="small">قیمت کل:</span>
                    <span>
                    {{number_format($factor->FactorProducts->sum(function ($p){
                          return  $p->price * $p->count;
                        })
                        - $factor->discount
                        + $factor->transport
                        + $factor->service
                        + $factor->collecting)}}
                </span>
                </div>
                <div class="col-md-4">
                    <span class="small">میزان پرداخت:</span>
                    <span>{{number_format($factor->debtors->sum('cost'))}}</span>
                </div>
                <div class="col-md-4">
                    <span class="small">مانده حساب:</span>
                    <span>
                    {{number_format($factor->FactorProducts->sum(function ($p){
                          return  $p->price * $p->count;
                        })
                        - $factor->discount
                        + $factor->transport
                        + $factor->service
                        + $factor->collecting
                        - $factor->debtors->sum('cost')
                        )}}
                </span>
                    <strong class="text-danger" >{{$factor->debtors->sum('cost') == $factor->FactorProducts->sum(function ($p){
                              return  $p->price * $p->count;
                            })
                            - $factor->discount
                            + $factor->transport
                            + $factor->service
                            + $factor->collecting ? '(تسویه شده)' : ''}}
                    </strong>
                </div>
            </div>
            <div class="mr-5">
                <form action="{{route('admin.debtors.store')}}" class="form-row pr-5" method="post">
                    @csrf
                    <input name="factor_id" value="{{$factor->id}}" type="hidden">
                    <div class="form-group col-md-4">
                        <input class="money form-control" name="cost" id="" placeholder="مبلغ دریافتی">
                        @if ($errors->has('cost'))
                            <strong class="error">{{$errors->first('cost')}}</strong>
                        @endif
                    </div>
                    <input type="hidden" name="final_price" value="{{$factor->FactorProducts->sum(function ($p){
                          return  $p->price * $p->count;
                        })
                        - $factor->discount
                        + $factor->transport
                        + $factor->service
                        + $factor->collecting
                        - $factor->debtors->sum('cost')}}">
                    <div class="form-group col-md-4">
                        <input autocomplete="off" class="form-control" name="date" id="date" placeholder="تاریخ دریافت">
                        @if ($errors->has('date'))
                            <strong class="error">{{$errors->first('date')}}</strong>
                        @endif
                    </div>
                    <div class="form-group col-md-1">
                        <button class="btn btn-outline-success btn-sm reload" type="submit"
                                {{$factor->debtors->sum('cost') == $factor->FactorProducts->sum(function ($p){
                              return  $p->price * $p->count;
                            })
                            - $factor->discount
                            + $factor->transport
                            + $factor->service
                            + $factor->collecting ? 'disabled' : ''}}
                        >اعمال
                        </button>
                    </div>

            </div>
            <div class="col-md-10 mx-auto">
                <a class="btn btn-outline-info btn-sm m-2 cursor-pointer" id="{{$factor->debtors->sum('cost') == $factor->FactorProducts->sum(function ($p){
                              return  $p->price * $p->count;
                            })
                            - $factor->discount
                            + $factor->transport
                            + $factor->service
                            + $factor->collecting ? '' : 'btn_search'}}">چک</a>

                <div id="div_search" class="form-row">
                    <input type="hidden" name="factor_id" value="{{$factor->id}}">
                    <div class="form-group col-md-3">
                        <input class="form-control" name="cheque_date" id="cheque_date" placeholder="تاریخ چک">
                    </div>
                    <div class="form-group col-md-3">
                        <input class="form-control" name="cheque_number" id="cheque_number" placeholder="شماره چک">
                    </div>
                    </form>
                </div>
                <table class="table table-bordered rounded">
                    <tr class="small bg-warning">
                        <th class="text-center">مبلغ دریافتی</th>
                        <th class="text-center">تاریخ دریافت</th>
                        <th class="text-center">شماره چک</th>
                        <th class="text-center">تنطیمات</th>
                    </tr>
                    @foreach($factor->debtors as $debtor)
                        <tr>
                            <form action="{{route('admin.debtors.destroy',['id'=>$debtor->id])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <td class="text-center small">{{number_format($debtor->cost)}}</td>
                                <td class="text-center small">{{$debtor->date}}</td>
                                <td class="text-center small">
                                    @if($debtor->cheque)
                                        {{$debtor->cheque->cheque_number}}
                                    @else
                                        --------------
                                    @endif
                                </td>
                                <td class="text-center small">
                                    <button type="submit" class="btn btn-sm btn-outline-danger fa fa-trash"
                                            {{$factor->debtors->sum('cost') == $factor->FactorProducts->sum(function ($p){
                                                return  $p->price * $p->count;
                                                 })
                                                 - $factor->discount
                                                 + $factor->transport
                                                 + $factor->service
                                                 + $factor->collecting ? 'disabled' : ''}}>
                                    </button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </table>
                @if($factor->debtors->sum('cost') == $factor->FactorProducts->sum(function ($p){
                              return  $p->price * $p->count;
                            })
                            - $factor->discount
                            + $factor->transport
                            + $factor->service
                            + $factor->collecting)
                    <a href=""
                       class="btn btn-outline-danger btn-sm m-1 disabled">اعمال به عنوان تخفیف!</a>
                @else
                    <a href="{{route('admin.reports.checkOut',['id'=>$factor->id])}}"
                       class="btn btn-outline-danger btn-sm m-1">اعمال باقیمانده به عنوان تخفیف!</a>
                @endif
            </div>
        </div>
    @endcan
@endsection