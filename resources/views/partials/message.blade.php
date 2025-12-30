<!-- Success Message -->
@if(session('success'))
  <div id="successMessage" class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" style="display: none;z-index: 9999;">
    <i class="bi bi-check-circle me-2"></i> <!-- Bootstrap icon for success -->
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Error Message -->
@if(session('error'))
  <div id="errorMessage" class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" style="display: none;z-index: 9999">
    <i class="bi bi-x-circle me-2"></i> <!-- Bootstrap icon for error -->
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
