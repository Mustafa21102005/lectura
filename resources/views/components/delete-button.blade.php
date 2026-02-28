<button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal"
    data-bs-target="#deleteModal-{{ Str::slug($item . '-' . $id) }}">
    Delete
</button>

<div class="modal fade" id="deleteModal-{{ Str::slug($item . '-' . $id) }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ $action }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Are You Sure You Want To Delete?</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0 text-wrap">
                        Are you sure you want to delete this <strong>{{ $item }}</strong>?
                        <br>
                        <b class="text-danger">This action cannot be undone.</b>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
