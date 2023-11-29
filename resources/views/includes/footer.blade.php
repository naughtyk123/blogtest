</div>
<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container">
        <?php
        $year = date("Y");

        ?>
        <p class="m-0 text-center text-white">Copyright &copy; My Blog {{$year}}</p>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield('script')
<script>
    function delete_post(id) {
        Swal.fire({
            title: "Do you want to delet this post?",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Yes",
            denyButtonText: `No`
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '/delete_post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                    },
                    beforeSend: function() {},
                    success: function(data) {

                        if (data.status == "true") {

                            $.toast({
                                heading: 'Success',
                                text: data.message,
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
            } else if (result.isDenied) {
                // Swal.fire("Changes are not saved", "", "info");
            }
        });


    }
</script>
</body>

</html>