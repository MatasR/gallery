<div class="image-popup modal fade">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <img src>
        <button type="button" class="close bg-white rounded-circle" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <h2 class="mb-0 d-inline-block w-100"></h2>
        <a href="#" id="author" class="text-secondary mb-0"></a>
        <p id="desc" class="mb-0"></p>
      </div>

      <div class="modal-footer border-0 pt-0 justify-content-start">
        <a href="/apie-mus" type="button" class="btn btn-secondary rounded-pill">Kreiptis</a>
        @if (Auth::user() && Auth::user()->hasRole('admin'))
          <a href="#" type="button" target="_blank" id="edit" class="btn btn-info rounded-pill">Redaguoti</a>
        @endif
      </div>

    </div>
  </div>
</div>
