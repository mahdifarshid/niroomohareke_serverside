<!DOCTYPE html>
<html>
<head>
    <title>ثبت خدمات جدید</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>

<form action="{{url('/khadamat/add')}}" method="post">
    {{csrf_field()}}
    <div class="container">
        <div class="  col-lg-12" style="margin:20px 0;direction: rtl">
            <p style="float: right;white-space: nowrap;">عنوان خدمات</p>
            <input name="title" style=";;text-align: right;background-color: #fff"
                   type="text"
                   class="p-2 col-lg-12 flex-fill bd-highlight attribute form-control"
                   value="">
        </div>
        <textarea name="html" style="margin: 0 auto" class="tinymce"></textarea>
        <button style="float: right; width: 10%" class="btn btn-success m-2">ثبت</button>
    </div>
</form>

<div class="col-lg-12 container" style="float: right">
    @if(count($errors))
        @foreach($errors->all() as $error)
            <div class="d-flex col-lg-12" style="margin:5px 5px">
                <div class="alert alert-danger">
                    {{ $error}}
                </div>
            </div>
        @endforeach
    @endif

</div>


<!-- javascript -->
<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('plugin/tinymce/tinymce.min.js')}}"></script>
{{--<script type="text/javascript" src="{{asset('plugin/tinymce/init-tinymce.js')}}"></script>--}}
@include('khadamat.tiny')
</body>
</html>