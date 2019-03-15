@extends('layouts.admin_layout')
@section('header')
    <title>خدمات</title>
    <script src="{{asset('js/float-panel.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

@endsection
@section('content')
    <div class="container" style="padding-bottom: 80px">

        <table class="table" style="margin-top:40px;width: 100%">
            <thead class="btn-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">عنوان</th>
                <th scope="col">مشاهده ی خدمات</th>
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
            @foreach($services as $service)
                <tr>
                    <th scope="row">{{$count++}}</th>
                    <td>{{$service->title}}</td>
                    <td><a href="{{url('/khadamat/show/'.$service->id)}}">مشاهده خدمات</a></td>
                    <td><a href="{{route('khadamat.delete',['id'=>$service->id])}}"
                           onclick="return  confirm('آیا از حذف این خدمات مطمنید؟');">حذف</a></td>
                    <td><a href="{{url('/khadamat/editkhadamat/'.$service->id)}}">ویرایش</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$services->links()}}

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
    </div>
@endsection