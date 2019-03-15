<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/app.js')}}"></script>
    <title>ثبت محصول جدید</title>
    {{--<script src="{{asset('js/lightslider.js')}}"></script>--}}
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        .mySlides {
            display: none;
        }
    </style>
    {{--<link rel="stylesheet" href="{{asset('css/lightslider.css')}}">--}}
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

        p, pre, input, a, button, h1, h2, h3, h4, h5, h6, ul, li, option, select {
            font-family: vazir, 'Segoe UI', Tahoma, sans-serif;
        }
    </style>

</head>
<body>
<form method="post" enctype="multipart/form-data">
    <div>
        {{--<div class="card" style="margin: 15px 80px">--}}
        {{--<div class="d-flex bd-highlight" style="direction: rtl;margin-right: 8px">--}}
        {{--<a class="btn btn-dark" href="{{url('/')}}">صفحه ی اصلی</a>--}}
        {{--<button class="btn btn-dark" win style="margin: 3px" onclick="window.location='/'">صفحه ی اصلی</button>--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--<div class="card" style="margin: 15px 80px">--}}
        {{--<div class="d-flex bd-highlight" style="direction: rtl;margin-right: 8px">--}}
        {{--<p style="text-align: right;margin: 15px 5px">دسته بندی</p>--}}
        {{--<p style="text-align: right;margin: 15px 5px">/</p>--}}
        {{--<p style="text-align: right;margin: 15px 5px" id="p_cat"></p>--}}
        {{--</div>--}}
        {{--</div>--}}

        <div class="card" style="margin: 15px 80px">
            <div>
                <div class="bd-highlight" style="direction: rtl;margin-right: 8px;float: right;padding: 10px">
                    <p style="display:inline;text-align: right;margin: 15px 5px">دسته بندی</p>
                    <p style="display:inline;text-align: right;margin: 15px 5px">/</p>
                    <p style="display:inline;text-align: right;margin: 15px 5px"
                       id="p_cat"></p>
                </div>
                <div class="bd-highlight" style="float: left;;margin-left: 8px;;padding: 10px">
                    <a href="{{url('/')}}">صفحه ی اصلی</a>
                </div>
            </div>
        </div>
        <div class="card" style="margin: 5px 80px">
            <div class="card-body">
                <div class="card-body">
                    <div class="row">
                        <div class="demo col-lg-6" style="padding:10px 100px">
                            <div id="slider" class="w3-content w3-display-container">
                                @include('post.ajax.post_imagedata')
                                <button id="pre" class="w3-button w3-black w3-display-left">&#10094;</button>
                                <button id="next" class="w3-button w3-black w3-display-right">&#10095;</button>
                            </div>

                            <script>
                                $('#pre').click(function (event) {
                                    event.preventDefault();
                                    plusDivs(-1);
                                });
                                $('#next').click(function (event) {
                                    event.preventDefault();
                                    plusDivs(1);
                                });

                                var slideIndex = 1;
                                showDivs(slideIndex);

                                function plusDivs(n) {
                                    showDivs(slideIndex += n);
                                }

                                function showDivs(n) {

                                    var i;
                                    var x = document.getElementsByClassName("mySlides");
                                    if (n > x.length) {
                                        slideIndex = 1
                                    }
                                    if (n < 1) {
                                        slideIndex = x.length
                                    }
                                    for (i = 0; i < x.length; i++) {
                                        x[i].style.display = "none";
                                    }
                                    x[slideIndex - 1].style.display = "block";
                                    $(".mySlides").removeClass("active");
                                    $('.mySlides').eq(slideIndex - 1).addClass("active");
                                }
                            </script>

                            <div style="margin-top: 80px">
                                <button id="btnslider" class="btn btn-danger" style="margin: 10px 0">حذف عکس</button>
                                {{--<button id="btnslider" class="btn btn-primary" style="margin: 10px 0">رفرش</button>--}}
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="product_id" value="0">
                            <div class="d-flex bd-highlight" style="margin:20px 0">
                                <input name="post_image" style=";width: 70%;text-align: right;background-color: #fff"
                                       type="file"
                                       class=" p-2 flex-fill bd-highlight attribute form-control"
                                       value="" id="imgload">
                                <p style="margin-top: 10px;width: 40%">افزودن عکس</p>
                            </div>
                            @include('post.ajax.ajaxnewpost')
                            <script>

                            </script>
                            <hr style="margin:20px 0">
                            <h3 style="color: #AB0D00;text-align: right;">ابتدا دسته بندی را انتخاب کنید</h3>
                            <fieldset id="category_id">
                                @foreach($category as $cat)
                                    <div style="text-align: right;margin: 5px 0px">
                                        <lable>@if(isset($cat->cat_name)){{$cat->cat_name}}@endif</lable>
                                        <input type="radio"
                                               id="radio"
                                               cat_name="@if(isset($cat->cat_name)){{$cat->cat_name}}@endif"
                                               value="{{$cat->id}}" name="category_id">
                                    </div>
                                @endforeach
                            </fieldset>
                            <hr style="margin:20px 0">
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
                            {{--<input type="hidden" name="product_id" value="{{$products->first()->id}}">--}}
                            {{--<h3 style="color: #AB0D00;margin: 10px">{{$products->first()->title}}</h3>--}}
                            @if(count($errors))
                                @foreach($errors->all() as $error)
                                    <div style="width: 100%">
                                        <div class="alert alert-danger">
                                            {{ $error}}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if(isset($_GET['p']))
                                <div class="alert alert-success">
                                    <a href="{{url('post/showpost/'.$_GET['p'])}}">شما محصول ثبت شده را میتوانید با
                                        این لینک ببینید</a>
                                </div>
                            @endif

                            <div class="d-flex bd-highlight" dir="rtl" style="margin:30px 10px">
                                <h4>کد کالا</h4>
                                <input type="text" name="code_kala" class="translate form-control"
                                       style="margin-right: 10px;text-align: left;width: 150px"
                                       value="">
                            </div>
                            <div class="d-flex bd-highlight" dir="rtl" style="margin:30px 10px">
                                <h4 style="color: #AB0D00">عنوان</h4>
                                <input type="text" name="title" class="translate form-control"
                                       style="margin-right: 10px;text-align: right;"
                                       value="">
                            </div>

                            <div class="d-flex bd-highlight" dir="rtl" style="margin:30px 10px">
                                <h4>قیمت</h4>
                                <input type="text" name="price" class="translate form-control"
                                       style="margin-right: 10px;text-align: left;width: 150px"
                                       value="">
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

                            <div id="attributes">
                                @include('post.ajax.attributesdata')
                            </div>
                            <h4 style="margin-bottom: 20px">عکس اصلی محصول</h4>
                            <input name="primary_image"
                                   style=";width: 60%;float: right;text-align: right;background-color: #fff"
                                   type="file"
                                   class=" p-2 flex-fill bd-highlight attribute form-control"
                                   value="" id="imgloadprimary">

                            <img id="imgshowprimary" alt="" style="width: 60%;float: right;margin-top: 20px">

                            <button class="btn btn-danger" formaction="{{url('/post/addnewpost')}}" type="submit"
                                    style="padding:12px 20px;width:250px;margin: 20px">ثبت محصول
                            </button>
                            {{--</form>--}}
                        </div>
                        <script>

                            $("input[name='category_id']").change(function () {

                                var cat_id = $('input[name=category_id]:checked').val();

                                $("#attributes div").remove();
                                loadAttributes(cat_id);
                            });

                            function loadAttributes(cat_id) {
                                $.ajax({
                                    method: 'POST',
                                    url: '{{url('/post/newpost/ajax_attr')}}',
                                    data: {'cat_id': cat_id},
                                    beforeSend: function (request) {
                                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                                    },
                                    success: function (response) {
                                        $("#attributes").append(response.html);
                                        console.log(response.html);
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {

                                    }
                                });
                            }
                        </script>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>

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
</div>
</form>
</body>
</html>