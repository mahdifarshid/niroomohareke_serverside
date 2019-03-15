@extends('layouts.admin_layout')
@section('header')
    <title>مستندات</title>
    {{--<link rel="stylesheet" href="{{asset('css/load-styles.css')}}">--}}
@endsection

@section('content')
    <div class="container" style="width: 100%;">
        <form action="{{url('document/addDocument')}}" style="width: 100%" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="container">
                <div class="card" style="margin-top: 20px;margin-left: 5%;margin-right: 5%">
                    <div class="card-body" style="padding: 50px;direction: rtl">
                        <h3 style="color: #AB0D00;text-align: right;padding-bottom: 20px" data-toggle="collapse"
                            data-target="#collapseHeader" aria-expanded="false"
                            aria-controls="collapseHeader">اضافه کردن مستند</h3>

                        <div @unless(count($errors)) class="collapse" @endunless  id="collapseHeader">
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
                                       value="">
                            </div>
                            <div class="d-flex col-lg-10" style="margin:20px 0">
                                <p style="margin-top: 10px;;padding-left: 10px;white-space: nowrap;">توضیحات مستند</p>
                                <textarea name="description" style=";;text-align: right;background-color: #fff"
                                          type="text"
                                          class="p-2 flex-fill bd-highlight attribute form-control"
                                          rows="6"
                                          value=""></textarea>
                            </div>

                            <div class="d-flex col-lg-8" style="margin:20px 0">
                                <p style="margin-top: 10px;;padding-left: 10px;white-space: nowrap;">دسته بندی</p>
                                <select name="cat_id" id="categories" style="width: 200px;;margin-right: 30px">
                                    @foreach($categories as $cat)
                                        <option value="{{$cat->id}}">{{$cat->title}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex flex col-lg-8" style="margin:20px 0;">
                                <p style="margin-top: 10px;;padding-left: 20px;white-space: nowrap;"">انتخاب pdf</p>
                                <input name="pdf" style=";width: 30%;text-align: right;background-color: #fff"
                                       type="file"
                                       class=" p-2 flex-fill bd-highlight attribute form-control"
                                       value="" id="imgload">
                            </div>

                            <div class="col-lg-4"></div>
                            <div class="col-lg-4"></div>
                            <img id="imgshow" class="col-lg-4" alt="" style=" ;margin: 0">
                            <button type="submit" class="btn btn-success "
                                    style="margin-top: 20px;margin-right:10px;float: right">اضافه کردن مستند
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="tablenav top">
            <h1 class="wp-heading-inline"></h1>
            {{--style="margin-bottom: 30px; margin: 25px 50px;display: block">@if(\Illuminate\Support\Facades\Input::get('cat')!=""&&\Illuminate\Support\Facades\Input::get('id')!=0)--}}
            {{--زیر دسته ی {{ \Illuminate\Support\Facades\Input::get('cat')}}@endif</h1>--}}
            {{----}}
            <form action="{{url('document')}}" style="width: 100%" method="get"
                  enctype="multipart/form-data">
                <div style="margin-top:50px;margin-bottom: 50px;display: flex;margin-right: 10%">
                    <h3 style="color: #AB0D00;margin: 0">انتخاب دسته بندی</h3>
                    <select name="cat_id" id="category" style="width: 200px;;margin-right: 30px">
                        <option value="all">کل مستندات</option>
                        @foreach($categories as $cat)
                            <option value="{{$cat->id}}">{{$cat->title}}</option>
                        @endforeach
                    </select>
                    <script>
                        $("#category").val(@if(isset($_GET['cat_id'])){{$_GET['cat_id']}}@endif);

                    </script>
                    <button type="submit" class="btn btn-success" style="margin-right: 14px">انتخاب</button>
                </div>
            </form>
            <script>
                $(function () {
                    $('#category').change(function () {
                        this.form.submit();
                    });
                });
            </script>
            <table class="table" style="width: 88%;;margin-left: 5%;margin-top: 30px;margin-right: 6%">
                <thead class="btn-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان</th>
                    <th scope="col">pdf</th>
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
                @foreach($documents as $doc)
                    <tr>
                        <th scope="row">{{$count++}}</th>
                        <td>{{$doc->title}}</td>
                        <td>
                            @unless(empty($doc->doc))
                            <a href="{{url('docs/'.$doc->doc)}}"><img src="{{url('icon/pdf.png')}}"
                                                       style="width: 40px;width: 40px"></a>
                                @endunless
                        </td>
                        <td><a href="{{url('/document/delete/'.$doc->id)}}" onclick="return checkDelete()">حذف</a></td>
                        <td>
                            <a href="{{url('/document/editDocument/'.$doc->id)}}">ویرایش</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$documents->links()}}
        </div>
        <script language="JavaScript" type="text/javascript">
            function checkDelete() {
                return confirm('ایا از این دسته مطمنید؟ کل کالاهای این دسته بندی حذف خواهد شد!!!');
            }
        </script>
    </div>
@endsection
