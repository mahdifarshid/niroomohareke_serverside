@extends('layouts.admin_layout')
@section('header')
    <title>دسته بندی محصولات</title>
    {{--<link rel="stylesheet" href="{{asset('css/load-styles.css')}}">--}}
@endsection

@section('content')
    <style>
        th{
            text-align: center;
        }
    </style>
    <div class="container" style="width: 100%;">
        <form action="{{url('category/addcategory')}}" style="width: 100%" method="post" enctype="multipart/form-data">
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
                        <div class="d-flex flex col-lg-8" style="margin:20px 0;">
                            <p style="margin-top: 10px;white-space: nowrap;">انتخاب عکس</p>
                            <input name="cat_image" style=";width: 30%;text-align: right;background-color: #fff"
                                   type="file"
                                   class=" p-2 flex-fill bd-highlight attribute form-control"
                                   value="" id="imgload">
                        </div>

                        <div class="col-lg-4"></div>
                        <div class="col-lg-4"></div>
                        <img id="imgshow" class="col-lg-4" alt="" style=" ;margin: 0">
                        <button type="submit" class="btn btn-success "
                                style="margin-top: 20px;margin-right:10px;float: right">اضافه کردن دسته
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <input name="taxonomy" value="category" type="hidden">
        <input name="post_type" value="post" type="hidden">
        <form action="{{url('category/editOrder')}}" method="get">

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
                    <th scope="col">ترتیب</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">تعداد محصول</th>
                    <th scope="col">عکس</th>
                    <th scope="col">ویژگی</th>
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
                        <td>
                            <div class="d-flex col-lg-12" style="margin:20px 0">
                                <input name="order[]" style="text-align: center;background-color: #fff" type="text"
                                       class="p-2 flex-fill bd-highlight attribute form-control"
                                       value="@if($cat->order_by!=0){{$cat->order_by}}@endif">
                                <input name="cat[]" value="{{$cat->id}}" type="hidden">
                            </div>
                        </td>
                        <td>{{$cat->cat_name}}</td>
                        <td>{{$cat->getposts_count}}</td>
                        <td><img src="{{url('images/category/'.$cat->cat_image)}}" style="width: 60px;width: 60px">
                        <td><a href="{{url('/feature?cat_id='.$cat->id.'&cat_title='.$cat->cat_name)}}">اضافه
                                کردن ویژگی</a></td>
                        <td><a href="{{url('/category/delete/'.$cat->id)}}" onclick="return checkDelete()">حذف</a></td>
                        <td>
                            <a href="{{url('/category/editcategory/'.$cat->id)}}">ویرایش</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$category->links()}}
            <button type="submit" class="btn btn-success">ثبت ترتیب</button>
            <script>
                $('document').ready(function () {
                    $("#imgload").change(function () {
                        if (this.files && this.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $('#imgshow').attr('src', e.target.result);
                            }
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                });
            </script>
            <script type="text/javascript">
                try {
                    document.forms.addtag['tag-name'].focus();
                } catch (e) {
                }
            </script>
        </div>

        </form>

        <script language="JavaScript" type="text/javascript">
            function checkDelete() {
                return confirm('ایا از این دسته مطمنید؟ کل کالاهای این دسته بندی حذف خواهد شد!!!');
            }
        </script>
    </div>
@endsection
