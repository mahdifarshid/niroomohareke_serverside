@extends('layouts.admin_layout')
@section('header')
{{--    <link rel="stylesheet" href="{{asset('css/load-styles.css')}}">--}}
<title>لیست محصولات</title>
@endsection
@section('content')

    <div class="container" style="margin: 0 10%">
        <form action="{{url('/post')}}">
            <div style="margin-top:30px;display: flex;">
                <h3 style="color: #AB0D00;margin: 0">انتخاب دسته بندی</h3>
                <select name="cat_id" id="categories" style="width: 200px;;margin-right: 30px">
                    <option value="all">کل محصولات</option>
                    @foreach($categories as $cat)
                        <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
                    @endforeach
                </select>
                <script>
                    $("#categories").val(@if(isset($_GET['cat_id'])){{$_GET['cat_id']}}@endif);
                </script>
                <button type="submit" class="btn btn-success" style="margin-right: 14px">انتخاب</button>
            </div>
        </form>
        <script>
            $(function () {
                $('#categories').change(function () {
                    this.form.submit();
                });
            });
        </script>

        <form action="{{url('/post/showpost')}}" method="post" style="width: 100%">
            {{csrf_field()}}
            <h1 class="wp-heading-inline"
                style="margin-bottom: 30px; margin: 10px 50px;display: block">@if(\Illuminate\Support\Facades\Input::get('cat')!=""&&\Illuminate\Support\Facades\Input::get('id')!=0)
                    زیر دسته ی {{ \Illuminate\Support\Facades\Input::get('cat')}}@endif</h1>

            <table class="table" style="margin-top:40px;width: 100%">
                <thead class="btn-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">عکس</th>
                    <th scope="col">دسته</th>
                    <th scope="col">مشاهده ی پست</th>
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
                @foreach($products as $product)
                    <tr>
                        <th scope="row">{{$count++}}</th>
                        <td>{{$product->title}}</td>
                        <td><img width="50" height="50" src="{{url('images/products/thumb/'.$product->thumb)}}" alt=""></td>
                        <td><span>{{$product->cat_name}}</span></td>
                        <td><a href="{{url('/post/showpost/'.$product->id)}}">مشاهده پست</a></td>
                        <td><a href="{{route('post.delete',['id'=>$product->id])}}" onclick="return  confirm('آیا از حذف این محصول مطمنید؟');"
                            >حذف</a></td>
                        <td><a href="{{url('/post/editpost/'.$product->id)}}">ویرایش</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{$products->links()}}

        </form>
    </div>
    <script type="text/javascript">
        try {
            document.forms.addtag['tag-name'].focus();
        } catch (e) {
        }
    </script>


    <script language="JavaScript" type="text/javascript">
        function checkDelete() {
            confirm('آیا از حذف این محصول مطمنید؟');
        }
    </script>
@endsection
