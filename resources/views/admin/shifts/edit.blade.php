@extends('admin.master')

@section('content')
    @cannot('edit-shift')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('edit-shift')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">ویرایش شیفت</h4>
        </div>

        <div class="col-md-10 mx-auto p-4 shadow-sm bg-light">
            <form action="{{route('admin.shifts.update',['id' => $shift->id])}}" class="form-row" method="post">
                @csrf
                @method('PATCH')
                <div class="form-group col-md-3">
                    <label for="from">ساعت شروع</label>
                    <input type="text" class="form-control font-small" id="from" name="from"
                           placeholder="از" value="{{$shift->from}}">
                    @if ($errors->has('from'))
                        <strong class="error small">{{$errors->first('from')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="to">ساعت پایان</label>
                    <input type="text" class="form-control font-small" id="to" name="to" placeholder="تا"
                           value="{{$shift->to}}">
                    @if ($errors->has('to'))
                        <strong class="error small">{{$errors->first('to')}}</strong>
                    @endif
                </div>
                <div class="form-group mx-3">
                    <label class="text-success" for="active">فعال</label>
                    <input type="radio" class="form-control font-small" id="active" name="active"
                           value="1" {{$shift->getOriginal('active') == 1 ? 'checked' : ''}}>
                </div>
                <div class="form-group mx-3">
                    <label class="text-danger" for="active">غیر فعال</label>
                    <input type="radio" class="form-control font-small" id="active" name="active"
                           value="2" {{$shift->getOriginal('active') == 2 ? 'checked' : ''}}>
                </div>
                <div class="form-group col-md-2 pt-2">
                    <button type="submit" class="btn btn-outline-info btn-sm mt-4">ثبت شیفت</button>
                </div>
            </form>
        </div>
    @endcan
@endsection