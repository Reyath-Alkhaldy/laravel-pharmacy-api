<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    Delete Customer
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Are you sure you want to continue delete the customer?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                {{-- <form action="{{ route('web.pharmacies.destroy',  ) }}" method="post">
                  @csrf
                  @method('delete') --}}
                    <button type="submit" class="btn btn-danger .remove-item " data-bs-dismiss="modal">
                        Delete
                    </button>
                {{-- </form> --}}
            </div>
        </div>
    </div>
</div>
