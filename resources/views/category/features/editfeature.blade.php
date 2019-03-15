@extends('layouts.admin_layout')
@section('header')
    {{--    <link rel="stylesheet" href="{{asset('css/load-styles.css')}}">--}}
    <title>ویرایش ویژگی</title>
@endsection

@section('content')

    <div class="container" style="width: 100%;">
        <form action="{{url('/feature/editfea')}}" style="width: 100%" method="post" >
            {{csrf_field()}}
            <input type="hidden" name="feature_title"
                   value="{{\Illuminate\Support\Facades\Input::get('feature_title')}}">
            <input type="hidden" name="feature_id"
                   value="{{\Illuminate\Support\Facades\Input::get('fea_id')}}">
            <input type="hidden" name="cat_id" value="{{\Illuminate\Support\Facades\Input::get('cat_id')}}">
            @if(isset($_GET['action']))
                @if($_GET['action']=='sub')
                    <input type="hidden" name="sub" value="sub">
                @endif
            @endif

            <div class="container">
                <div class="card" style="margin-top: 20px;margin-left: 5%;margin-right: 5%">
                    <div class="card-body" style="padding: 50px;direction: rtl">
                        <h3 style="color: #AB0D00;text-align: right;padding-bottom: 20px">ویرایش ویژگی</h3>
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
                            <p style="margin-top: 10px;white-space: nowrap;">عنوان گالری</p>
                            <input name="name" style=";;text-align: right;background-color: #fff" type="text"
                                   class="p-2 flex-fill bd-highlight attribute form-control"
                                   value="{{\Illuminate\Support\Facades\Input::get('feature_title')}}" size="40">
                        </div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4"></div>
                        <img id="imgshow" class="col-lg-4" alt="" style=" ;margin: 0">
                        <button type="submit" class="btn btn-success "
                                style="margin-top: 20px;margin-right:10px;float: right">اضافه کردن دسته
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
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
