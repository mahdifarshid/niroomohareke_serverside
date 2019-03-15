
<script>
    $(document).ready(function () {
        $('#btnslider').on('click', function (e) {
            e.preventDefault();
            if (confirm('آیا از حذف عکس مطمن هستید؟')) {
                // var image = $('li.active img');
                // var myid = image.eq(0).attr('value');

                var imagesrc = $(".mySlides.active").attr("id");
                // alert(imagesrc);

                var image = "{{url('/post/images-delete')}}";
                var fullurl = image + "/" + imagesrc;
                $.ajax({
                    method: 'GET',
                    url: fullurl,
                    // data: {'id': text},
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (response) {
                        // $("#panel").append(response.html);
                        // $("#lightSlider li").remove();
                        // loadSlides();
                        loadSlides();

                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                    }
                });

// alert(image+"/"+myid);

                /*     var fullurl = image + "/" + myid;
                      window.location = fullurl;

      */

            }
        });
    });

    function loadSlides() {
        $('#slider img').remove();;
        $.ajax({
            method: 'POST',
            url: '{{url('/post/editpost/ajax')}}',
            data: {id:product_id},
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (response) {
// $("#lightSlider").append(response.html);
                console.log(response);
                $('#slider').append(response.html);
                showDivs(slideIndex);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // alert(JSON.stringify(jqXHR));
            }
        });
    }

    $('#imgload').change(function () {
        if ($(this).val() != '') {
            upload(this);
            $(this).val("");
        }
    });

    function upload(img) {
        var form_data = new FormData();
        form_data.append('post_image', img.files[0]);
        form_data.append('product_id', product_id);
        form_data.append('_token', '{{csrf_token()}}');
        $.ajax({
            url: "{{url('/post/addimage')}}",
            data: form_data,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.fail) {
                    // alert(data.errors['file']);
                }
                else {
                    // $("#lightSlider li").remove();
                    loadSlides();
                }
            },
            error: function (xhr, status, error) {
                // alert(xhr.responseText);
            }
        });
    }
    loadSlides();


    ///////attriburtes



</script>