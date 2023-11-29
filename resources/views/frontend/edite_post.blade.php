@extends('includes.default')
@section('content')
<style>
    .tox-notification {
        display: none !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Edite Post</div>
            <div class="card-body">
                <form id="post_form">
                    <div class="row">


                        @csrf
                        <div class="col-md-6 mb-4">
                            <label>Categories *</label>
                            <select class="form-control" name="cat" id="cat">
                                <option value="">Select</option>
                                @foreach($cats as $cat)

                                <option @if($cat->id == $post->categorie_id) selected  @endif value="{{$cat->id}}">{{$cat->category_name}}</option>

                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-6 mb-4">
                            <label>Title *</label>
                            <input type="text" name="title" id="title" value="{{$post->title}}" class="form-control">
                        </div>

                        <div class="col-md-12 mb-4">
                            <label>Images </label>
                            <input type="file" name="images" id="images" class="form-control">

                        </div>


                        <div class="col-md-12 mb-4">
                            <label>Post *</label><label id="post_text"></label>
                            <textarea id="post" name="post"> {!!$post->post!!} </textarea>
                        </div>

                        <div class="col-md-12 mb-4">
                            <input onclick="save_post('{{$post->id}}')" style="float: right;" type="button" class="btn btn-primary" value="Save">
                        </div>


                    </div>
                </form>

            </div>
        </div>
    </div>

</div>

@stop
@section('script')
<script>
    function save_post(id) {

        event.preventDefault();
        var form = document.getElementById('post_form');
        var formData = new FormData(form);
        var myContent = tinymce.activeEditor.getContent();
        formData.append('post_text', myContent);
        formData.append('id', id);

        $.ajax({
            type: 'POST',
            url: '/edite_post_record',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status == "errors") {
                    $(".validationMessage").remove();
                    $.each(data.error, function(key, val) {
                        // if($.isArray(val[0])){
                        if (typeof val[0] === 'object') {
                            $.each(val[0], function(key2, val2) {
                                $('.' + key2).after('<p class="validationMessage">' + val2 + '</p>');
                            });
                        } else {
                            $('#' + key).after('<p class="validationMessage">' + val[0] + '</p>');
                            $.toast({
                                heading: 'Error',
                                text: val[0],
                                showHideTransition: 'fade',
                                icon: 'error',
                                position: 'top-right',

                            });

                        }
                    });
                }
                if (data.status == "true") {
                    tinymce.activeEditor.uploadImages();
                    $.toast({
                        heading: 'Success',
                        text: 'Post added',
                        showHideTransition: 'slide',
                        icon: 'success',
                        position: 'top-right',
                        afterShown: function() {
                            window.location.reload();
                        },
                    });
                    

                }
                if (data.status == "false") {
                    $.toast({
                        heading: 'Error',
                        text: data.message,
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right',
                    });
                }
            }
        });
    }
    //  tinymce image upload haddle
    var image_upload_handler_callback = (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '{{route("uploadstiny")}}');
        var token = '{{ csrf_token() }}';
        xhr.setRequestHeader("X-CSRF-Token", token);
        xhr.upload.onprogress = (e) => {
            progress(e.loaded / e.total * 100);
        };
        xhr.onload = () => {
            if (xhr.status === 403) {
                reject({
                    message: 'HTTP Error: ' + xhr.status,
                    remove: true
                });
                return;
            }
            if (xhr.status < 200 || xhr.status >= 300) {
                reject('HTTP Error: ' + xhr.status);
                return;
            }
            const json = JSON.parse(xhr.responseText);
            if (!json || typeof json.location != 'string') {
                reject('Invalid JSON: ' + xhr.responseText);
                return;
            }
            resolve(json.location);
        };
        xhr.onerror = () => {
            reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };
        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    });
    // end
    // tinymce init
    tinymce.init({

        setup(editor) {
            editor.on("keydown", function(e) {
                if ((e.keyCode == 8 || e.keyCode == 46) && tinymce.activeEditor.selection) {
                    var selectedNode = tinymce.activeEditor.selection.getNode();
                    if (selectedNode && selectedNode.nodeName == 'IMG') {
                        var imageSrc = selectedNode.src;
                        $.ajax({
                            type: 'POST',
                            url: '/remove_tiny_image',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "imageSrc": imageSrc,
                            },
                            success: function(data) {

                            }
                        });
                    }

                }
            });
        },
        automatic_uploads: false,
        selector: '#post',
        plugins: [
            'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',
            'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
            'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help', 'wordcount', 'image code'
        ],
        toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help | image code',
        images_upload_handler: image_upload_handler_callback
    });
    // end
</script>

@stop