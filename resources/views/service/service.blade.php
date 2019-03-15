@extends('layouts.admin_layout')
@section('header')

    {{--<link rel="stylesheet" href="{{asset('css/load-styles.css')}}">--}}
    <title>خدمات</title>
    <script src="{{asset('js/float-panel.js')}}"></script>
    {{--<script src="{{asset('js/app.js')}}"></script>--}}
    {{--<link rel="stylesheet" href="{{asset('css/demo2.css')}}">--}}

@endsection
@section('content')
    <div class="container" style="padding-bottom: 80px">
        <div class="">

            <form action="{{url('service/add')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="card" style="margin-top: 20px">
                    <div class="card-body" style="padding: 50px;direction: rtl">
                        <h3 style="color: #AB0D00;text-align: right;padding-bottom: 20px" data-toggle="collapse"
                            data-target="#collapseHeader" aria-expanded="false"
                            aria-controls="collapseHeader">اضافه کردن خدمات</h3>

                        <div @unless(count($errors)) class="collapse" @endunless id="collapseHeader">
                            @if(count($errors))
                                @foreach($errors->all() as $error)
                                    <div class="d-flex col-lg-8" style="margin:5px 5px">
                                        <div class="alert alert-danger">
                                            {{ $error}}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="d-flex col-lg-12" style="margin:20px 0">
                                <div class="row" dir="rtl">
                                    <p style="margin-top: 10px;white-space: nowrap;" class="col-lg-4 ">عنوان خدمات</p>
                                    <input name="title" style=";;text-align: right;background-color: #fff" type="text"
                                           class="p-2 col-lg-8 flex-fill bd-highlight attribute form-control"
                                           value="">
                                </div>
                            </div>

                            <div class="d-flex flex col-lg-10" style="margin:20px 0;">
                                <p style="margin-top: 10px;white-space: nowrap;">توضیحات</p>
                                <textarea name="description" style=";text-align: right;background-color: #fff"
                                          type="text" rows="8"
                                          class="form-control"></textarea>
                            </div>

                            <div class="col-lg-4"></div>
                            <div class="col-lg-4"></div>
                            <img id="imgshow" class="col-lg-4" alt="" style=" ;margin: 0">
                            <button type="submit" formaction="{{url('/service/add')}}" class="btn btn-success "
                                    style="margin-top: 20px;margin-right: 20px;float: right;">اضافه کردن خدمات
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            @foreach($services as $service)
                <div class="card" style="margin-top: 20px;">
                    <h5 class="card-header" data-toggle="collapse"
                        data-target="#collapseHeader{{$service->id}}" aria-expanded="false"
                        aria-controls="collapseHeader{{$service->id}}"
                        style="text-align: right;padding-right:25px;color: #AB0D00;">{{$service->title}}</h5>
                    <div class="card-body collapse" id="collapseHeader{{$service->id}}">
                        <pre class="card-text" style="white-space: pre-wrap;;text-align: right;;line-height:2.5;color: #444;
                        font-size: 13px">{{$service->description}}</pre>

                        <button class="btn btn-primary" type="button" data-toggle="collapse" style="float: right"
                                data-target="#collapseExample{{$service->id}}" aria-expanded="false"
                                aria-controls="collapseExample{{$service->id}}">
                            ویرایش
                        </button>
                        <a href="{{url('service/delete/'.$service->id)}}" class="btn btn-danger" type="button"
                           onclick="return confirm('آیا از حذف مطمنید')" style="float: right;margin-right: 10px">
                            حذف
                        </a>
                        <form action="{{url('/service/edit')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$service->id}}">
                            <div class="collapse" id="collapseExample{{$service->id}}" style="margin-top: 70px">
                                {{--ویرایش--}}
                                <div class="card" id="collapseExample{{$service->id}}" style="margin-top: 20px">
                                    <div class="card-body" style="padding: 50px;direction: rtl">
                                        <h3 style="color: #AB0D00;text-align: right;padding-bottom: 20px">ویرایش
                                            خدمات</h3>
                                        @if(count($errors))
                                            @foreach($errors->all() as $error)
                                                <div class="d-flex col-lg-8" style="margin:5px 5px">
                                                    <div class="alert alert-danger">
                                                        {{ $error}}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="d-flex col-lg-12" style="margin:20px 0">
                                            <p style="margin-top: 10px;white-space: nowrap;">عنوان خدمات</p>
                                            <input name="title" style=";;text-align: right;background-color: #fff"
                                                   type="text"
                                                   class="p-2 flex-fill bd-highlight attribute form-control"
                                                   value="{{$service->title}}">
                                        </div>

                                        <div class="d-flex flex col-lg-12" style="margin:20px 0;">
                                            <p style="margin-top: 10px;white-space: nowrap;"">توضیحات</p>
                                            <textarea name="description"
                                                      style=";width: 30%;text-align: right;background-color: #fff"
                                                      type="text" rows="12"
                                                      class=" p-2 flex-fill bd-highlight attribute form-control"
                                                      value="" id="imgload">{{$service->description}}</textarea>
                                        </div>

                                        <div class="col-lg-4"></div>
                                        <div class="col-lg-4"></div>
                                        <img id="imgshow" class="col-lg-4" alt="" style=" ;margin: 0">
                                        <button type="submit" formaction="{{url('/service/edit')}}"
                                                class="btn btn-success "
                                                style="margin-top: 20px;margin-right:20px;float: right;display:block">
                                            ویرایش خدمات
                                        </button>

                                    </div>

                                </div>
                            {{--ویرایش--}}
                        </form>

                    </div>

                </div>
        </div>
        @endforeach

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
    </script>
@endsection