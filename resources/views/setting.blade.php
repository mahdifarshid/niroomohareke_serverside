@extends('layouts.admin_layout')
@section('header')
    <title>تنظیمات</title>
    {{--<link rel="stylesheet" href="{{asset('css/load-styles.css')}}">--}}
    {{--<script src="{{asset('js/float-panel.js')}}"></script>--}}
    {{--<script src="{{asset('js/app.js')}}"></script>--}}
    {{--<link rel="stylesheet" href="{{asset('css/demo2.css')}}">--}}

    <style>
        .bottom-right {
            position: absolute;
            bottom: 60px;
            right: 5px;
            left: 5px;
        }

        .bottom-left {
            position: absolute;
            bottom: 0px;
            left: 0px;
        }

        hero-image::after {

        }

        .bottom_panel {
            /*visibility: hidden;*/

            /*overflow:hidden;*/
            -webkit-transition: all 0.2s linear;
            -moz-transition: all 0.2s linear;
            -o-transition: all 0.2s linear;
            transition: all 0.2s linear;
            /*margin-top:300px;*/
            /*position:absolute;*/
        }

        .mycontainer {
            position: relative;
            text-align: center;
            color: white;

        }

        #panel {
            transition: height 0.7s;
            visibility: hidden;
            /*width: 100%;height:2%*/
            /*-webkit-transition: all 0.3s linear;*/
            /*-moz-transition: all 0.3s linear;*/
            /*-o-transition: all 0.3s linear;*/
            transition-timing-function: ease;
            /*transition: all 0.3s linear;*/
            background-image: linear-gradient(rgba(122, 122, 122, 0.84), rgb(0, 0, 0));;
            width: 100%;
            height: 0%
        }

        .mycontainer:hover #panel {
            margin-top: 50px;
            height: 45%;
            padding-top: 10px;
            visibility: visible;
        }

        .test {
            position: relative;
            display: block;
            height: 100%;
        }

    </style>
@endsection
@section('content')
    <div class="container" style="margin: 10px 30px;padding-bottom: 80px">
        <div class="">
            <form action="{{url('telegram/addmore')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="">
                    <div class="card" style="margin-top: 20px">
                        <div class="card-body" style="padding: 50px;direction: rtl">
                            <h3 style="color: #AB0D00;text-align: right;">کانال تلگرام</h3>
                            @if(count($errors))
                                @foreach($errors->all() as $error)
                                    <div class="d-flex col-lg-12" style="margin:5px 0px">
                                        <div class="alert alert-danger">
                                            {{ $error}}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="d-flex col-lg-8" style="margin:20px 0">
                                <p style="margin-top: 10px;white-space: nowrap;">لینک کانال</p>
                                <input type="hidden" name="title" value="telegram">
                                <input name="value" style="margin-right: 10px;;text-align: left;background-color: #fff"
                                       type="text"
                                       class="p-2 flex-fill bd-highlight attribute form-control"
                                       value="@if(isset($telegram)){{$telegram->first()->value}}@endif">
                            </div>
                            <button type="submit" formaction="{{url('/setting/addmore')}}" class="btn btn-success "
                                    style="margin-top: 20px;">ثبت کانال
                            </button>
                        </div>


                    </div>

                </div>
            </form>



            <form action="{{url('telegram/addmore')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="">
                    <div class="card" style="margin-top: 20px">
                        <div class="card-body" style="padding: 50px;direction: rtl">
                            <h3 style="color: #AB0D00;text-align: right;">نقشه کارگاه</h3>
                            @if(count($errors))
                                @foreach($errors->all() as $error)
                                    <div class="d-flex col-lg-12" style="margin:5px 0px">
                                        <div class="alert alert-danger">
                                            {{ $error}}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="d-flex col-lg-8" style="margin:20px 0">
                                <p style="margin-top: 10px;white-space: nowrap;">نقشه کارگاه</p>
                                <input type="hidden" name="title" value="address">
                                <input name="value" style="margin-right: 10px;;text-align: left;background-color: #fff"
                                       type="text"
                                       class="p-2 flex-fill bd-highlight attribute form-control"
                                       value="@if(isset($address)){{$address->first()->value}}@endif">
                            </div>
                            <button type="submit" formaction="{{url('/setting/addmore')}}" class="btn btn-success "
                                    style="margin-top: 20px;">ثبت آدرس کارگاه
                            </button>
                        </div>


                    </div>

                </div>
            </form>



            <form action="{{url('telegram/addmore')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="">
                    <div class="card" style="margin-top: 20px">
                        <div class="card-body" style="padding: 50px;direction: rtl">
                            <h3 style="color: #AB0D00;text-align: right;">Adobe Reader</h3>
                            @if(count($errors))
                                @foreach($errors->all() as $error)
                                    <div class="d-flex col-lg-12" style="margin:5px 0px">
                                        <div class="alert alert-danger">
                                            {{ $error}}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="d-flex col-lg-8" style="margin:20px 0">
                                <p style="margin-top: 10px;white-space: nowrap;">لینک adobe reader</p>
                                <input type="hidden" name="title" value="adobe_reader">
                                <input name="value"
                                       style="margin-right: 10px;;text-align: left;background-color: #fff"
                                       type="text"
                                       class="p-2 flex-fill bd-highlight attribute form-control"
                                       value="@if(isset($AdobeReader)){{$AdobeReader->first()->value}}@endif">
                            </div>
                            <button type="submit" formaction="{{url('/setting/addmore')}}" class="btn btn-success "
                                    style="margin-top: 20px;">ثبت لینک
                            </button>
                        </div>


                    </div>
                </div>
            </form>
        </div>

        <form action="{{url('telegram/addmore')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="">
                <div class="card" style="margin-top: 20px">
                    <div class="card-body" style="padding: 50px;direction: rtl">
                        <h3 style="color: #AB0D00;text-align: right;">درباره ی ما</h3>
                        @if(count($errors))
                            @foreach($errors->all() as $error)
                                <div class="d-flex col-lg-12" style="margin:5px 0px;">
                                    <div class="alert alert-danger">
                                        {{ $error}}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="d-flex col-lg-12" style="margin:20px 0">
                            <p style="margin-top: 10px;white-space: nowrap;">توضیحات</p>
                            <input type="hidden" name="title" value="aboutus">
                            <textarea name="value"
                                      style="margin-right: 10px;;text-align: right;background-color: #fff"
                                      name="value"
                                      type="text"
                                      class="p-2 flex-fill bd-highlight attribute form-control"
                                      rows="20"
                                      value="">@if(isset($aboutus)){{$aboutus->first()->value}}@endif</textarea>
                        </div>
                        <button type="submit" formaction="{{url('/setting/addmore')}}" class="btn btn-success "
                                style="margin-top: 20px;"> ثبت
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
    </div>

@endsection