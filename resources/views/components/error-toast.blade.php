<div class="position-fixed bottom-1 end-1 z-index-2" style="transition: opacity 0.5s ease-in-out;">
    <div class="toast fade show p-2 mt-2 bg-white" role="alert" aria-live="assertive" id="dangerToast" aria-atomic="true"
        style="opacity: 0;">
        <div class="toast-header border-0">
            <i class="material-icons text-danger me-2">campaign</i>
            <span class="me-auto text-gradient text-danger font-weight-bold">Error</span>
            <small class="text-body">Just now</small>
            <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
        </div>
        <hr class="horizontal dark m-0">
        <div class="toast-body">
            {{ $message }}
        </div>
    </div>
</div>

<script>
    setTimeout(() => {
        document.getElementById('dangerToast').style.opacity = 1;
    }, 100);
    setTimeout(() => {
        document.getElementById('dangerToast').style.opacity = 0;
        setTimeout(() => {
            document.getElementById('dangerToast').remove();
        }, 500);
    }, 7000);
</script>
