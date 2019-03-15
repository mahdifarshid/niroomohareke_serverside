@extends('layouts.admin_layout')
@section('header')
    {{--<link rel="stylesheet" href="{{asset('css/load-styles.css')}}">--}}
    <title>ویرایش دسته بندی</title>
@endsection

@section('content')
    <div class="container" style="width: 100%;">
        <form action="{{url('category/editcat')}}" style="width: 100%" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            @if(isset($category))
                <input type="hidden" name="id" value="{{$category->id}}">
            @endif

            <div class="container">
                <div class="card" style="margin-top: 20px;margin-left: 5%;margin-right: 5%">
                    <div class="card-body" style="padding: 50px;direction: rtl">
                        <h3 style="color: #AB0D00;text-align: right;padding-bottom: 20px">ویرایش دسته بندی</h3>
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
                                   value="@if(isset($category)) {{$category->cat_name}}@endif">
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
                        <img id="imgshow" src="{{asset('images/category/'.$category->cat_image)}}" class="col-lg-4" alt="" style=" ;margin: 0">
                        <button type="submit" class="btn btn-success "
                                style="margin-top: 20px;margin-right: 10px;float: right">ویرایش دسته
                        </button>
                    </div>
                </div>
            </div>
        </form>
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
        <script type="text/javascript">
            try {
                document.forms.edittag.name.focus();
            } catch (e) {
            }
        </script>
        <script>
            $("#parent").val("{{\Illuminate\Support\Facades\Input::get('parent_id')}}");
        </script>
@endsection
