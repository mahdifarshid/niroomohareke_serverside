@extends('layouts.admin_layout')
@section('header')
    {{--<link rel="stylesheet" href="{{asset('css/load-styles.css')}}">--}}
    <title>ویرایش مستند</title>
@endsection

@section('content')
    <div class="container" style="width: 100%;">
        <form action="{{url('document/editDoc')}}" style="width: 100%" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            @if(isset($document))
                <input type="hidden" name="id" value="{{$document->id}}">
            @endif
            <div class="container">
                <div class="card" style="margin-top: 20px;margin-left: 5%;margin-right: 5%">
                    <div class="card-body" style="padding: 50px;direction: rtl">
                        <h3 style="color: #AB0D00;text-align: right;padding-bottom: 20px">ویرایش مستند</h3>
                        <div @unless(count($errors))  @endunless >
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
                                <p style="margin-top: 10px;padding-left: 10px;white-space: nowrap;">عنوان مستند</p>
                                <input name="title" style=";;text-align: right;background-color: #fff" type="text"
                                       class="p-2 flex-fill bd-highlight attribute form-control"
                                       value="@if(isset($document)) {{$document->title}}@endif">
                            </div>
                            <div class="d-flex col-lg-10" style="margin:20px 0">
                                <p style="margin-top: 10px;;padding-left: 10px;white-space: nowrap;">توضیحات مستند</p>
                                <textarea name="description" style=";;text-align: right;background-color: #fff"
                                          type="text"
                                          class="p-2 flex-fill bd-highlight attribute form-control"
                                          rows="6"
                                          value="">@if(isset($document)) {{$document->description}}@endif</textarea>
                            </div>

                            <div class="d-flex col-lg-8" style="margin:20px 0">
                                <p style="margin-top: 10px;;padding-left: 10px;white-space: nowrap;">دسته بندی</p>
                                <select name="cat_id" id="categories" style="width: 200px;;margin-right: 30px">
                                    @foreach($categories as $cat)
                                        <option value="{{$cat->id}}">{{$cat->title}}</option>
                                    @endforeach
                                </select>
                                <script>
                                    @if(isset($document))
                                    $("#categories").val({{$document->cat_id}});
                                    @endif
                                </script>
                            </div>

                            <div class="d-flex flex col-lg-8" style="margin:20px 0;">
                                <p style="margin-top: 10px;;padding-left: 20px;white-space: nowrap;"">انتخاب pdf</p>
                                <input name="pdf" style=";width: 30%;text-align: right;background-color: #fff"
                                       type="file"
                                       class=" p-2 flex-fill bd-highlight attribute form-control"
                                       value="" id="imgload">
                                @unless(empty($document->doc))
                                        <a href="{{url('docs/'.$document->doc)}}"><img src="{{url('icon/pdf.png')}}" style="width: 50px;width: 50px;margin-right: 20px"></a>
                                        <a onclick="return checkDelete()" href="{{url('document/deletefile/'.$document->id)}}">حذف سند</a>
                                @endunless
                            </div>


                            <button type="submit" class="btn btn-success "
                                    style="margin-top: 20px;margin-right:10px;float: right">اضافه کردن مستند
                            </button>

                        </div>
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
        function checkDelete() {
            return confirm('ایا از حذف مطمنید؟');
        }
        $("#parent").val("{{\Illuminate\Support\Facades\Input::get('parent_id')}}");
    </script>
@endsection
