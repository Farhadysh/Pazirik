<nav class="col-12 col-md-2 bg-dark side_res text-light p-0 collapse show overflow-auto" id="sidebar">
    <ul class="nav flex-column px-0 ul_sidebar">
        <li class="nav-item d-flex align-items-center d_down_click pr-3">
            <span class="fa fa-dashboard"></span>
            <a href="/admin" class="nav-link my-1 cursor-pointer">داشبورد</a>
        </li>
        @can('show-customers')
            <li class="nav-item d-flex align-items-center d_down_click pr-3">
                <span class="fa fa-user"></span>
                <a class="nav-link my-1 cursor-pointer">مدیریت مشتریان</a>
                <span class="fa fa-caret-square-o-down mr-auto ml-2"></span>
            </li>
            <div class="d_down_1 hide">
                <li class="nav-item d-flex align-items-center pr-3">
                    <span class="fa fa-eye"></span>
                    <a href="{{route('admin.customers.index')}}" class="nav-link my-1 small text-warning">مشاهده
                        مشتریان</a>
                </li>
                @can('add-customer')
                    <li class="nav-item d-flex align-items-center pr-3">
                        <span class="fa fa-plus"></span>
                        <a href="{{route('admin.customers.create')}}" class="nav-link my-1 small text-warning">افزودن
                            مشتریان</a>
                    </li>
                @endcan
            </div>
        @endcan
        @can('show-handFactor')
            <li class="nav-item d-flex align-items-center d_down_click pr-3">
                <span class="fa fa-list"></span>
                <a class="nav-link my-1 cursor-pointer">فاکتور دستی</a>
                <span class="fa fa-caret-square-o-down mr-auto ml-2"></span>
            </li>
            <div class="d_down_1 hide">
                <li class="nav-item d-flex align-items-center pr-3">
                    <span class="fa fa-eye"></span>
                    <a href="{{route('admin.factors.index')}}" class="nav-link my-1 small text-warning">مشاهده
                        فاکتورها</a>
                </li>
                @can('add-handFactor')
                    <li class="nav-item d-flex align-items-center pr-3">
                        <span class="fa fa-plus"></span>
                        <a href="{{route('admin.factors.create')}}" class="nav-link my-1 small text-warning">افزودن
                            فاکتور</a>
                    </li>
                @endcan
            </div>
        @endcan
        @can('driver-locations')
            <li class="nav-item d-flex align-items-center pr-3">
                <span class="fa fa-car"></span>
                <a href="/admin/location" class="nav-link my-1">مشاهده محل راننده</a>
            </li>
        @endcan
        @can('show-waitingList')
            <li class="nav-item d-flex align-items-center pr-3">
                <span class="fa fa-arrow-circle-o-right"></span>
                <a href="{{route('admin.waits.index')}}" class="nav-link my-1">لیست انتظار</a>
            </li>
        @endcan
        @can('show-orders')
            <li class="nav-item d-flex align-items-center d_down_click pr-3">
                <span class="fa fa-book"></span>
                <a class="nav-link my-1 cursor-pointer">سفارشات</a>
                <span class="fa fa-caret-square-o-down mr-auto ml-2"></span>
            </li>
            <div class="d_down_1 hide">
                <li class="nav-item d-flex align-items-center pr-3">
                    <span class="fa fa-eye"></span>
                    <a href="{{route('admin.orders.index')}}" class="nav-link my-1 small text-warning">مشاهده سفارشات
                    </a>
                </li>
                <li class="nav-item d-flex align-items-center pr-3">
                    <span class="fa fa-star"></span>
                    <a href="{{route('admin.marks.index')}}" class="nav-link my-1 small text-warning">
                        سفارشات ستاره دار</a>
                </li>
            </div>
        @endcan
        @can('show-costs')
            <li class="nav-item d-flex align-items-center d_down_click pr-3">
                <span class="fa fa-dollar"></span>
                <a class="nav-link my-1 cursor-pointer">هزینه ها</a>
                <span class="fa fa-caret-square-o-down mr-auto ml-2"></span>
            </li>
            <div class="d_down_1 hide">
                <li class="nav-item d-flex align-items-center pr-3">
                    <span class="fa fa-eye"></span>
                    <a href="{{route('admin.costs.index')}}" class="nav-link my-1 small text-warning">مشاهده هزینه
                        ها</a>
                </li>
                @can('add-costs')
                    <li class="nav-item d-flex align-items-center pr-3">
                        <span class="fa fa-plus"></span>
                        <a href="{{route('admin.costs.create')}}" class="nav-link my-1 small text-warning">افزودن
                            هزینه</a>
                    </li>
                @endcan
            </div>
        @endcan
        @can('show-notes')
            <li class="nav-item d-flex align-items-center d_down_click pr-3">
                <span class="fa fa-sticky-note"></span>
                <a class="nav-link my-1 cursor-pointer">یادداشت ها</a>
                <span class="fa fa-caret-square-o-down mr-auto ml-2"></span>
            </li>
            <div class="d_down_1 hide">
                <li class="nav-item d-flex align-items-center pr-3">
                    <span class="fa fa-eye"></span>
                    <a href="{{route('admin.notes.index')}}" class="nav-link my-1 small text-warning">مشاهده
                        یادداشت
                        ها</a>
                </li>
                @can('add-notes')
                    <li class="nav-item d-flex align-items-center pr-3">
                        <span class="fa fa-plus"></span>
                        <a href="{{route('admin.notes.create')}}" class="nav-link my-1 small text-warning">افزودن
                            یادداشت</a>
                    </li>
                @endcan
            </div>
        @endcan

        <li class="nav-item d-flex align-items-center d_down_click pr-3">
            <span class="fa fa-calculator"></span>
            <a class="nav-link my-1 cursor-pointer">حسابداری</a>
            <span class="fa fa-caret-square-o-down mr-auto ml-2"></span>
        </li>
        <div class="d_down_1 hide">
            @can('show-accounting')
                <li class="nav-item d-flex align-items-center pr-3">
                    <span class="fa fa-money"></span>
                    <a href="{{route('admin.reports.accounting')}}"
                       class="nav-link my-1 small text-warning">مالی</a>
                </li>
            @endcan
            {{--@can('admin_accounting')--}}
            <li class="nav-item d-flex align-items-center pr-3">
                <span class="fa fa-dollar"></span>
                <a href="{{route('admin.reports.paid')}}"
                   class="nav-link my-1 small text-warning">غیرنقدی ها</a>
            </li>
            {{--@endcan--}}
            @can('show-product-list')
                <li class="nav-item d-flex align-items-center pr-3">
                    <span class="fa fa-product-hunt"></span>
                    <a href="{{route('admin.reports.productReports')}}"
                       class="nav-link my-1 small text-warning">گزارشات
                        کالا</a>
                </li>
        </div>
        @endcan
        @can('SMS')
            <li class="nav-item d-flex align-items-center d_down_click pr-3">
                <span class="fa fa-sticky-note"></span>
                <a class="nav-link my-1 cursor-pointer">پنل پیامکی</a>
                <span class="fa fa-caret-square-o-down mr-auto ml-2"></span>
            </li>
            <div class="d_down_1 hide">
                <li class="nav-item d-flex align-items-center pr-3">
                    <span class="fa fa-eye"></span>
                    <a href="{{--{{route('admin.SMS.fluttering')}}--}}"
                       class="nav-link my-1 small text-warning">نطرسنجی
                        ها</a>
                </li>
                @can('edit-Sms')
                    <li class="nav-item d-flex align-items-center pr-3">
                        <span class="fa fa-plus"></span>
                        <a href="{{route('admin.SMS.edit')}}" class="nav-link my-1 small text-warning">ویرایش
                            پیام
                            وضعیت
                            ها</a>
                    </li>
                @endcan
            </div>
        @endcan
        <li class="nav-item d-flex align-items-center d_down_click pr-3">
            <span class="fa fa-gear"></span>
            <a class="nav-link my-1 cursor-pointer">تنظیمات</a>
            <span class="fa fa-caret-square-o-down mr-auto ml-2"></span>
        </li>
        @can('show-products')
            <div class="d_down_1 hide mr-1">
                <li class="nav-item d-flex align-items-center d_down_click pr-3">
                    <span class="fa fa-sticky-note"></span>
                    <a class="nav-link my-1 cursor-pointer">مدیریت کالا ها</a>
                    <span class="fa fa-caret-square-o-down mr-auto ml-2"></span>
                </li>
                <div class="d_down_1 hide">
                    <li class="nav-item d-flex align-items-center pr-3">
                        <span class="fa fa-eye"></span>
                        <a href="{{route('admin.products.index')}}"
                           class="nav-link my-1 small text-warning">مشاهده
                            کالا
                            ها</a>
                    </li>
                    @can('add-product')
                        <li class="nav-item d-flex align-items-center pr-3">
                            <span class="fa fa-plus"></span>
                            <a href="{{route('admin.products.create')}}"
                               class="nav-link my-1 small text-warning">افزودن
                                کالا</a>
                        </li>
                    @endcan
                </div>
                @endcan
                @can('show-shift')
                    <li class="nav-item d-flex align-items-center pr-3">
                        <span class="fa fa-tasks "></span>
                        <a href="{{route('admin.shifts.index')}}" class="nav-link my-1">مدیریت شیفت</a>
                    </li>
                @endcan
                @can('show-users')
                    <li class="nav-item d-flex align-items-center d_down_click pr-3">
                        <span class="fa fa-cab"></span>
                        <a class="nav-link my-1 cursor-pointer">مدیریت کاربران</a>
                        <span class="fa fa-caret-square-o-down mr-auto ml-2"></span>
                    </li>
                    <div class="d_down_1 hide">
                        <li class="nav-item d-flex align-items-center pr-3">
                            <span class="fa fa-money"></span>
                            <a href="{{route('admin.users.index')}}"
                               class="nav-link my-1 small text-warning">مشاهده
                                کاربران</a>
                        </li>
                        @can('add-users')
                            <li class="nav-item d-flex align-items-center pr-3">
                                <span class="fa fa-product-hunt"></span>
                                <a href="{{route('admin.users.create')}}"
                                   class="nav-link my-1 small text-warning">افزودن
                                    کاربران</a>
                            </li>
                        @endcan
                    </div>
                @endcan
                @can('show-office')
                    <li class="nav-item d-flex align-items-center d_down_click pr-3">
                        <span class="fa fa-industry"></span>
                        <a class="nav-link my-1 cursor-pointer">افزودن دفتر و کارخانه</a>
                        <span class="fa fa-caret-square-o-down mr-auto ml-2"></span>
                    </li>
                    <div class="d_down_1 hide">
                        <li class="nav-item d-flex align-items-center pr-3">
                            <span class="fa fa-eye"></span>
                            <a href="{{route('admin.offices.index')}}"
                               class="nav-link my-1 small text-warning">مشاهده دفتر و کارخانه
                            </a>
                        </li>
                        @can('add-office')
                            <li class="nav-item d-flex align-items-center pr-3">
                                <span class="fa fa-plus"></span>
                                <a href="{{route('admin.offices.create')}}"
                                   class="nav-link my-1 small text-warning">افزودن
                                    دفتر و کارخانه</a>
                            </li>
                        @endcan
                    </div>
                @endcan
                <li class="nav-item d-flex align-items-center pr-3">
                    <span class="fa fa-sticky-note"></span>
                    <a href="{{route('admin.settings.index')}}" class="nav-link my-1">تغییر ثابت ها</a>
                </li>
            </div>
    </ul>
</nav>