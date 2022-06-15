<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductExport;
use App\Exports\ReportExport;
use App\Factor;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function accounting()
    {
        $order = new Order();
        $orders = $order->whereHas('factor');
        $orders_all = $orders
            ->where('status', 5)
            ->orderBy('created_at', 'DESC')
            ->get();

        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->where('active', 1)->get();

        $orders_count = $order->whereHas('factor')
            ->where('status', 5)
            ->count();

//***************total_Accounting*****************************************************************************/

        $data_all = [
            'transport' => 0,
            'collecting' => 0,
            'service' => 0,
            'sumService' => 0,
            'price' => 0,
            'total' => 0,
            'discount' => 0,
            'paid' => 0,
        ];


        foreach ($orders_all as $order) {

            $data_all['price'] += $order->factor->FactorProducts->sum(function ($p) {
                return $p->price * $p->count;
            });
            $data_all['transport'] += $order->factor->transport;
            $data_all['paid'] += $order->factor->debtors->sum('cost');
            $data_all['collecting'] += $order->factor->collecting;
            $data_all['service'] += $order->factor->service;
            $data_all['discount'] += $order->factor->discount;
            $data_all['sumService'] = $data_all['collecting'] + $data_all['transport'];
        }

        $data_all['total'] +=
            $data_all['transport'] +
            $data_all['collecting'] +
            $data_all['price'] +
            $data_all['service']
            - $data_all['discount'];

//***************page_accounting*****************************************************************************************/

        $orders = $order->whereHas('factor');
        $orders = $orders
            ->where('status', 5)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $data = [
            'transport' => 0,
            'collecting' => 0,
            'service' => 0,
            'sumService' => 0,
            'price' => 0,
            'total' => 0,
            'discount' => 0,
        ];


        foreach ($orders as $order) {

            $data['price'] += $order->factor->FactorProducts->sum(function ($p) {
                return $p->price * $p->count;
            });
            $data['transport'] += $order->factor->transport;
            $data['collecting'] += $order->factor->collecting;
            $data['service'] += $order->factor->service;
            $data['discount'] += $order->factor->discount;
            $data['sumService'] = $data_all['collecting'] + $data_all['transport'];
        }

        $data['total'] +=
            $data['transport'] +
            $data['collecting'] +
            $data['price'] +
            $data['service']
            - $data['discount'];

        return view(\request()->route()->getName())->with([
            'orders' => $orders,
            'data_all' => $data_all,
            'data' => $data,
            'drivers' => $drivers,
            'orders_count' => $orders_count
        ]);
    }

    public function paid()
    {
        $order = new Order();
        $orders = $order->whereHas('factor', function ($q) {
            $q->where('type', 2)->where('status', 1);
        })->paginate(10);

        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->where('active', 1)->get();

        return view('admin.reports.paid')->with([
            'orders' => $orders,
            'drivers' => $drivers,
        ]);

    }

    public function paidSearch(Request $request)
    {
        session([
            'last_name' => $request->last_name,
            'factor_id' => $request->factor_id,
            'address_index' => $request->address_index,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'driver_id' => $request->driver_id,
        ]);

        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->where('active', 1)->get();


        $order = new Order();
        $orders = $order->whereHas('factor', function ($q) {
            $q->where('type', 2)->where('status', 1);
        });

        if ($request->last_name) $orders = $orders->whereHas('user', function ($q) use ($request) {
            $q->where('last_name', 'LIKE', '%' . $request->last_name . '%');
        });
        if ($request->factor_id) $orders = $orders->whereHas('factor', function ($q) use ($request) {
            $q->where('factor_id', $request->factor_id);
        });
        if ($request->address_index) $orders = $orders->whereHas('address', function ($q) use ($request) {
            $q->where('address_index', 'LIKE', '%' . $request->address_index . '%');
        });

        if ($request->driver_id) $orders = $orders->where('driver_id', $request->driver_id);
        if ($request->start_date or $request->end_date)
            $orders = $orders->whereBetween('created_at', [$request->start_date, $request->end_date]);

        $orders = $orders
            ->orderBy('created_at', 'DESC')
            ->paginate(10);


        return view('admin.reports.paid')->with([
            'orders' => $orders,
            'drivers' => $drivers,
        ]);

    }

    public function paidExcel()
    {
        $order = new Order();
        $orders = $order->whereHas('factor', function ($q) {
            $q->where('type', 2)->where('status', 1);
        });

        if (session('last_name')) $orders = $orders->whereHas('user', function ($q) {
            $q->where('last_name', 'LIKE', '%' . session('last_name') . '%');
        });
        if (session('factor_id')) $orders = $orders->whereHas('factor', function ($q) {
            $q->where('factor_id', session('factor_id'));
        });


        if (session('address_index')) $orders = $orders->whereHas('address', function ($q) {
            $q->where('address_index', 'LIKE', '%' . session('address_index') . '%');
        });

        if (session('driver_id')) $orders = $orders->where('driver_id', session('driver_id'));
        if (session('start_date') or session('end_date'))
            $orders = $orders->whereBetween('created_at', [session('start_date'), session('end_date')]);

        $orders = $orders->get();

        $reportExcel[] = array([
            'نام و نام خانوادگی', 'تلفن همراه', 'تاریخ', 'راننده', 'شماره فاکتور', 'جمع فاکتور',
            'تخفیف', 'حمل و نقل', 'خدمات', 'انتقال از طبقات', 'روش پرداخت'
        ]);

        foreach ($orders as $order) {
            $reportExcel[] = array([
                'نام و نام خانوادگی' => $order->user->name . ' ' .$order->user->last_name,
                'تلفن همراه' => $order->user->mobile,
                'تاریخ' => $order->created_at,
                'راننده' => $order->driver->name . ' ' . $order->driver->last_name,
                'شماره فاکتور' => $order->factor->factor_id,
                'جمع فاکتور' => $order->factor->FactorProducts->sum(function ($p){return  $p->price * $p->count;}) - $order->factor->discount + $order->factor->transport + $order->factor->service + $order->factor->collecting,
                'تخفیف' => $order->factor->discount == null ? 0 : $order->factor->discount,
                'حمل و نقل' => $order->factor->transport,
                'خدمات' => $order->factor->service,
                'انتقال از طبقات' => $order->factor->collecting == null ? 0 : $order->factor->collecting,
                'روش پرداخت' => $order->factor->type['title'],
            ]);
        }

        session()->forget([
            'last_name', 'factor_id', 'pay_status', 'address_index',
            'start_date', 'end_date', 'driver_id'
        ]);


        $export = new ReportExport($reportExcel);
        return Excel::download($export, 'paidExcel.xlsx');



    }

    public function accountingSearch(Request $request)
    {
        session([
            'last_name' => $request->last_name,
            'factor_id' => $request->factor_id,
            'pay_status' => $request->pay_status,
            'address_index' => $request->address_index,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'driver_id' => $request->driver_id,
        ]);

        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->where('active', 1)->get();

        $order = new Order();
        $orders = $order->whereHas('factor');
        $orders_all = $orders
            ->where('status', 5)
            ->orderBy('created_at', 'DESC')
            ->get();

        $orders = new Order();
        $orders = $orders->whereHas('factor')->where('status', 5);

        if ($request->last_name) $orders = $orders->whereHas('user', function ($q) use ($request) {
            $q->where('last_name', 'LIKE', '%' . $request->last_name . '%');
        });
        if ($request->factor_id) $orders = $orders->whereHas('factor', function ($q) use ($request) {
            $q->where('factor_id', $request->factor_id);
        });

        if ($request->pay_status && $request->pay_status == 1) $orders = $orders->whereHas('factor', function ($q) use ($request) {
            $q->whereIn('type', [1, 3]);
        });

        if ($request->pay_status && $request->pay_status == 5) $orders = $orders->whereHas('factor', function ($q) use ($request) {
            $q->where('type', 2)->where('status', 2);
        });

        if ($request->pay_status && $request->pay_status == 2) $orders = $orders->whereHas('factor', function ($q) use ($request) {
            $q->where('type', 2);
        });


        if ($request->address_index) $orders = $orders->whereHas('address', function ($q) use ($request) {
            $q->where('address_index', 'LIKE', '%' . $request->address_index . '%');
        });

        if ($request->driver_id) $orders = $orders->where('driver_id', $request->driver_id);
        if ($request->start_date or $request->end_date)
            $orders = $orders->whereBetween('created_at', [$request->start_date, $request->end_date]);

        $orders_count = $orders->count();


//***************total_Accounting*****************************************************************************/

        $data_all = [
            'transport' => 0,
            'collecting' => 0,
            'service' => 0,
            'sumService' => 0,
            'price' => 0,
            'total' => 0,
            'discount' => 0,
            'paid' => 0,
        ];


        foreach ($orders_all as $order) {

            $data_all['price'] += $order->factor->FactorProducts->sum(function ($p) {
                return $p->price * $p->count;
            });
            $data_all['transport'] += $order->factor->transport;
            $data_all['paid'] += $order->factor->debtors->sum('cost');
            $data_all['collecting'] += $order->factor->collecting;
            $data_all['service'] += $order->factor->service;
            $data_all['discount'] += $order->factor->discount;
            $data_all['sumService'] = $data_all['collecting'] + $data_all['transport'];
        }

        $data_all['total'] +=
            $data_all['transport'] +
            $data_all['collecting'] +
            $data_all['price'] +
            $data_all['service']
            - $data_all['discount'];

//***************page_accounting*****************************************************************************************/
        $orders = $orders
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $data = [
            'transport' => 0,
            'collecting' => 0,
            'service' => 0,
            'sumService' => 0,
            'price' => 0,
            'total' => 0,
            'discount' => 0,
        ];


        foreach ($orders as $order) {

            $data['price'] += $order->factor->FactorProducts->sum(function ($p) {
                return $p->price * $p->count;
            });
            $data['transport'] += $order->factor->transport;
            $data['collecting'] += $order->factor->collecting;
            $data['service'] += $order->factor->service;
            $data['discount'] += $order->factor->discount;
            $data['sumService'] = $data_all['collecting'] + $data_all['transport'];
        }

        $data['total'] +=
            $data['transport'] +
            $data['collecting'] +
            $data['price'] +
            $data['service']
            - $data['discount'];


        return view('admin.reports.accounting')->with([
            'orders' => $orders->appends(Input::except('page')),
            'drivers' => $drivers,
            'data' => $data,
            'data_all' => $data_all,
            'orders_count' => $orders_count
        ]);
    }

    public function productReports()
    {
        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->get();

        $products = DB::table('products')
            ->select(DB::raw("SUM(factor_products.count) as finalProducts"), 'products.name', 'products.price', 'products.unit')
            ->join('factor_products', 'product_id', '=', 'products.id')
            ->where('products.active', 1)
            ->groupBy('products.id')
            ->get();

        return view(\request()->route()->getName())->with([
            'products' => $products,
            'drivers' => $drivers
        ]);
    }

    public function accountingExcel()
    {

        $orders = new Order();
        $orders = $orders->whereHas('factor')->where('status', 5);

        if (session('last_name')) $orders = $orders->whereHas('user', function ($q) {
            $q->where('last_name', 'LIKE', '%' . session('last_name') . '%');
        });
        if (session('factor_id')) $orders = $orders->whereHas('factor', function ($q) {
            $q->where('factor_id', session('factor_id'));
        });

        if (session('pay_status') && session('pay_status') == 1) $orders = $orders->whereHas('factor', function ($q) {
            $q->whereIn('type', [1, 3]);
        });

        if (session('pay_status') && session('pay_status') == 5) $orders = $orders->whereHas('factor', function ($q) {
            $q->where('type', 2)->where('status', 2);
        });

        if (session('pay_status') && session('pay_status') == 2) $orders = $orders->whereHas('factor', function ($q) {
            $q->where('type', 2);
        });


        if (session('address_index')) $orders = $orders->whereHas('address', function ($q) {
            $q->where('address_index', 'LIKE', '%' . session('address_index') . '%');
        });

        if (session('driver_id')) $orders = $orders->where('driver_id', session('driver_id'));
        if (session('start_date') or session('end_date'))
            $orders = $orders->whereBetween('created_at', [session('start_date'), session('end_date')]);

        $orders = $orders->get();

        $reportExcel[] = array([
            'نام و نام خانوادگی', 'تلفن همراه', 'تاریخ', 'راننده', 'شماره فاکتور', 'جمع فاکتور',
            'تخفیف', 'حمل و نقل', 'خدمات', 'انتقال از طبقات', 'روش پرداخت'
        ]);

        foreach ($orders as $order) {
            $reportExcel[] = array([
                'نام و نام خانوادگی' => $order->user->name . ' ' .$order->user->last_name,
                'تلفن همراه' => $order->user->mobile,
                'تاریخ' => $order->created_at,
                'راننده' => $order->driver->name . ' ' . $order->driver->last_name,
                'شماره فاکتور' => $order->factor->factor_id,
                'جمع فاکتور' => $order->factor->FactorProducts->sum(function ($p){return  $p->price * $p->count;}) - $order->factor->discount + $order->factor->transport + $order->factor->service + $order->factor->collecting,
                'تخفیف' => $order->factor->discount == null ? 0 : $order->factor->discount,
                'حمل و نقل' => $order->factor->transport,
                'خدمات' => $order->factor->service,
                'انتقال از طبقات' => $order->factor->collecting == null ? 0 : $order->factor->collecting,
                'روش پرداخت' => $order->factor->type['title'],
            ]);
        }

        session()->forget([
            'last_name', 'factor_id', 'pay_status', 'address_index',
            'start_date', 'end_date', 'driver_id'
        ]);


        $export = new ReportExport($reportExcel);
        return Excel::download($export, 'accountingExcel.xlsx');

    }


    public function searchProducts(Request $request)
    {
        $d = [];
        if ($request->driver_id) {
            $d[] = $request->driver_id;
        } else {
            $d = User::select('id')->where('level', 'driver')->get();
        }

        if ($request->address_index) {
            $adr = $request->address_index;
        } else {
            $adr = '';
        }

        if ($request->start_date) {
            $s = $request->start_date;
        } else {
            $s = "1350/01/01";
        }

        if ($request->end_date) {
            $e = $request->end_date;
        } else {
            $e = "2000/01/01";
        }

        $drivers = new User();
        $drivers = $drivers->where('level', 'driver')->where('active', 1)->get();

        $products = DB::table('products')
            ->select(DB::raw("SUM(factor_products.count) as finalProducts"), 'products.name',
                'products.price', 'products.unit')
            ->join('factor_products', 'product_id', '=', 'products.id')
            ->join('factors', 'factors.id', '=', 'factor_products.factor_id')
            ->join('orders', 'orders.id', '=', 'factors.order_id')
            ->join('addresses', 'addresses.id', '=', 'orders.address_id')
            ->where('products.active', 1)
            ->whereIn('factor_products.factor_id', function ($query) use ($e, $s, $adr, $d) {
                $query->select('id')
                    ->from('factors')
                    ->whereIn('orders.address_id', function ($query) use ($e, $s, $adr, $d) {
                        $query->select('id')
                            ->from('addresses')
                            ->whereIn('orders.driver_id', $d)
                            ->where('addresses.address_index', 'LIKE', '%' . $adr . '%')/*->whereDate('orders.date', '<=' ,$e)
                            ->whereDate('orders.date', '>=' ,$s)*/
                        ;
                    });
            })
            ->groupBy('products.id')
            ->get();

        return view('admin.reports.productReports')->with([
            'products' => $products,
            'drivers' => $drivers
        ]);
    }

    public function productExcel()
    {
        $products = DB::table('products')
            ->select(DB::raw("SUM(factor_products.count) as finalProducts"), 'products.name', 'products.price', 'products.unit')
            ->join('factor_products', 'product_id', '=', 'products.id')
            ->where('products.active', 1)
            ->groupBy('products.id')
            ->get();


        $productExcel[] = array([
            'نام کالا', 'تعداد شسته شده ها', 'واحد', 'فی'
        ]);

        foreach ($products as $product) {
            $productExcel[] = array([
                'نام کالا' => $product->name,
                'تعداد شسته شده ها' => $product->finalProducts,
                'واحد' => $product->unit,
                'فی' => $product->price,
            ]);
        }

        session()->forget([
            'last_name', 'factor_id', 'pay_status', 'address_index',
        ]);


        $export = new ProductExport($productExcel);
        return Excel::download($export, 'productExcel.xlsx');

    }

    public function checkOut(Factor $factor)
    {
        $cost = $factor->debtors->sum('cost');
        $price = $factor->FactorProducts->sum(function ($p) {
                return $p->price * $p->count;
            })
            - $factor->discount
            + $factor->transport
            + $factor->service
            + $factor->collecting;

        $final_price = $price - $cost;

        $factor->discount += $final_price;
        $factor->status = 2;
        $factor->save();

        alert()->success('با موفقیت اعمال شد');

        return redirect()->route('admin.reports.accounting');

    }
}
