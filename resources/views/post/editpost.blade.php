<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/lightslider.js')}}"></script>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{asset('css/lightslider.css')}}">
    <title>Document</title>
    <style>
        .demo {
            width: 450px;
        }

        ul {
            list-style: none outside none;
            padding-left: 0;
            margin-bottom: 0;
        }

        li {
            display: block;
            float: left;
            margin-right: 6px;
            cursor: pointer;
        }

        img {
            display: block;
            height: auto;
            margin: 0 auto;
            max-width: 100%;
        }
    </style>
    <style>
        .attribute {
            border-radius: 5px;
            background-color: #eff1ef;
            border-radius: 3px;
            line-height: 22px;
            white-space: normal;
            padding-right: 20px;
            padding-left: 10px;
            margin: 5px 5px;
        }

        .img_primary {
            border-style: solid;
            border-width: medium;
            border-color: #d1000b;
        }

        @font-face {
            font-family: 'vazir';
            /*   src: url('webfont.eot'); !* IE9 Compat Modes *!
               src: url('webfont.eot?#iefix') format('embedded-opentype'), !* IE6-IE8 *!
               url('webfont.woff2') format('woff2'), !* Super Modern Browsers *!
               url('webfont.woff') format('woff'), !* Pretty Modern Browsers *!*/
            src: url('{{asset('vazir.ttf')}}') format('truetype'); /* Safari, Android, iOS */
            /*url('webfont.svg#svgFontName') format('svg'); !* Legacy iOS *!*/
        }
        p, pre, input, a, button, h1, h2, h3, h4, h5, h6,ul,li ,option,select{
            font-family: vazir, 'Segoe UI', Tahoma, sans-serif;
        }
    </style>
