<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$products->first()->title}}</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/lightslider.js')}}"></script>
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
<div class="card" style="margin: 15px 80px">
    <div class="d-flex bd-highlight" style="direction: rtl;margin-right: 8px">
        <p style="text-align: right;margin: 15px 5px">دسته بندی</p>
        <p style="text-align: right;margin: 15px 5px">/</p>
        <p style="text-align: right;margin: 15px 5px">{{$products->first()->cat_name}}</p>
    </div>
</div>
<div class="card" style="margin: 5px 80px">
    <div class="card-body">
        <div class="row">
            <div class="demo col-lg-6" style="padding:10px 100px">
                <ul id="lightSlider">
                    @foreach($images as $image)
                        <li data-thumb="{{url('images/products/'.$image->resized_name)}}">
                            <img src="{{url('images/products/'.$image->resized_name)}}"/>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-6" style="text-align: right;">

                 <h5>{{$products->first()->code_kala}} :کد کالا</h5>
                <h3 style="color: #AB0D00;margin: 10px">{{$products->first()->title}}</h3>
                <div class="d-flex bd-highlight" dir="rtl" style="margin:30px 10px">
                    <h4>قیمت</h4>
                    <h4 class="translate" style="margin-right: 10px"> {{$products->first()->price}} </h4>
                    <h4 style="margin-right: 10px">تومان</h4>
                </div>


                <img id="dasdsa" width="300" height="300" src="{{url('images/products/thumb/'.$products->first()->thumb)}}" alt="">

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
                            <div class="p-2 flex-fill bd-highlight attribute"
                                 style="width: 55%">{{$val['Attr_val']}}</div>
                            <div class="p-2 flex-fill bd-highlight attribute" style="width: 45%">{{$val['title']}}</div>
                        </div>
                    @endforeach
                    <hr>
                    {{--@endforeach--}}
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script>
    $('#lightSlider').lightSlider({
        gallery: true,
        item: 1,
        loop: true,
        slideMargin: 0,
        thumbItem: 9
    });
</script>

</body>
</html>