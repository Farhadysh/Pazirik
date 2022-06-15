@extends('admin.master')

@section('content')
    <div class="col-md-12 text-center text-dark">
        <h4 class="font-weight-bold my-4 text-muted">افزودن یادداشت</h4>
    </div>
    <div class="col-md-10 shadow-sm bg-white mx-auto rounded d-flex justify-content-center">
        @foreach($settings as $setting)
            <form action="{{route('admin.settings.update',['id' => $setting->id])}}" method="post"
                  class="border-0 rounded p-2 mt-3 mx-0 form-row">
                @csrf
                <div class="form-group col-md-3">
                    <label for="title">نوع تنطیم</label>
                    <input type="text" class="form-control font-small" id="title" name="title"
                           value="{{$setting->key == 'factorDescription' ? 'متن زیر فاکتور' : ''}}" disabled>
                    @if ($errors->has('title'))
                        <strong class="error">{{$errors->first('title')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="description">متن یادداشت</label>
                    <textarea type="text" class="form-control font-small" id="description" name="description" rows="4"
                              cols="150" placeholder="متن یادداشت">{{$setting->value}}</textarea>
                    @if ($errors->has('description'))
                        <strong class="error">{{$errors->first('description')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-12 mt-1">
                    <button type="submit" class="btn btn-outline-info mt-4">ویرایش</button>
                </div>
                @endforeach
            </form>
    </div>
@endsection