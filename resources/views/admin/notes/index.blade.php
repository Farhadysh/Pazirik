@extends('admin.master')

@section('content')
    @cannot('show-notes')
        <div class="col-md-6 mx-auto mt-5 bg-white text-center p-5 shadow-sm">
            <span class="fa fa-warning text-warning fa-5x"></span>
            <h5 class="font-weight-bold text-danger mt-3">شما به این صفحه دسترسی ندارید</h5>
        </div>
    @endcannot
    @can('show-notes')
        <div id="preloader"></div>
        <div class="col-md-12 text-center text-dark">
            <h4 class="font-weight-bold my-4 text-muted">لیست یادداشت ها</h4>
        </div>
        <div class="col-md-10 table-responsive mx-auto">
            <table class="table table-bordered rounded mt-2">
                <thead>
                <tr class="bg-info text-light text-center small">
                    <th>موضوع</th>
                    <th>نویسنده</th>
                    <th>تاریخ یادداشت</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($notes as $note)
                    <tr class="text-center small {{$note->view == 0 ? 'bg-low-danger' : ''}}">
                        <td>{{$note->title}}</td>
                        <td>{{$note->user->name}}  {{$note->user->last_name}}</td>
                        <td>{{$note->date}}</td>
                        <td>
                            <form class="form_destroy" data-id="{{$note->id}}" data-name="notes">
                                @csrf
                                <a href="{{route('admin.notes.edit',['id'=>$note->id])}}"
                                   class="btn btn-sm btn-outline-info fa fa-eye font-weight-bold text-info"
                                   data-toggle="tooltip"  data-placement="right" title="ویرایش"></a>
                                @can('delete-notes')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger fa fa-trash font-weight-bold text-danger"
                                            data-toggle="tooltip"  data-placement="right" title="حذف"></button>
                                @endcan
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="col-md-12 mx-auto text-center">
                @if($note_count == 0)
                    <h5 class="text-danger"> موردی یافت نشد!</h5>
                @else
                    <h6 class="text-danger float-left">{{$note_count}} مورد یافت شد</h6>
                @endif
            </div>
            <div class="d-flex justify-content-center mr-n5">
                {{$notes->links()}}
            </div>
        </div>
    @endcan
@endsection