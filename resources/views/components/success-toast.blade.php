@if (session('success'))
    <div class="position-fixed bottom-1 end-1 z-index-2" style="transition: opacity 0.5s ease-in-out;">
        <div class="toast fade show p-2 bg-white" role="alert" aria-live="assertive" aria-atomic="true" id="successToast"
            style="opacity: 0;">
            <div class="toast-header border-0">
                <i class="material-icons text-success me-2">check</i>
                <span class="me-auto font-weight-bold">Success</span>
                <small class="text-body">Just now</small>
            </div>
            <hr class="horizontal dark m-0">
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('successToast').style.opacity = 1;
        }, 100);
        setTimeout(() => {
            document.getElementById('successToast').style.opacity = 0;
            setTimeout(() => {
                document.getElementById('successToast').remove();
            }, 500);
        }, 7000);
    </script>
@endif
