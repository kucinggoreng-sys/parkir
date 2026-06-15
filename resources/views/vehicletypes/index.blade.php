@extends('be.master')

@section('menu')
  @include('be.menu')
@endsection

@section('vehicletypes')
  <!-- Navbar -->
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl bg-white shadow-sm my-3"
    id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-2 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
          <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Vehicle Type</li>
        </ol>
        <h6 class="font-weight-bolder mb-0 text-dark">Vehicle Type</h6>
      </nav>
      <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          <form action="{{ route('vehicletypes.index') }}" method="GET" class="input-group">
            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
            <input type="text" name="search" class="form-control" placeholder="Type here..." value="{{ $search ?? '' }}">
          </form>
        </div>
        <ul class="navbar-nav justify-content-end align-items-center gap-3">
          <li class="nav-item">
            <a href="{{ route('vehicletypes.create') }}"
              class="btn bg-gradient-primary btn-sm mb-0 text-white font-weight-bold px-4"
              style="background-image: linear-gradient(310deg, #cb0c9f 0%, #7928ca 100%);">
              + ADD NEW VEHICLE TYPE
            </a>
          </li>
          <li class="nav-item d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
              <i class="fa fa-user me-sm-1"></i>
              <span class="d-sm-inline d-none">Sign Out</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->

  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4 shadow-sm border-0">
          <div class="card-header pb-0 bg-transparent border-0">
            <h5 class="text-primary font-weight-bolder" style="color: #cb0c9f !important;">Vehicle Type <span
                class="text-secondary font-weight-normal text-sm">Data Table</span></h5>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-primary text-xxs font-weight-bolder opacity-7 ps-4"
                      style="color: #cb0c9f !important; width: 80px;">NO.</th>
                    <th class="text-uppercase text-primary text-xxs font-weight-bolder opacity-7"
                      style="color: #cb0c9f !important;">VEHICLE TYPE</th>
                    <th class="text-uppercase text-primary text-xxs font-weight-bolder opacity-7 text-center"
                      style="color: #cb0c9f !important;">FIRST MINUTE CHARGES</th>
                    <th class="text-uppercase text-primary text-xxs font-weight-bolder opacity-7 text-center"
                      style="color: #cb0c9f !important;">NEXT MINUTE CHARGES</th>
                    <th class="text-uppercase text-primary text-xxs font-weight-bolder opacity-7 text-center"
                      style="color: #cb0c9f !important;">MAX COST PER DAY</th>
                    <th class="text-uppercase text-primary text-xxs font-weight-bolder opacity-7 text-center"
                      style="color: #cb0c9f !important; width: 150px;">ACTIONS</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($vehicleTypes as $vehicleType)
                    <tr>
                      <td class="ps-4">
                        <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                      </td>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm font-weight-bold text-dark text-capitalize">{{ $vehicleType->jenis }}
                            </h6>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">Rp
                          {{ number_format($vehicleType->perjam_pertama, 0, ',', '.') }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">Rp
                          {{ number_format($vehicleType->perjam_berikutnya, 0, ',', '.') }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">Rp
                          {{ number_format($vehicleType->max_perhari, 0, ',', '.') }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <a href="{{ route('vehicletypes.edit', $vehicleType->id) }}"
                          class="btn btn-sm btn-link text-info font-weight-bold px-2 py-1 mb-0">
                          <i class="fas fa-edit me-1"></i> Edit
                        </a>

                        <form action="{{ route('vehicletypes.destroy', $vehicleType->id) }}" method="POST"
                          class="d-inline delete-vehicle-type-form">
                          @csrf
                          @method('DELETE')
                          <button type="button"
                            class="btn btn-sm btn-link text-danger font-weight-bold px-2 py-1 mb-0 delete-btn">
                            <i class="fas fa-trash me-1"></i> Delete
                          </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center py-4">
                        <span class="text-secondary text-xs">No vehicle types found.</span>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer pt-3 mt-4">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-12 mb-lg-0 mb-4 text-center text-lg-start">
            <div class="copyright text-sm text-muted">
              &copy; 2025, made with <i class="fa fa-heart text-danger"></i> by <strong>Bahy Alhady XI SIJA 2</strong> for
              ASAS Ganjil Web And Mobile Development - SMKN 1 Cibinong.
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <!-- Delete confirmation script -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const deleteButtons = document.querySelectorAll(".delete-btn");
      deleteButtons.forEach(button => {
        button.addEventListener("click", function (e) {
          e.preventDefault();
          const form = this.closest(".delete-vehicle-type-form");

          if (typeof swal === 'function') {
            swal({
              title: "Are you sure?",
              text: "This vehicle type will be deleted permanently!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#cb0c9f",
              confirmButtonText: "Yes, delete it!",
              cancelButtonText: "Cancel",
              closeOnConfirm: true
            }, function () {
              form.submit();
            });
          } else {
            if (confirm("Are you sure you want to delete this vehicle type?")) {
              form.submit();
            }
          }
        });
      });
    });
  </script>

  <!-- Trigger alerts on session success or error -->
  @if (session('success'))
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        if (typeof swal === 'function') {
          swal({
            title: "Good Job",
            text: "{{ session('success') }}",
            type: "success",
            confirmButtonColor: "#cb0c9f",
            confirmButtonText: "OK"
          });
        } else {
          alert("{{ session('success') }}");
        }
      });
    </script>
  @endif

  @if ($errors->any())
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const errorMessage = "{{ $errors->first() }}";
        if (typeof swal === 'function') {
          swal({
            title: "Error!",
            text: errorMessage,
            type: "error",
            confirmButtonColor: "#cb0c9f"
          });
        } else {
          alert("Error: " + errorMessage);
        }
      });
    </script>
  @endif
@endsection