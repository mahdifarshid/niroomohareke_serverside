<div>
    <div id="category" class="alert alert-danger" style="line-height: 2;display: none">
        <a href=""> دسته بندی انتخاب نشده</a>
    </div>
    <script>
        var cat_id = $('input[name=category_id]:checked').val();
        if (cat_id === undefined) {
            $('#category').show();
        }
    </script>

    @if(isset($attributes))
        <div id="feature" class="alert alert-info" style="line-height: 2;display: none">
            <a href=""> شما هیچ ویژگی به این دسته بندی تعریف نکرده اید برای اضافه کردن ویژگی کلیک کنید</a>
        </div>

        @if(count($attributes)==0)
            <script>
                $("input[name='category_id']").change(function () {
                    var cat_id = $('input[name=category_id]:checked').val();
                    var cat_name = $('input[name=category_id]:checked').attr('cat_name');
                    // alert(cat_id);
                    $('#p_cat').text(cat_name);
                    if (cat_id !== undefined) {
                        $('#feature').show();
                        $('#feature a').attr('href', '{{url('/feature?cat_id=')}}' + cat_id + '&cat_title=' + cat_name);
                    }
                    else {
                    }
                });
            </script>

        @endif
        @foreach($attributes as $attr)

            {{--@foreach($attr as $val)--}}
            <h4 style="margin-bottom: 20px">{{$attr['parent_title']}}</h4>
            @foreach($attr['Attr_val'] as $val)
                <div class="d-flex bd-highlight">
                    {{--<input type="hidden" name="attr_product_id[]" value="{{$val['attr_product_id']}}">--}}
                    <input type="hidden" name="attr_id[]" value="{{$val['attr_id']}}">
                    <input name="attr_val[]" style="text-align: right;background-color: #fff"
                           type="text"
                           class=" p-2 flex-fill bd-highlight attribute form-control"
                           value="">
                    <div class="p-2 flex-fill bd-highlight attribute"
                         style="width: 55%">{{$val['title']}}</div>
                    {{--<div class="p-2 flex-fill bd-highlight attribute" style="width: 45%">{{$val['title']}}</div>--}}
                </div>

            @endforeach
            <hr>
            {{--@endforeach--}}
        @endforeach

    @endif
</div>