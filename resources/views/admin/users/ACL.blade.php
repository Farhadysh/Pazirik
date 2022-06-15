@extends('admin.master')

@section('content')
    @cannot('add-roles')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('add-roles')
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">افزودن سطح دسترسی</h4>
        </div>
        <div class="col-md-10 shadow-sm bg-white mx-auto p-5">
            <form action="{{route('admin.roles.store')}}" method="post">
                @csrf
                <div class="row m-5">
                    <div class="mr-4">
                        <label>نقش</label>
                        <input name="role" class="form-control">
                        @if ($errors->has('role'))
                            <strong class="error">{{$errors->first('role')}}</strong>
                        @endif
                    </div>
                </div>
                <div class="col-md-10 bg-light shadow-sm mx-auto p-4">
                    <div class="col-md-12 text-center text-dark">
                        <h6 class="mb-3 text-muted">سطوح دسترسی</h6>
                    </div>
                    <div class="container">
                        <ul class="ks-cboxtags">
                            <li>
                                <input name="" type="checkbox"
                                       id="checkAll"
                                       value="">
                                <label class="p-2"
                                       for="checkAll">انتخاب همه</label>
                            </li>
                            @foreach($permissions as $permission)
                                <div class="bg-white my-2 row">
                                    <div class="col-md-12 text-center text-dark">
                                        <h6 class="mb-3 text-muted">{{$permission->label}}</h6>
                                    </div>
                                    <li>
                                        <input name="permission_id[]" type="checkbox"
                                               id="checkbox{{$permission->id}}"
                                               value="{{$permission->id}}">
                                        <label class="p-2"
                                               for="checkbox{{$permission->id}}">{{$permission->label}}</label>
                                    </li>
                                    @foreach($permission->children as $children)
                                        <div class="">
                                            <li class="mr-1">
                                                <input name="permission_id[]" type="checkbox"
                                                       id="checkbox{{$children->id}}"
                                                       value="{{$children->id}}">
                                                <label class="p-2"
                                                       for="checkbox{{$children->id}}">{{$children->label}}</label>
                                            </li>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="mt-4 col-md-12 text-center">
                        <button type="submit" class="btn btn-outline-info col-md-4">ثبت</button>
                    </div>
                </div>
            </form>
        </div>
    @endcan
@endsection