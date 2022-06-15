<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\ChangeAddress;
use App\ChangeFactor;
use App\ChangeFactorProduct;
use App\ChangeOrder;
use App\ChangeStatus;
use App\Exports\FactorExport;
use App\Factor;
use App\FactorProduct;
use App\Http\Controllers\AdminController;
use App\Office;
use App\Order;
use App\Permission;
use App\Product;
use App\Setting;
use App\SMS;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use function Sodium\increment;

class FactorController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = new Order();
        $orders = $order->where('driver_id', null)
            ->whereIn('status', [3, 4])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $orders_count = $order->where('driver_id', null)
            ->whereIn('status', [3, 4])
            ->count();

        return view(\request()->route()->getName())->with([
            'orders' => $orders,
            'orders_count' => $orders_count
        ]);
    }


    public function search(Request $request)
    {
        session([
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
            'date' => $request->date,
        ]);


        $orders = new Order();
        $orders = $orders->where('driver_id', null)
            ->whereIn('status', [3, 4])
            ->orderBy('created_at', 'DESC');


        if ($request->last_name) $orders = $orders->whereHas('user', function ($q) use ($request) {
            $q->where('last_name', 'LIKE', '%' . $request->last_name . '%');
        });
        if ($request->mobile) $orders = $orders->whereHas('user', function ($q) use ($request) {
            $q->where('mobile', $request->mobile);
        });

        if ($request->date) $orders = $orders->where('date', $request->date);

        $orders_count = $orders->count();

        $orders = $orders->paginate(10);


        return view('admin.factors.index')->with([
            'orders' => $orders->appends(Input::except('page')),
            'orders_count' => $orders_count
        ]);

    }

    public function factorExcel()
    {
        $order = new Order();
        $orders = $order->where('driver_id', null)
            ->whereIn('status', [3, 4])
            ->orderBy('created_at', 'DESC');


        if (session('last_name')) $orders = $orders->whereHas('user', function ($q) {
            $q->where('last_name', 'LIKE', '%' . session('last_name') . '%');
        });
        if (session('mobile')) $orders = $orders->whereHas('user', function ($q) {
            $q->where('mobile', session('mobile'));
        });

        if (session('date')) $orders = $orders->where('date', session('date'));

        $orders = $orders->get();



        $factorExcel[] = array([
            'نام و نام خانوادگی', 'موبایل', 'تلفن ثابت', 'وضعیت', 'تاریخ ثبت سفارش'
        ]);

        foreach ($orders as $order) {
            $factorExcel[] = array([
                'نام مشتری' => $order->user->name . ' - ' . $order->user->last_name,
                'موبایل' => $order->user->mobile,
                'تلفن ثابت' => $order->user->phone,
                'وضعیت' => $order->status['title'],
                'تاریخ ثبت سفارش' => $order->date,
            ]);
        }

        session()->forget([
            'last_name', 'mobile', 'date'
        ]);

        $export = new FactorExport($factorExcel);
        return Excel::download($export, 'orders.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = new Product();
        $products = $products->orderBy('level', 'ASC')->get();

        $offices = new Office();
        $offices = $offices->get();

        return view(\request()->route()->getName())->with([
            'products' => $products,
            'offices' => $offices
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'transport' => str_replace(',', '', $request->input('transport')),
            'service' => str_replace(',', '', $request->input('service'))
        ]);


        $active = new SMS();
        $active = $active->where('status', 3)->first();

        $request->validate([
            'mobile' => 'required|numeric',
            'transport' => 'integer|nullable',
            'service' => 'integer|nullable',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'date' => 'required'
        ]);

        $status = new Office();
        $status = $status->where('id', $request->receive_in)->first();

        $address_id = null;
        if ($request->input('user_id')) {

            $user = User::find($request->user_id);

            if ($request->input('address')) {
                $address = $user->addresses()->create([
                    'user_id' => $request->input('user_id'),
                    'address' => $request->input('address'),
                    'address_index' => $request->input('address_index'),
                ]);
                $address_id = $address->id;

            } else if ($request->input('address_id')) {
                $address = Address::find($request->input('address_id'));
                $address_id = $address->id;
            }

            $order = new Order();
            $order->user_id = $request->input('user_id');
            $order->address_id = $address_id;
            $order->shift_id = $request->input('shift_id');
            $order->date = $request->input('date');
            $order->status = $status->status;
            $order->office_id = $status->id;
            $order->description = $request->input('description_adr');
            $order->save();

            $order->ChangeStatuses()->create([
                'date' => now(),
                'status' => 1,
                'user_id' => auth()->user()->id
            ]);

            $rand = time();
            $factor = new Factor();
            $factor->factor_id = $rand;
            $factor->order_id = $order->id;
            $factor->date = $request->date;
            if ($request->service) {
                $factor->service = str_replace(',', '', $request->service);
            }
            if ($request->transport) {
                $factor->transport = str_replace(',', '', $request->transport);
            }
            $factor->save();

            $product_list = json_decode($request->input('product_list'));

            foreach ($product_list as $product) {
                FactorProduct::create([
                    'factor_id' => $factor->id,
                    'product_id' => $product->id,
                    'count' => $product->count,
                    'price' => $product->price * $product->count,
                    'defection' => $product->defection
                ]);
                $washCount = Product::where('id', $product->id);
                $washCount->increment('washCount', $product->count);
            }


            $mobile = $user->mobile;
            $pattern = '104';
            $data = 'کالای شما دریافت شد';
            if ($active->active == 1) {
                $this->send($mobile, $pattern, $data);
            }
            return $factor->id;

        } else {

            $user = new User();
            $user->name = $request->input('name');
            $user->last_name = $request->input('last_name');
            $user->mobile = $request->input('mobile');
            $user->phone = $request->input('phone');
            $user->save();


            if ($request->input('address')) {
                $address = $user->addresses()->create([
                    'address' => $request->address,
                    'address_index' => $request->input('address_index'),
                ]);
                $address_id = $address->id;
            }

            $order = $user->orders()->create([
                'address_id' => $address_id,
                'date' => $request->input('date'),
                'status' => $status->status,
                'office_id' => $status->id,
                'description' => $request->input('description_adr')
            ]);

            ChangeStatus::create([
                'order_id' => $order->id,
                'date' => now(),
                'status' => 1,
                'user_id' => auth()->user()->id
            ]);

            $rand = time();
            $factor = new Factor();
            $factor->factor_id = $rand;
            $factor->order_id = $order->id;
            $factor->date = $request->date;
            if ($request->service) {
                $factor->service = str_replace(',', '', $request->service);
            }
            if ($request->transport) {
                $factor->transport = str_replace(',', '', $request->transport);
            }
            $factor->save();

            $product_list = json_decode($request->input('product_list'));

            foreach ($product_list as $product) {
                FactorProduct::create([
                    'factor_id' => $factor->id,
                    'product_id' => $product->id,
                    'count' => $product->count,
                    'price' => $product->price * $product->count,
                    'defection' => $product->defection
                ]);
                $washCount = Product::where('id', $product->id);
                $washCount->increment('washCount', $product->count);
            }

            $mobile = $user->mobile;
            $pattern = '104';
            $data = 'کالای شما دریافت شد';
            if ($active->active == 1) {
                $this->send($mobile, $pattern, $data);
            }
            return $factor->id;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Factor $factor
     * @return \Illuminate\Http\Response
     */
    public function show(Factor $factor)
    {
        $setting = new Setting();
        $factorDescription = $setting->where('key','factorDescription')->first();

        $total = $factor->FactorProducts->sum(function ($p) {
                return $p->price * $p->count;
            })
            - $factor->discount
            + $factor->transport
            + $factor->service
            + $factor->collecting;

        return view(\request()->route()->getName())->with([
            'factor' => $factor,
            'total' => $total,
            'factorDescription' => $factorDescription
        ]);
    }

    public function driver_factor(Factor $factor)
    {
        return view('admin.factors.driver_factor')->with([
            'factor' => $factor
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Factor $factor
     * @return \Illuminate\Http\Response
     */
    public function edit(Factor $factor)
    {
        $products = new Product();
        $products = $products->orderBy('level', 'ASC')->get();

        $offices = new Office();
        $offices = $offices->get();

        return view(\request()->route()->getName())->with([
            'factor' => $factor,
            'products' => $products,
            'offices' => $offices
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Factor $factor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factor $factor)
    {

        $request->merge([
            'transport' => str_replace(',', '', $request->input('transport')),
            'service' => str_replace(',', '', $request->input('service'))
        ]);

        $request->validate([
            'mobile' => 'required|numeric',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'transport' => 'integer|nullable',
            'service' => 'integer|nullable',
            'phone' => 'required',
            'date' => 'required'
        ]);


        $status = new Office();
        $status = $status->where('id', $request->receive_in)->first();

        User::where('id', $request->user_id)->update([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'mobile' => $request->input('mobile'),
            'phone' => $request->input('phone')
        ]);

        $address_id = null;
        if ($request->input('address')) {

            ChangeAddress::create([
                'user_id' => $factor->order->user_id,
                'old_id' => $factor->order->address_id,
                'address' => $factor->order->address->address,
                'address_index' => $factor->order->address->address_index,
            ]);

            $address = $factor->order()->address->update([
                'address' => $request->address,
                'address_index' => $request->input('address_index'),
            ]);

            $address_id = $address->id;
        }


        ChangeOrder::create([
            'old_id' => $factor->order->id,
            'user_id' => $factor->order->user_id,
            'shift_id' => $factor->order->shift_id,
            'driver_id' => $factor->order->driver_id,
            'address_id' => $address_id,
            'date' => $factor->order->date,
            'status' => $factor->order->status,
            'office_id' => $factor->order->office_id,
            'description' => $factor->order->description
        ]);

        $factor->order()->update([
            'address_id' => $address_id,
            'date' => $request->input('date'),
            'status' => $status->status,
            'office_id' => $status->id,
            'description' => $request->input('description_adr')
        ]);

        ChangeFactor::create([
            'old_id' => $factor->id,
            'factor_id' => $factor->factor_id,
            'order_id' => $factor->order_id,
            'date' => $factor->date,
            'transport' => $factor->transport,
            'discount' => $factor->discount,
            'service' => $factor->service,
            'type' => $factor->type,
            'collecting' => $factor->collecting,
            'status' => $factor->status,
        ]);

        foreach ($factor->factorProducts() as $factorProduct) {
            ChangeFactorProduct::create([
                'old_id' => $factorProduct->id,
                'factor_id' => $factorProduct->factor_id,
                'product_id' => $factorProduct->product_id,
                'count' => $factorProduct->count,
                'price' => $factorProduct->price,
                'defection' => $factorProduct->defection,
            ]);
        }

        $factor->date = $request->date;
        $factor->transport = str_replace(',', '', $request->transport);
        $factor->service = str_replace(',', '', $request->service);
        $factor->save();

        alert()->success('با موفقیت ویرایش شد');

        return redirect()->route('admin.factors.show', ['id' => $factor->id]);

    }

    public function addNote(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);

        Factor::where('id',$request->factor_id)->update([
            'description' => $request->description
        ]);

        alert()->success('با موفقیت ثبت شد');

        return redirect()->back();
    }

    public function ProductFactor_create(Request $request)
    {
        $factor_id = $request->factor_id;

        $product_price = new Product();
        $product_price = $product_price->where('id', $request->input('products'))->first();
        $product_price = $product_price->price;

        $count = $request->count;

        FactorProduct::create([
            'factor_id' => $factor_id,
            'product_id' => $request->input('products'),
            'count' => $count,
            'defection' => $request->input('defection'),
            'price' => $product_price * $count

        ]);

        return redirect()->back();
    }

    public function ProductFactor_destroy(FactorProduct $factorProduct)
    {
        try {
            $factorProduct->delete();
        } catch (\Exception $e) {
        }

        alert()->success('با موفقیت حذف شد.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Factor $factor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factor $factor)
    {
        //
    }

    /**
     * @param Factor $factor
     * @return Factor|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function installmentEdit(Factor $factor)
    {
        return view('admin.reports.installmentEdit')->with([
            'factor' => $factor
        ]);
    }
}
