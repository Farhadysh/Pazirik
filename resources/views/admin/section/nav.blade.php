<nav class="main-header navbar sticky-top bg-white navbar-expand-md navbar-light p-0 border-bottom">
    <div class="d-flex align-items-center bg-dark nav_res">
        <span class="fa fa-align-right mx-3 text-light fa-2x" data-toggle="collapse" data-target="#sidebar"></span>
        <a href="#" class="navbar-brand py-3 px-4 m-0 h3 text-light" style="width: 164px">پنل مدیریت </a>
        <img class="mr-5 logo_res" src="/img/pazyryk.png" width="50">
    </div>
    <div class="collapse navbar-collapse main-header">
        <img class="mr-5" src="/img/pazyryk.png" width="50">
        <div class="ml-3 mr-auto">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    @can('add-customer')
                        <a href="{{route('admin.customers.create')}}"
                           class="btn btn-sm btn-outline-success p-2 rounded-lg ml-2"><i class="fa fa-plus"></i> افزودن
                            مشتری</a>
                    @endcan
                    <a href="#" class="fa fa-sticky-note-o nav-link">
                        <span class="badge badge-danger navbar-badge">{{$notes_count}}</span>
                    </a>
                    @can('show-changes')
                        <a href="#" data-toggle="dropdown" class="fa fa-bell-o nav-link">
                            <span class="badge badge-danger navbar-badge">{{$change_count}}</span>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                                <a class="dropdown-item">
                                    <!-- Message Start -->
                                    <div class="media">
                                        <div class="media-body text-center">
                                            <h3 class="dropdown-item-title m-0 text-muted">
                                                شما <span
                                                        class="count_change bg-danger text-white px-2 rounded-circle">{{--{{$change}}--}}</span>
                                                فاکتور تغییر داده شده دارید.
                                            </h3>
                                        </div>
                                    </div>
                                    <!-- Message End -->
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{route('admin.changes.index')}}"
                                   class="dropdown-item dropdown-footer text-center text-info">مشاهده فاکتور ها</a>
                            </div>
                        </a>
                    @endcan
                </li>
                <li class="bav-item">
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <button class="nav-link btn fa fa-sign-out"
                                data-toggle="tooltip"
                                data-placement="bottom" title="خروج"
                        ></button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>