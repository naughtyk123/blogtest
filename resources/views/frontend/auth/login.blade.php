@extends('includes.default')
@section('content')
<style>
    .tox-notification {
        display: none !important;
    }
</style>
<div class="row" style="justify-content:center">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">Log in</div>
            <div class="card-body">
                <form id="login_form">
                    @csrf
                    <div class="row">
               
                        <div class="col-md-12 mb-4">
                            <label>Email *</label>
                            <input type="text" name="email" id="email" class="form-control">
                        </div>

                        <div class="col-md-12 mb-4">
                            <label>Password *</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>

                        <div class="col-md-12 mb-4">
                            <input type="button" onclick="attempt_login()" class="btn btn-primary form-control" value="Login">
                            <center>OR</center>
                            <center> <a href="{{url('register')}}">Register</a></center>
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
    function attempt_login() {
        event.preventDefault();
        var form = document.getElementById('login_form');
        var formData = new FormData(form);

        $.ajax({
            type: 'POST',
            url: '/attempt_login',
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
                    $.toast({
                        heading: 'Success',
                        text: data.message,
                        showHideTransition: 'slide',
                        icon: 'success',
                        position: 'top-right',
                        afterHidden: function() {
                            window.loaction.reload();
                        }
                    });
                    window.location.href = '/'

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
</script>

@stop