@extends('layouts.admin_layout')
@section('header')
    <title>دسته بندی مستندات</title>
    {{--<link rel="stylesheet" href="{{asset('css/load-styles.css')}}">--}}
@endsection


@section('content')
    <div class="container" style="width: 100%;">
        <form action="{{url('document/addcat')}}" style="width: 100%" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="">
                <div class="card" style="margin-top: 20px;margin-left: 5%;margin-right: 5%">
                    <div class="card-body" style="padding: 50px;direction: rtl">
                        <h3 style="color: #AB0D00;text-align: right;padding-bottom: 20px">اضافه کردن دسته بندی</h3>
                        @if(count($errors))
                            @foreach($errors->all() as $error)
                                <div class="d-flex col-lg-8" style="margin:5px 0px">
                                    <div class="alert alert-danger">
                                        {{ $error}}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="d-flex col-lg-8" style="margin:20px 0">
                            <p style="margin-top: 10px;white-space: nowrap;">عنوان دسته بندی</p>
                            <input name="cat_name" style=";;text-align: right;background-color: #fff" type="text"
                                   class="p-2 flex-fill bd-highlight attribute form-control"
                                   value="">
                        </div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4"></div>
                        <img id="imgshow" class="col-lg-4" alt="" style=" ;margin: 0">
                        <button type="submit" class="btn btn-success "
                                style="margin-top: 20px;margin-right:10px;float: right">اضافه کردن دسته بندی
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <input name="taxonomy" value="category" type="hidden">
        <input name="post_type" value="post" type="hidden">
        {{csrf_field()}}
        <div class="tablenav top">
            <h1 class="wp-heading-inline"></h1>
            {{--style="margin-bottom: 30px; margin: 25px 50px;display: block">@if(\Illuminate\Support\Facades\Input::get('cat')!=""&&\Illuminate\Support\Facades\Input::get('id')!=0)--}}
            {{--زیر دسته ی {{ \Illuminate\Support\Facades\Input::get('cat')}}@endif</h1>--}}
            {{----}}
            <table class="table" style="width: 88%;;margin-left: 5%;margin-top: 30px;margin-right: 6%">
                <thead class="btn-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">تعداد</th>
                    <th scope="col">حذف</th>
                    <th scope="col">ویرایش</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($_GET['page'])) {
                    $count = (($_GET['page'] - 1) * 10) + 1;
                } else {
                    $count = 1;
                }?>
                @foreach($category as $cat)
                    <tr>
                        <th scope="row">{{$count++}}</th>
                        <td>{{$cat->title}}</td>
                        <td>{{$cat->documents_count}}</td>
                        <td><a href="{{url('/document/cat/delete/'.$cat->id)}}" onclick="return checkDelete()">حذف</a>
                        </td>
                        <td>
                            <a href="{{url('/document/editcategory/'.$cat->id)}}">ویرایش</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$category->links()}}
        </div>
        <script language="JavaScript" type="text/javascript">
            function checkDelete() {
                return confirm('ایا از این دسته مطمنید؟ کل کالاهای این دسته بندی حذف خواهد شد!!!');
            }
        </script>
    </div>
@endsection
