@extends('be.master')

@section('menu')
  @include('be.menu')
@endsection

@section('vehicletypes')
  {{-- Navbar --}}
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-2 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
          <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Vehicle Type</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">Vehicle Type</h6>
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
              <span style="color: #cb0c9f;">Vehicle Type</span>
              <span class="text-secondary fw-normal ms-1">Input Form</span>
            </h5>
          </div>

          <div class="card-body pt-3 pb-4 px-4">

            {{-- Validation Errors --}}
            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show text-white" role="alert"
                style="background-image: linear-gradient(310deg, #ea0606 0%, #ff667c 100%);">
                <strong>Error!</strong>
                <ul class="mb-0 mt-1">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form action="{{ route('vehicletypes.store') }}" method="POST">
              @csrf

              {{-- Vehicle Type Dropdown --}}
              <div class="mb-4">
                <label for="jenis" class="form-control-label font-weight-bold d-block mb-2">Vehicle Type</label>
                <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" autofocus
                  style="border-radius: 0.5rem; border: 1px solid #ddd; padding: 0.75rem;">
                  <option value="" disabled selected>Select vehicle type</option>
                  <option value="motorcycle" {{ old('jenis') == 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                  <option value="car" {{ old('jenis') == 'car' ? 'selected' : '' }}>Car</option>
                  <option value="other" {{ old('jenis') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('jenis')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- First Minute Charges --}}
              <div class="mb-4">
                <label for="perjam_pertama" class="form-control-label font-weight-bold d-block mb-2">First Minute
                  Charges</label>
                <input type="number" class="form-control @error('perjam_pertama') is-invalid @enderror"
                  id="perjam_pertama" name="perjam_pertama" value="{{ old('perjam_pertama') }}" min="0"
                  placeholder="e.g. 2000" style="border-radius: 0.5rem; border: 1px solid #ddd; padding: 0.75rem;">
                @error('perjam_pertama')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Next Minute Charges --}}
              <div class="mb-4">
                <label for="perjam_berikutnya" class="form-control-label font-weight-bold d-block mb-2">Next Minute
                  Charges</label>
                <input type="number" class="form-control @error('perjam_berikutnya') is-invalid @enderror"
                  id="perjam_berikutnya" name="perjam_berikutnya" value="{{ old('perjam_berikutnya') }}" min="0"
                  placeholder="e.g. 1000" style="border-radius: 0.5rem; border: 1px solid #ddd; padding: 0.75rem;">
                @error('perjam_berikutnya')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Max Cost Per Day --}}
              <div class="mb-5">
                <label for="max_perhari" class="form-control-label font-weight-bold d-block mb-2">Max Cost Per Day</label>
                <input type="number" class="form-control @error('max_perhari') is-invalid @enderror" id="max_perhari"
                  name="max_perhari" value="{{ old('max_perhari') }}" min="0" placeholder="Enter max cost per day"
                  style="border-radius: 0.5rem; border: 1px solid #ddd; padding: 0.75rem;">
                @error('max_perhari')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Buttons --}}
              <div class="row g-3 mt-2">
                <div class="col-6">
                  <a href="{{ route('vehicletypes.index') }}"
                    class="btn w-100 mb-0 font-weight-bold text-uppercase text-white"
                    style="background-color: #2c3266; padding: 0.75rem; border-radius: 0.5rem; letter-spacing: 0.5px; font-size: 0.875rem;">
                    CANCEL
                  </a>
                </div>
                <div class="col-6">
                  <button type="submit" class="btn w-100 mb-0 font-weight-bold text-uppercase text-white"
                    style="background-image: linear-gradient(310deg, #cb0c9f 0%, #7928ca 100%); padding: 0.75rem; border-radius: 0.5rem; letter-spacing: 0.5px; font-size: 0.875rem;">
                    SAVE VEHICLE TYPE
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