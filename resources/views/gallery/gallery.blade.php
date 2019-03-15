@extends('layouts.admin_layout')
@section('header')
    <title>گالری</title>
    {{--<link rel="stylesheet" href="{{asset('css/load-styles.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('css/app.css')}}">--}}
    <script src="{{asset('js/float-panel.js')}}"></script>
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
            <form action="{{url('gallery/add')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="">
                    <div class="card" style="margin-top: 20px">
                        <div class="card-body" style="padding: 50px;direction: rtl">
                            <h3 style="color: #AB0D00;text-align: right;">اضافه کردن گالری</h3>
                            @if(count($errors))
                                @foreach($errors->all() as $error)
                                    <div class="d-flex col-lg-12" style="margin:5px 0px">
                                        <div class="alert alert-danger">
                                            {{ $error}}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class=" col-lg-12" style="margin:20px 0;float: right">
                                <div class="row" dir="rtl">
                                    <p style="margin-top: 10px;white-space: nowrap;" class="col-lg-2 ">عنوان گالری</p>
                                    <input name="title" style=";;text-align: right;background-color: #fff" type="text"
                                           class="p-2 col-lg-8   bd-highlight attribute form-control"
                                           value="">
                                </div>
                            </div>

                            <div class="d-flex flex col-lg-12" style="margin:20px 0;">
                                <div class="row" dir="rtl">
                                    <p class="col-lg-4" style="margin-top: 10px;white-space: nowrap;">انتخاب عکس</p>
                                    <input name="gallery_image"
                                           style=";width: 30%;text-align: right;background-color: #fff"
                                           type="file"
                                           class=" p-2 flex-fill col-lg-8   bd-highlight attribute form-control"
                                           value="" id="imgload">
                                </div>
                            </div>

                            <div class="col-lg-4"></div>
                            <div class="col-lg-4"></div>
                            <img id="imgshow" class="col-lg-4" alt="" style=" ;margin: 0">
                            <button type="submit" formaction="{{url('/gallery/add')}}" class="btn btn-success "
                                    style="margin-top: 20px;">اضافه کردن گالری
                            </button>

                        </div>
                    </div>
                    <style>
                        .cus_card {
                            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                            transition: 0.3s;

                        }

                        .cus_card:hover {
                            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
                        }

                        .container {
                            margin:11px 10px;
                            padding: 10px 1px;
                            text-align: right;
                        }
                    </style>

                    <div class="row mt-4">
                        @foreach($GalleryArray as $gallery)
                            <div class="col-lg-3  col-md-4 col-sm-6" style="padding: 5px 8px">
                                <div class="cus_card " style="">
                                    <img src="{{url($gallery['image'])}}" alt="Avatar" style="width:100%">
                                    <div class="container">
                                        <h6><b>  {{  $gallery['title']}}</b></h6>
                                        <div class="mt-3 mr-1 mb-1">
                                            <a href="{{url('gallery/editgallery/'.$gallery['id'])}}" class="text-success">ویرایش</a>
                                            <a  href="{{url('gallery/delete/'.$gallery['id'])}}" onclick="return checkDelete()"  class="text-danger" style="margin-left: 5px">حذف</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach



                        {{--@foreach($GalleryArray as $gallery)--}}
                        {{----}}
                        {{--@endforeach--}}
                        {{--
                                    <div class="col-lg-3  col-md-4 col-sm-6 slideanim" style="margin-top: 20px">
                                        <div class="card">
                                            <div class="mycontainer"
                                                 style="  background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0, #fff 100%);">
                                                <div class="card-img-top test">
                                                    <img
                                                            class="card-img-top"
                                                            src="{{url($gallery['image'])}}"
                                                            alt="Card image cap">
                                                </div>
                                                --}}{{--</object>--}}{{--

                                                <div class="bottom_panel">
                                                    <div class="bottom-left" id="panel">
                                                        <div class="row" style="margin :50px 20px">
                                                            <a href="{{url('gallery/editgallery/'.$gallery['id'])}}" class="btn btn-primary">ویرایش</a>
                                                            <a  href="{{url('gallery/delete/'.$gallery['id'])}}" class="btn btn-danger" style="margin-left: 5px">حذف</a>
                                                        </div>
                                                    </div>
                                                    <div class="bottom-right" style="color:#e7e7e7;">
                                                        {{  $gallery['title']}}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    --}}
                    </div>
                    {{$GalleryArray->links()}}
                </div>
            </form>


        </div>
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
            function checkDelete() {
                return confirm('آیا از حذف مطمنید!!!');
            }

    </script>
@endsection