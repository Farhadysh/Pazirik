@extends('admin.master')
@section('content')
    @cannot('edit-products')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('edit-products')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">ویرایش کالا</h4>
        </div>
        <div class="col-md-10 shadow-sm bg-white mx-auto rounded d-flex justify-content-center">
            <form action="{{route('admin.products.update',['id' => $product->id])}}" method="post"
                  class="border-0 rounded p-2 mt-3 mx-0 form-row">
                @csrf
                @method('PATCH')
                <div class="form-group col-md-2">
                    <label for="level">شماره</label>
                    <input type="text" class="form-control font-small" id="level" name="level"
                           placeholder="شماره" value="{{$product->level}}">
                    @if ($errors->has('level'))
                        <strong class="error">{{$errors->first('level')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="name">نام</label>
                    <input type="text" class="form-control font-small" id="name" name="name"
                           placeholder="نام" value="{{$product->name}}">
                    @if ($errors->has('name'))
                        <strong class="error">{{$errors->first('name')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="price">قیمت</label>
                    <input type="text" class="money form-control font-small" id="price" name="price"
                           placeholder="قیمت" value="{{$product->price}}">
                    @if ($errors->has('price'))
                        <strong class="error">{{$errors->first('price')}}</strong>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="unit">واحد</label>
                    <select class="form-control" name="unit" id="unit">
                        <option value="عدد" {{$product->unit == 'عدد' ? 'selected' : ''}}>عدد</option>
                        <option value="متر" {{$product->unit == 'متر' ? 'selected' : ''}}>متر</option>
                    </select>
                    @if ($errors->has('unit'))
                        <strong class="error">{{$errors->first('unit')}}</strong>
                    @endif
                </div>

                <div class="form-group col-md-3 mt-1">
                    <button type="submit" class="btn btn-outline-info mt-4">ویرایش</button>
                </div>
            </form>
        </div>
    @endcan
@endsection