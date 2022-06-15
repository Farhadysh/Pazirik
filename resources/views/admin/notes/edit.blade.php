@extends('admin.master')

@section('content')
    @cannot('edit-notes')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('edit-notes')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">ویرایش یادداشت</h4>
        </div>
        <div class="col-md-10 shadow-sm bg-white mx-auto rounded d-flex justify-content-center">
            <form action="{{route('admin.notes.update',['id'=>$note->id])}}" method="post"
                  class="border-0 rounded p-2 mt-3 mx-0 form-row">
                @method('PATCH')
                @csrf
                <div class="form-group col-md-3">
                    <label for="title">موضوع</label>
                    <input type="text" class="form-control font-small" id="title" name="title"
                           value="{{$note->title}}">
                    @if ($errors->has('title'))
                        <strong class="error">{{$errors->first('title')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="date">تاریخ</label>
                    <input autocomplete="off" type="text" class="form-control font-small" id="date" name="date"
                           value="{{$note->date}}">
                    @if ($errors->has('date'))
                        <strong class="error">{{$errors->first('date')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="user">نام نویسنده</label>
                    <input type="text" class="form-control font-small" id="user" name="user"
                           value="{{$note->user->name}}  {{$note->user->last_name}}" disabled>
                    @if ($errors->has('date'))
                        <strong class="error">{{$errors->first('date')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="description">متن یادداشت</label>
                    <textarea type="text" class="form-control font-small" id="description" name="description" rows="4"
                              cols="35">{{$note->description}}</textarea>
                    @if ($errors->has('description'))
                        <strong class="error">{{$errors->first('description')}}</strong>
                    @endif
                </div>
                <div class="form-group col-md-3 mt-1">
                    <button type="submit" class="btn btn-outline-info mt-4">ویرایش/بازگشت</button>
                </div>

            </form>
        </div>
    @endcan
@endsection