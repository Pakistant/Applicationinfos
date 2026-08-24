 <script src="{{asset('back_auth/assets/js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('back_auth/assets/js/popper.min.js')}}"></script>
    <script src="{{asset('back_auth/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('back_auth/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('back_auth/assets/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('back_auth/assets/plugins/morris/morris.min.js')}}"></script>
    <script src="{{asset('back_auth/assets/js/chart.morris.js')}}"></script>
    <script src="{{asset('back_auth/assets/plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('back_auth/assets/js/script.js')}}"></script>
    <script src="{{asset('back_auth/assets/js/article-editor.js')}}"></script>
    <script>
        window.addEventListener("load", function(){
            document.getElementById("loader").style.display = "none";
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>

    <script>
document.addEventListener("DOMContentLoaded", function() {
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var url = button.data('url'); 
        var form = $(this).find('#deleteForm');
        form.attr('action', url);
    });
});
</script>
