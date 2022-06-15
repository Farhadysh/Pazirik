<html>
<head>
    <link rel="stylesheet" href="/css/factor.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-rtl.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
</head>
<body>
<div class="col-md-6 mx-auto shadow-sm">
    <div class="factor_body">
        <div class="fac_name">
            <div class="fac_style">
                <span>کارخانه  قالیشویی  قائم</span>
                <span> فاکتور مشتری: {{$factor->changeOrder->user->name}}  {{$factor->changeOrder->user->last_name}} <span></span></span>
            </div>
        </div>
        <div class="data">
            <div class="data_send">
                <span>تاریخ صدور :</span>
                <span>{{$factor->created_at}}</span>
            </div>
            <div class="data_delivery">
                <span>تاریخ تحویل :</span>
                <span>3 روز بعد</span>
            </div>
            <div class="span_style">
                <span>شماره :</span>
                <span>{{$factor->factor_id}}</span>
            </div>
        </div>
        <div class="factor_list">
            <div class="list_top">
                <div class="fac_lis_title">
                    <span>نوع فرش و اندازه</span>
                    <span>تعداد-متر</span>
                    <span>نقص</span>
                    <span>فی</span>
                    <span>اجرت کل</span>
                </div>
                @foreach($factor->changeFactorProducts as $products)
                    <div class="fac_lis_content">
                        <span>{{$products->product->id}}</span>
                        <span>{{$products->count}}</span>
                        <span>{{$products->defection ?? 'ندارد'}}</span>
                        <span>{{$products->price}}</span>
                        <span>{{$products->price * $products->count}}</span>
                    </div>
                @endforeach
            </div>
            <div class="list_bottom">
                <div class="service">
                    <span>خدمات :رفو،ریشه،سردوز،لکه گیری</span>
                    <span>{{$factor->service}}</span>
                </div>
                <div class="service">
                    <span>جمع آوری فرشها و انتقال آنها از طبقات</span>
                    <span>{{$factor->collecting}}</span>
                </div>
                <div class="service">
                    <span>حمل و نقل</span>
                    <span>{{$factor->transport}}</span>
                </div>
                <div class="service">
                    <span>تخفیف</span>
                    <span>{{$factor->discount}}</span>
                </div>
                <div class="service">
                    <span>اجرت کل</span>
                    <span>{{$total}}</span>
                </div>
            </div>
        </div>
        <div class="info_content">
            <div class="info_right">
                <div>
                    <span>ارتباط با مدیریت :09125730885</span>
                    <span>- (کیقبادی)</span>
                </div>


                <span>تماس با راننده:

            </span>

                <span>دفتر :خیابان نادر، فرعی شهید رحیمی، پلاک 17 ، آرایشگاه فرش ،تلفن :32241083-32233905</span>
                <span>کارخانه :کیلومتر5جاده مشهد،جنب مزار روستای بدشت ،تلفن :58294015</span>
                <span>توجه : امضای اولیه، نکاتی است که مشتری پس از مطالعه ی آن و آگاهی از نرخ نامه ، با امضای الکترونیکی تایید و مسئولیت آنها را به عهده گرفته است. </span>
                <span>توجه : امضای نهایی به منظور تحویل کامل و سالم سفارش به مشتری میباشد.</span>
            </div>
            <div class="info_left">
                <div class="left_top">
                    <span>امضای اولیه مشتری</span>

                    <img src="" alt=""
                         style="width:70px;height: 70px;margin-right: 40px;margin-top: 0">

                </div>
                <div class="left_bottom">
                    <span>امضای نهایی مشتری</span>

                    <div></div>

                    <img src="" alt=""
                         style="width:70px;height: 70px;margin-right: 40px;margin-top: 0">

                </div>
            </div>

        </div>
        <div class="btn_print">
            <button type="submit" onclick="window.print()">پرینت مجدد</button>
            <a href="">بازگشت</a>
        </div>
    </div>
</div>
</body>
</html>
