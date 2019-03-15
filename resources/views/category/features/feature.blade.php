@extends('layouts.admin_layout')
@section('header')
    {{--<link rel="stylesheet" href="{{asset('css/load-styles.css')}}">--}}
    <title>ویژگی</title>
@endsection

@section('content')
    <style>
        th{
            text-align: center;
        }
    </style>
    <div class="container" style="width: 100%;">
        <form id="addtag" method="post" style="width: 100%" action="{{url('feature/addfeature')}}" class="validate">
            {{csrf_field()}}
            @if(\Illuminate\Support\Facades\Input::get('fea_id')!="")
                <input type="hidden" name="fea_id"
                       value="{{\Illuminate\Support\Facades\Input::get('fea_id')}}">
            @endif
            <input type="hidden" name="cat_id"
                   value="@if(\Illuminate\Support\Facades\Input::get('cat_id')!=""){{\Illuminate\Support\Facades\Input::get('cat_id')}}@else 0 @endif ">
            <input id="_wpnonce_add-tag" name="_wpnonce_add-tag" value="fe9f8bd261"
                   type="hidden">
            <div class="container">
                <div class="card" style="margin-top: 20px;margin-left: 5%;margin-right: 5%">
                    <div class="card-body" style="padding: 50px;direction: rtl">
                        <h3 style="color: #AB0D00;text-align: right;padding-bottom: 20px">اضافه کردن ویژگی</h3>
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
                            <p style="margin-top: 10px;white-space: nowrap;">عنوان ویژگی</p>
                            <input name="featurename" style=";;text-align: right;background-color: #fff" type="text"
                                   class="p-2 flex-fill bd-highlight attribute form-control"
                                   value="">
                        </div>

                        <div class="col-lg-4"></div>
                        <div class="col-lg-4"></div>
                        <img id="imgshow" class="col-lg-4" alt="" style=" ;margin: 0">
                        <button type="submit" class="btn btn-success "
                                style="margin-top: 20px;">اضافه کردن ویژگی
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <form method="post"  action="{{url('feature/editOrder')}}" >
            {{csrf_field()}}
            <table class="table" style="width: 70%;;margin-left: 20%;margin-top: 30px;margin-right: 15%">
                <thead class="btn-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ترتیب</th>
                    <th scope="col">عنوان</th>
                    @if(isset($_GET['action']))
                        @if($_GET['action']=='sub')

                        @endif
                    @else
                        <th scope="col">زیر ویژگی</th>
                    @endif

                    <th scope="col">حذف</th>
                    <th scope="col">ویرایش</th>
                </tr>
                </thead>
                <tbody>
                <?php $count = 1;?>
                @foreach($attributes as $attr)
                    <tr>
                        <th scope="row">{{$count++}}</th>
                        <td>
                            <div class="d-flex col-lg-12" style="margin:20px 0">
                                <input name="order[]" style="text-align: center;background-color: #fff" type="text"
                                       class="p-2 flex-fill bd-highlight attribute form-control"
                                       value="@if($attr->order_by!=0){{$attr->order_by}}@endif">
                                <input name="fea[]" value="{{$attr->id}}" type="hidden">
                            </div>
                        </td>
                        <td>{{$attr->title}}</td>
                        @if(isset($_GET['action']))
                            @if($_GET['action']=='sub')
                            @endif
                        @else
                            <td>
                                <a href="{{url('feature?cat_title='.$attr->title.'&cat_id='.\Illuminate\Support\Facades\Input::get('cat_id').'&fea_id='.$attr->id.'&action=sub')}}">زیر
                                    ویژگی</a></td>
                        @endif
                        <td><a onclick="return checkDelete()"
                               href="{{route('feature.delete',['id'=>$attr->id])}}">حذف</a></td>
                        <td>
                            @if(isset($_GET['action']))
                                @if($_GET['action']=='sub')
                                    <a href="{{url('/feature/editfeature?cat_id='.$_GET['cat_id'].'&fea_id='.$attr->id.'&feature_title='.$attr->title.'&action=sub')}}">ویرایش</a>
                                @endif
                            @else
                                <a href="{{url('/feature/editfeature?cat_id='.$_GET['cat_id'].'&fea_id='.$attr->id.'&feature_title='.$attr->title)}}">ویرایش</a>

                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
                {{ $attributes->appends(Illuminate\Support\Facades\Input::except('page'))->links() }}
        <button type="submit" class="btn btn-success "
                style="margin-top: 20px;">ویرایش ترتیب
        </button>
        </form>
    <script type="text/javascript">
        try {
            document.forms.addtag['tag-name'].focus();
        } catch (e) {
        }
    </script>
    <script language="JavaScript" type="text/javascript">
        function checkDelete() {
            return confirm('آیا از حذف این ویژگی مطمن هستید؟');
        }
    </script>
@endsection
