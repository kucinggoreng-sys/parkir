@extends('be.master')

@section('menu')
  @include('be.menu')
@endsection

@section('locations')
  {{-- Navbar --}}
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-2 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
          <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Location</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">Location</h6>
      </nav>
      <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <ul class="navbar-nav ms-auto justify-content-end align-items-center">
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
  {{-- End Navbar --}}

  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm border-0 px-2 py-2">

          {{-- Card Title --}}
          <div class="card-header pb-0 bg-transparent border-0 pt-3">
            <h5 class="font-weight-bolder mb-0">
              <span style="color: #cb0c9f;">Location</span>
              <span class="text-secondary fw-normal ms-1">Input Form</span>
            </h5>
          </div>

          <div class="card-body pt-3 pb-4 px-4">

            {{-- Validation Errors --}}
            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>
                <ul class="mb-0 mt-1">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form action="{{ route('locations.store') }}" method="POST">
              @csrf

              {{-- Location Name --}}
              <div class="mb-4">
                <label for="location_name" class="form-control-label font-weight-bold d-block mb-2">Location Name</label>
                <input type="text" class="form-control @error('location_name') is-invalid @enderror" id="location_name"
                  name="location_name" value="{{ old('location_name') }}" placeholder="Enter location name" autofocus
                  style="border-radius: 0.5rem; border: 1px solid #ddd; padding: 0.75rem;">
                @error('location_name')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Max Motorcycle --}}
              <div class="mb-4">
                <label for="max_motorcycle" class="form-control-label font-weight-bold d-block mb-2">Max
                  Motorcycle</label>
                <input type="number" class="form-control @error('max_motorcycle') is-invalid @enderror"
                  id="max_motorcycle" name="max_motorcycle" value="{{ old('max_motorcycle', 0) }}" min="0" placeholder="0"
                  style="border-radius: 0.5rem; border: 1px solid #ddd; padding: 0.75rem;">
                @error('max_motorcycle')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Max Car --}}
              <div class="mb-4">
                <label for="max_car" class="form-control-label font-weight-bold d-block mb-2">Max Car</label>
                <input type="number" class="form-control @error('max_car') is-invalid @enderror" id="max_car"
                  name="max_car" value="{{ old('max_car', 0) }}" min="0" placeholder="0"
                  style="border-radius: 0.5rem; border: 1px solid #ddd; padding: 0.75rem;">
                @error('max_car')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Max Truck/Bus/Other --}}
              <div class="mb-5">
                <label for="max_other" class="form-control-label font-weight-bold d-block mb-2">Max
                  Truck/Bus/Other</label>
                <input type="number" class="form-control @error('max_other') is-invalid @enderror" id="max_other"
                  name="max_other" value="{{ old('max_other', 0) }}" min="0" placeholder="0"
                  style="border-radius: 0.5rem; border: 1px solid #ddd; padding: 0.75rem;">
                @error('max_other')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Buttons --}}
              <div class="row g-3 mt-2">
                <div class="col-6">
                  <a href="{{ route('locations.index') }}"
                    class="btn w-100 mb-0 font-weight-bold text-uppercase text-white"
                    style="background-color: #2c3266; padding: 0.75rem; border-radius: 0.5rem; letter-spacing: 0.5px; font-size: 0.875rem;">
                    CANCEL
                  </a>
                </div>
                <div class="col-6">
                  <button type="submit" class="btn w-100 mb-0 font-weight-bold text-uppercase text-white"
                    style="background-image: linear-gradient(310deg, #cb0c9f 0%, #7928ca 100%); padding: 0.75rem; border-radius: 0.5rem; letter-spacing: 0.5px; font-size: 0.875rem;">
                    SAVE LOCATION
                  </button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

    {{-- Footer --}}
    <footer class="footer pt-3 mt-4">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-12">
            <div class="copyright text-center text-sm text-muted">
              &copy; 2025, made with <i class="fa fa-heart text-danger"></i> by
              <strong>Coding Lover</strong> for ASAS Ganjil Web And Mobile Development - SMKN 1 Cibinong.
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
@endsection