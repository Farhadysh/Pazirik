@extends('admin.master')

@section('content')
<div class="col-md-12 text-center text-dark">
    <h4 class="font-weight-bold my-4 text-muted">تحویل به مشتری</h4>
</div>
<div class="col-md-10 shadow-sm bg-white mx-auto rounded d-flex justify-content-center">
    <form action="{{route('admin.orders.Delivered_To_customer',['id'=>$order->id])}}"
          class="border-0 rounded p-2 mt-3 mx-auto form-row" method="post">
        @csrf
        <div class="form-group col-md-5">
            <label for="type">نوع پرداخت</label>
            <select class="form-control" name="type">
                <option value="1">پول نقد</option>
                <option value="2">اقساطی</option>
                <option value="3">کارتخوان</option>
            </select>
        </div>
        <div class="form-group col-md-5">
            <label for="discount">تخفیف</label>
            <input type="text" class="form-control font-small" id="discount" name="discount" placeholder="تخفیف">
        </div>
        <div class="form-group col-md-2 mt-1">
            <button type="submit" class="btn btn-outline-info mt-4">تحویل</button>
        </div>
    </form>
</div>
@endsection