</head>
<body>
<form action="{{url('/post/edit')}}" method="post" enctype="multipart/form-data">
    <div>
        <div class="card" style="margin: 15px 80px">
            <div class="d-flex bd-highlight" style="direction: rtl;margin-right: 8px">
                <a class="btn btn-dark" href="{{url('/')}}">صفحه ی اصلی</a>
                {{--<button class="btn btn-dark" win style="margin: 3px" onclick="window.location='/'">صفحه ی اصلی</button>--}}
            </div>
        </div>
        <div class="card" style="margin: 15px 80px">
            <div class="d-flex bd-highlight" style="direction: rtl;margin-right: 8px">
                <p style="text-align: right;margin: 15px 5px">دسته بندی</p>
                <p style="text-align: right;margin: 15px 5px">/</p>
                <p style="text-align: right;margin: 15px 5px">@if(isset($products->first()->cat_name)){{$products->first()->cat_name}}@endif</p>
            </div>
        </div>
        <div>
            <div class="card" style="margin: 5px 80px">
                <div class="card-body">
                    <div class="row">
                        <div class="demo col-lg-6" style="padding:10px 100px">
                            <ul id="lightSlider">
                                @foreach($images as $image)
                                    <li value="{{$image->id}}" data-thumb="{{url('images/products/'.$image->resized_name)}}">
                                        <img value="{{$image->id}}"
                                             src="{{url('images/products/'.$image->resized_name)}}"/>
                                    </li>
                                @endforeach
                            </ul>
                            <div style="margin-top: 10px">
                                <button id="btnslider" class="btn btn-danger" stylef="margin: 10px 0">حذف عکس</button>
                            </div>
                            {{--<form action="/post/addimage" method="post" enctype="multipart/form-data">--}}
                            {{csrf_field()}}
                            <input type="hidden" name="product_id" value="{{$products->first()->id}}">
                            <div class="d-flex bd-highlight" style="margin:20px 0">
                                <input name="post_image" style=";width: 70%;text-align: right;background-color: #fff"
                                       type="file"
                                       class=" p-2 flex-fill bd-highlight attribute form-control"
                                       value="" id="imgload">
                                <p style="margin-top: 10px;width: 40%">افزودن عکس</p>
                            </div>
                            <button type="submit" formaction="{{url('/post/addimage')}}"  style="width: 100%" class="btn btn-primary">آپلود عکس</button>
                            {{--</form>--}}

                            <script>
                                $(document).ready(function () {
                                    $('#btnslider').on('click', function (e) {
                                        e.preventDefault();
                                        if (confirm('آیا از حذف عکس مطمن هستید؟')) {
                                            var image = $('li.active img');
                                            var myid = image.eq(0).attr('value');
                                            var image="{{url('post/images-delete')}}";
                                            // alert(image+"/"+myid);

                                            var fullurl=image+"/"+myid;
                                            window.location =fullurl;
                                        }
                                    });
                                });

                            </script>
                            <hr style="margin:20px 0">
                            {{--<h3 style="color: #AB0D00;text-align: right;">دسته بندی را انتخاب کنید</h3>--}}
                            {{--<fieldset id="category_id">--}}
                            {{--@foreach($category as $cat)--}}
                            {{--<div style="text-align: right;margin: 5px 0px">--}}
                            {{--<lable>{{$cat->cat_name}}</lable>--}}
                            {{--<input @if(isset($products->first()->cat_name)) @if($cat->cat_name==$products->first()->cat_name)checked @endif  @endif type="radio"--}}
                            {{--value="{{$cat->id}}" name="category_id">--}}
                            {{--</div>--}}
                            {{--@endforeach--}}
                            {{--</fieldset>--}}
                            {{--<hr style="margin:20px 0">--}}
                            {{--<form action="/category/addcategory" enctype="multipart/form-data" method="post">--}}
                            {{csrf_field()}}
                            @if(count($errors))

                                @foreach($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error}}
                                    </div>
                                @endforeach
                            @endif
                            {{--<h3 style="color: #AB0D00;text-align: right;">اضافه کردن دسته بندی</h3>--}}
                            {{--<div class="d-flex bd-highlight" style="margin:20px 0">--}}
                            {{--<input name="cat_name" style=";;text-align: right;background-color: #fff" type="text"--}}
                            {{--class=" p-2 flex-fill bd-highlight attribute form-control"--}}
                            {{--value="">--}}
                            {{--<p style="margin-top: 10px;width: 40%">عنوان دسته</p>--}}
                            {{--</div>--}}
                            {{--<div class="d-flex bd-highlight" style="margin:20px 0">--}}
                            {{--<input name="cat_image" style=";width: 70%;text-align: right;background-color: #fff"--}}
                            {{--type="file"--}}
                            {{--class=" p-2 flex-fill bd-highlight attribute form-control"--}}
                            {{--value="" id="imgload">--}}
                            {{--<p style="margin-top: 10px;width: 40%">انتخاب عکس</p>--}}

                            {{--</div>--}}
                            {{--<img id="imgshow" alt="" style="width: 100%">--}}

                            {{--<button type="submit" formaction="/category/addcategory"  class="btn btn-success" style="margin-top: 20px;">اضافه کردن دسته</button>--}}

                            {{--form--}}
                        </div>

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

                        <div class="col-lg-6" style="text-align: right;">
                            {{--<form action="/post/edit" method="post">--}}
                            {{csrf_field()}}
                            <input type="hidden" name="product_id" value="{{$products->first()->id}}">
                            {{--<h3 style="color: #AB0D00;margin: 10px">{{$products->first()->title}}</h3>--}}

                            <div class="d-flex bd-highlight" dir="rtl" style="margin:30px 10px">
                                <h4>کد کالا</h4>
                                <input type="text" name="code_kala" class="translate form-control"
                                       style="margin-right: 10px;text-align: left;width: 150px"
                                       value="{{$products->first()->code_kala}}">
                            </div>
                            <div class="d-flex bd-highlight" dir="rtl" style="margin:30px 10px">
                                <h4 style="color: #AB0D00">عنوان</h4>
                                <input type="text" name="title" class="translate form-control"
                                       style="margin-right: 10px;text-align: right;"
                                       value="{{$products->first()->title}}">
                            </div>

                            <div class="d-flex bd-highlight" dir="rtl" style="margin:30px 10px">
                                <h4>قیمت</h4>
                                <input type="text" name="price" class="translate form-control"
                                       style="margin-right: 10px;text-align: left;width: 150px"
                                       value="{{$products->first()->price}}">
                                <h4 style="margin-right: 10px">تومان</h4>
                            </div>
                            <script type="text/javascript">
                                var arabicNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                                $('.translate').text(function (i, v) {
                                    var chars = v.split('');
                                    for (var i = 0; i < chars.length; i++) {
                                        if (/\d/.test(chars[i])) {
                                            chars[i] = arabicNumbers[chars[i]];
                                        }
                                    }
                                    return chars.join('');
                                })
                            </script>
                            <br>
                            @foreach($attributes as $attr)
                                {{--@foreach($attr as $val)--}}
                                <h4 style="margin-bottom: 20px">{{$attr['parent_title']}}</h4>
                                @foreach($attr['Attr_val'] as $val)
                                    <div class="d-flex bd-highlight">
                                        <input type="hidden" name="attr_product_id[]" value="{{$val['attr_product_id']}}">
                                        <input type="hidden" name="attr_id[]" value="{{$val['attr_id']}}">
                                        <input name="attr_val[]" style="text-align: right;background-color: #fff"
                                               type="text"
                                               class=" p-2 flex-fill bd-highlight attribute form-control"
                                               value="{{$val['Attr_val']}}">
                                        <div class="p-2 flex-fill bd-highlight attribute"
                                             style="width: 55%">{{$val['title']}}</div>
                                        {{--<div class="p-2 flex-fill bd-highlight attribute" style="width: 45%">{{$val['title']}}</div>--}}
                                    </div>
                                @endforeach
                                <hr>
                                {{--@endforeach--}}
                            @endforeach


                            <h4 style="margin-bottom: 20px">عکس اصلی محصول</h4>
                            <input name="primary_image"
                                   style=";width: 60%;float: right;text-align: right;background-color: #fff"
                                   type="file"
                                   class=" p-2 flex-fill bd-highlight attribute form-control"
                                   value="" id="imgloadprimary">

                            <img id="imgshowprimary"  src="@if(isset($products->first()->thumb)){{url('images/products/thumb/'.$products->first()->thumb)}}@endif" alt="" style="width: 60%;float: right;margin-top: 20px">

                            <button class="btn btn-danger" formaction="/post/edit" type="submit" style="padding:12px 20px;width:250px;margin: 20px">ویرایش محصول
                            </button>
                            {{--</form>--}}
                        </div>

                    </div>
                </div>

            </div>
        </div>
</form>
<script>
    $('#lightSlider').lightSlider({
        gallery: true,
        item: 1,
        loop: true,
        slideMargin: 0,
        thumbItem: 9
    });
</script>
<script language="JavaScript" type="text/javascript">
    function checkDelete() {
        return confirm('Are you sure?');
    }
</script>
<script>
    $('document').ready(function () {
        $("#imgloadprimary").change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imgshowprimary').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
</body>
</html>