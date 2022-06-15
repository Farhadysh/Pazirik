<html>
<head>
    <link rel="stylesheet" href="/css/factor.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-rtl.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
</head>
<body>
<div class="col-md-6 mx-auto p-3 bg-white shadow-sm my-5">
    <div class="col-md-12">
        <h5 class="mx-auto text-muted">فاکتور راننده</h5>
    </div>
    <div class="row px-5">
        <div class="col-md-5 py-4">
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item border-0 font-weight-bold px-0">نام:</li>
                <li class="list-group-item border-0 px-2">{{$factor->order->user->name}}</li>
            </ul>
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item border-0 font-weight-bold px-0">نام خانوادگی:</li>
                <li class="list-group-item border-0 px-2">{{$factor->order->user->last_name}}</li>
            </ul>
        </div>
        <div class="col-md-6 py-4">
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item border-0 font-weight-bold px-0">تلفن ثابت:</li>
                <li class="list-group-item border-0 px-2">{{$factor->order->user->phone}}</li>
            </ul>
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item border-0 font-weight-bold px-0">شماره موبایل:</li>
                <li class="list-group-item border-0 px-2">{{$factor->order->user->mobile}}</li>
            </ul>
        </div>
    </div>
    <div class="col-md-10 mx-auto border">
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item border-0 font-weight-bold px-0">آدرس تحویل:</li>
        </ul>
        <li class="list-group-item border-0 px-2">{{$factor->order->address->address_index}} {{$factor->order->address->address}}</li>
    </div>

        <div class="col-md-10 mx-auto mt-3">
            <button class="btn btn-sm btn-outline-dark fa fa-print" type="submit" onclick="window.print()">  پرینت مجدد</button>
            <a href="" class="btn btn-outline-dark btn-sm fa fa-arrow-left">  بازگشت</a>
        </div>


    {{--<div class="btn_print">
        <button type="submit" onclick="window.print()">پرینت مجدد</button>
        <a href="">بازگشت</a>
    </div>--}}
</div>
</body>
</html>
