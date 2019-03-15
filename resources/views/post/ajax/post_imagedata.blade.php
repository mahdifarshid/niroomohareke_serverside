@if(isset($images))

    @foreach($images as $image)
        <img class="mySlides"  id="{{$image->id}}" src="{{url('images/products/'.$image->resized_name)}}" style="width:100%">
    @endforeach

    @foreach($images as $image)
            <img src="{{url('images/products/'.$image->resized_name)}}" style="float: left; width: 20%;   padding: 10px;">
    @endforeach

@endif