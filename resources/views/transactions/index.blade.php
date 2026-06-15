@extends('be.master')

@section('menu')
  @include('be.menu')
@endsection

@section('transactions')
  <style>
    .location-card {
      background-color: #ffffff;
      border: 2px solid #ddd !important;
      border-radius: 1rem;
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
      position: relative;
    }

    /* Efek saat kursor mouse berada di atas Card Gedung/Mall */
    .location-card:hover {
      transform: translateY(-5px);
      /* Card agak terangkat ke atas */
      border-color: #cb0c9f !important;
      /* Border berubah warna pink khas tema */
      box-shadow: 0 10px 20px rgba(203, 12, 159, 0.15) !important;
      /* Bayangan lebih tebal dan lembut */
    }

    /* Efek hover untuk item list tiket aktif di sidebar */
    .ticket-item {
      transition: all 0.2s ease-in-out !important;
    }

    .ticket-item:hover {
      transform: scale(1.02);
      /* Sedikit membesar halus */
      background-color: #f1f3f9 !important;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05) !important;
    }

    /* Custom CSS untuk mengubah warna gambar PNG hitam menjadi Hijau/Merah */
    .img-icon {
      width: 16px;
      height: 16px;
      object-fit: contain;
      display: inline-block;
    }

    /* Mengubah gambar hitam menjadi Hijau (#2dce89 / text-success) */
    .icon-success {
      filter: invert(67%) sepia(57%) saturate(541%) hue-rotate(101deg) brightness(92%) contrast(87%);
    }

    /* Mengubah gambar hitam menjadi Merah (#f5365c / text-danger) */
    .icon-danger {
      filter: invert(24%) sepia(91%) saturate(5603%) hue-rotate(346deg) brightness(101%) contrast(94%);
    }

    /* Mengubah gambar PNG menjadi Abu-abu senada dengan text-secondary Bootstrap */
    .icon-secondary {
      filter: grayscale(100%) brightness(0.6) opacity(0.7);
    }
  </style>

  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl bg-white shadow-sm my-3"
    id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-2 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
          <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Transaction</li>
        </ol>
        <h6 class="font-weight-bolder mb-0 text-dark">Transaction</h6>
      </nav>
      <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        </div>
        <ul class="navbar-nav justify-content-end align-items-center gap-2">
          @foreach($vehicleTypes as $vt)
            <li class="nav-item">
              <button type="button" class="btn btn-sm mb-0 px-3 py-2 text-uppercase font-weight-bold vt-select-btn"
                data-id="{{ $vt->id }}"
                style="border: 1px solid #2c3266; border-radius: 0.5rem; transition: all 0.2s ease;">
                {{ $vt->jenis }}
              </button>
            </li>
          @endforeach

          <li class="nav-item ms-2">
            <button type="button" id="enter-vehicle-btn"
              class="btn bg-gradient-primary btn-sm mb-0 text-white font-weight-bold px-4"
              style="background-image: linear-gradient(310deg, #cb0c9f 0%, #7928ca 100%);">
              + ENTER VEHICLE
            </button>
          </li>
          <li class="nav-item d-flex align-items-center ms-3">
            <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
              <i class="fa fa-user me-sm-1"></i>
              <span class="d-sm-inline d-none">Sign Out</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-lg-9 col-12">

        <div class="row g-3">

          <div class="col-xl-3 col-md-6 col-12">
            <div class="card h-100 text-white shadow-sm border-0 position-relative overflow-hidden"
              style="background-image: linear-gradient(135deg, #141727 0%, #2c3266 100%); min-height: 170px;">
              <div class="card-body d-flex flex-column justify-content-between p-3 z-index-2">
                <div>
                  <h5 class="text-white font-weight-bolder mb-0" id="clock-day">-</h5>
                  <p class="text-xs text-white opacity-8 mb-0" id="clock-date">-</p>
                </div>
                <div class="my-2 text-center">
                  <i class="fas fa-building text-3xl opacity-3 text-white"></i>
                </div>
                <div>
                  <h3 class="text-white font-weight-bolder mb-0" id="clock-time">00:00:00</h3>
                </div>
              </div>
              <span class="mask bg-gradient-dark opacity-1"></span>
            </div>
          </div>

          @foreach($locations as $location)
            <div class="col-xl-3 col-md-6 col-12">
              <div class="card h-100 shadow-sm location-card cursor-pointer" data-id="{{ $location->id }}"
                style="min-height: 170px;">
                <div class="card-body p-3 d-flex flex-column justify-content-between">

                  <div class="d-flex justify-content-between align-items-start">
                    <div>
                      <h6 class="font-weight-bolder text-dark mb-1">{{ $location->location_name }}</h6>
                    </div>
                    <div
                      class="icon icon-shape icon-sm shadow-sm border-radius-md bg-gradient-primary text-center d-flex align-items-center justify-content-center"
                      style="background-image: linear-gradient(310deg, #cb0c9f 0%, #7928ca 100%); width: 32px; height: 32px;">
                      <i class="fas fa-building text-white text-xs"></i>
                    </div>
                  </div>

                  <div class="d-flex gap-3 text-xxs text-secondary font-weight-bold my-2">
                    <span class="d-flex align-items-center gap-1">
                      <img src="{{ asset('assets/img/motorcycle.png') }}" class="img-icon icon-secondary" alt="Max Motor">
                      {{ $location->max_motorcycle }}
                    </span>
                    <span class="d-flex align-items-center gap-1">
                      <img src="{{ asset('assets/img/car.png') }}" class="img-icon icon-secondary" alt="Max Car">
                      {{ $location->max_car }}
                    </span>
                    <span class="d-flex align-items-center gap-1">
                      <img src="{{ asset('assets/img/truck.png') }}" class="img-icon icon-secondary" alt="Max Other">
                      {{ $location->max_other }}
                    </span>
                  </div>

                  <div class="d-flex gap-3 text-xs font-weight-bold pt-2 border-top">
                    @php
                      $slot_motorcycle_ready = $location->max_motorcycle - $location->active_motorcycles;
                      $slot_car_ready = $location->max_car - $location->active_cars;
                      $slot_other_ready = $location->max_other - $location->active_others;
                    @endphp

                    <span
                      class="d-flex align-items-center gap-1 {{ $slot_motorcycle_ready > 0 ? 'text-success' : 'text-danger' }}">
                      <img src="{{ asset('assets/img/motorcycle.png') }}"
                        class="img-icon {{ $slot_motorcycle_ready > 0 ? 'icon-success' : 'icon-danger' }}" alt="Motor">
                      {{ $slot_motorcycle_ready }}
                    </span>

                    <span
                      class="d-flex align-items-center gap-1 {{ $slot_car_ready > 0 ? 'text-success' : 'text-danger' }}">
                      <img src="{{ asset('assets/img/car.png') }}"
                        class="img-icon {{ $slot_car_ready > 0 ? 'icon-success' : 'icon-danger' }}" alt="Car">
                      {{ $slot_car_ready }}
                    </span>

                    <span
                      class="d-flex align-items-center gap-1 {{ $slot_other_ready > 0 ? 'text-success' : 'text-danger' }}">
                      <img src="{{ asset('assets/img/truck.png') }}"
                        class="img-icon {{ $slot_other_ready > 0 ? 'icon-success' : 'icon-danger' }}" alt="Truck">
                      {{ $slot_other_ready }}
                    </span>
                  </div>

                </div>
              </div>
            </div>
          @endforeach

        </div>

        <div class="row mt-4">
          <div class="col-12">
            <div class="card shadow-sm border-0 px-2 py-2">

              <div
                class="card-header pb-0 bg-transparent border-0 pt-3 d-flex justify-content-between align-items-center">
                <h5 class="font-weight-bolder mb-0">
                  <span style="color: #cb0c9f;">Transaction</span>
                  <span class="text-secondary fw-normal ms-1">Input Form</span>
                </h5>
                <button type="button" id="exit-vehicle-btn"
                  class="btn text-white font-weight-bold mb-0 text-uppercase px-3 py-2"
                  style="background-color: #2c3266; border-radius: 0.5rem; font-size: 0.75rem;">
                  + EXIT VEHICLE
                </button>
              </div>

              <div class="card-body pt-3 pb-4 px-3">
                <div class="row g-3">
                  <div class="col-md-6 col-12">
                    <div class="mb-0">
                      <label for="visible_no_tiket" class="form-label text-sm font-weight-bold mb-1">Ticket Number</label>
                      <input type="text" class="form-control" id="visible_no_tiket"
                        placeholder="Enter ticket number (for exit)"
                        style="border-radius: 0.5rem; border: 1px solid #ddd; padding: 0.75rem;">
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="mb-0">
                      <label for="visible_no_polisi" class="form-label text-sm font-weight-bold mb-1">Police
                        Number</label>
                      <input type="text" class="form-control" id="visible_no_polisi"
                        placeholder="Enter license plate (for entry)"
                        style="border-radius: 0.5rem; border: 1px solid #ddd; padding: 0.75rem;">
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>

      <div class="col-lg-3 col-12 mt-lg-0 mt-4">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-header pb-0 bg-transparent border-0 pt-3 d-flex justify-content-between align-items-center">
            <h6 class="font-weight-bolder text-dark mb-0">Active Tickets</h6>
            <button type="button" class="btn btn-link text-xs text-primary font-weight-bold mb-0 p-0"
              data-bs-toggle="modal" data-bs-target="#viewAllModal" style="color: #cb0c9f !important;">
              VIEW ALL
            </button>
          </div>

          <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">
            <div class="d-flex flex-column gap-3">
              @forelse($activeTickets as $ticket)
                <div class="p-3 bg-gray-100 border-radius-lg ticket-item cursor-pointer"
                  data-ticket="{{ $ticket->no_tiket }}" data-plate="{{ $ticket->no_polisi }}"
                  style="border-left: 4px solid #cb0f9f; position: relative;">

                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-xs font-weight-bold text-dark">{{ $ticket->no_polisi }}</span>
                    <span class="text-xxs text-secondary">{{ Carbon\Carbon::parse($ticket->masuk)->format('H:i') }}</span>
                  </div>

                  <div class="d-flex justify-content-between align-items-center mt-2">
                    <span class="text-xxs text-secondary">#{{ $ticket->no_tiket }}</span>
                    <span class="badge bg-gradient-primary text-xxs px-2 py-1"
                      style="background-image: linear-gradient(310deg, #cb0c9f 0%, #7928ca 100%);">
                      {{ $ticket->vehicleType->jenis }}
                    </span>
                  </div>

                  <div class="d-flex justify-content-between align-items-center mt-1">
                    <div class="text-xxs text-secondary">
                      <i class="fas fa-map-marker-alt me-1"></i> {{ $ticket->location->location_name }}
                    </div>

                    <a href="{{ route('transactions.print', $ticket->no_tiket) }}" target="_blank"
                      class="text-xxs text-danger font-weight-bold print-ticket-btn" title="View PDF Ticket">
                      <i class="fas fa-file-pdf me-1"></i>View PDF
                    </a>
                  </div>

                </div>
              @empty
                <div class="text-center py-4">
                  <span class="text-secondary text-xs">No active tickets.</span>
                </div>
              @endforelse
            </div>
          </div>
        </div>
      </div>

    </div>

    <footer class="footer pt-3 mt-4">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-12 mb-lg-0 mb-4 text-center text-lg-start">
            <div class="copyright text-sm text-muted">
              &copy; 2026, made with <i class="fa fa-heart text-danger"></i> by <strong>Bahy Alhady XI SIJA 2</strong> for
              ASAS Ganjil Web And Mobile Development - SMKN 1 Cibinong.
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <form id="entry-form" action="{{ route('transactions.store') }}" method="POST" class="d-none">
    @csrf
    <input type="hidden" name="id_lokasi" id="entry-lokasi-id">
    <input type="hidden" name="id_jenis" id="entry-jenis-id">
    <input type="hidden" name="no_polisi" id="entry-no-polisi">
  </form>

  <form id="exit-form" action="{{ route('transactions.exit') }}" method="POST" class="d-none">
    @csrf
    <input type="hidden" name="no_tiket" id="exit-no-tiket">
  </form>

  <script>
    document.addEventListener("DOMContentLoaded", function () {

      // 1. Real-time Clock Initialization
      function updateClock() {
        const now = new Date();
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        const dayName = days[now.getDay()];
        const dateStr = now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();

        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        document.getElementById('clock-day').textContent = dayName;
        document.getElementById('clock-date').textContent = dateStr;
        document.getElementById('clock-time').textContent = hours + ' : ' + minutes + ' : ' + seconds;
      }
      updateClock();
      setInterval(updateClock, 1000);

      // 2. Selection states
      let selectedLocationId = null;
      let selectedVehicleTypeId = null;

      const locationCards = document.querySelectorAll(".location-card");
      const vtButtons = document.querySelectorAll(".vt-select-btn");

      // Set initial selected values if items exist
      if (locationCards.length > 0) {
        selectLocation(locationCards[0]);
      }
      if (vtButtons.length > 0) {
        selectVehicleType(vtButtons[0]);
      }

      locationCards.forEach(card => {
        card.addEventListener("click", function () {
          selectLocation(this);
        });
      });

      vtButtons.forEach(btn => {
        btn.addEventListener("click", function () {
          selectVehicleType(this);
        });
      });

      // Diubah: Memastikan saat card dipilih secara aktif (diklik), dia mempertahankan style border khusus
      function selectLocation(card) {
        locationCards.forEach(c => {
          c.style.setProperty('border-color', '#ddd', 'important');
          c.style.setProperty('box-shadow', 'none', 'important');
        });
        card.style.setProperty('border-color', '#cb0c9f', 'important');
        card.style.setProperty('box-shadow', '0 0 12px rgba(203, 12, 159, 0.3)', 'important');
        selectedLocationId = card.getAttribute("data-id");
        document.getElementById("entry-lokasi-id").value = selectedLocationId;
      }

      function selectVehicleType(btn) {
        vtButtons.forEach(b => {
          b.style.backgroundColor = "transparent";
          b.style.color = "#2c3266";
        });
        btn.style.backgroundColor = "#2c3266";
        btn.style.color = "#fff";
        selectedVehicleTypeId = btn.getAttribute("data-id");
        document.getElementById("entry-jenis-id").value = selectedVehicleTypeId;
      }

      // 3. Ticket list click pre-fills form
      const ticketItems = document.querySelectorAll(".ticket-item");
      ticketItems.forEach(item => {
        item.addEventListener("click", function (e) {
          if (e.target.closest('.print-ticket-btn')) return;

          const ticket = this.getAttribute("data-ticket");
          const plate = this.getAttribute("data-plate");
          document.getElementById("visible_no_tiket").value = ticket;
          document.getElementById("visible_no_polisi").value = plate;
        });
      });

      // 4. Submitting Entry
      document.getElementById("enter-vehicle-btn").addEventListener("click", function () {
        const plateVal = document.getElementById("visible_no_polisi").value.trim();
        if (!plateVal) {
          if (typeof swal === 'function') {
            swal("Error!", "Please fill in the Police Number first.", "error");
          } else {
            alert("Please fill in the Police Number first.");
          }
          return;
        }

        if (!selectedLocationId || !selectedVehicleTypeId) {
          if (typeof swal === 'function') {
            swal("Error!", "Please select location and vehicle type.", "error");
          } else {
            alert("Please select location and vehicle type.");
          }
          return;
        }

        document.getElementById("entry-no-polisi").value = plateVal;
        document.getElementById("entry-form").submit();
      });

      // 5. Submitting Exit
      document.getElementById("exit-vehicle-btn").addEventListener("click", function () {
        const ticketVal = document.getElementById("visible_no_tiket").value.trim();
        if (!ticketVal) {
          if (typeof swal === 'function') {
            swal("Error!", "Please fill in the Ticket Number first.", "error");
          } else {
            alert("Please fill in the Ticket Number first.");
          }
          return;
        }

        document.getElementById("exit-no-tiket").value = ticketVal;
        document.getElementById("exit-form").submit();
      });

    });
  </script>

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

  <div class="modal fade" id="viewAllModal" tabindex="-1" aria-labelledby="viewAllModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content" style="border-radius: 1rem;">
        <div class="modal-header border-0 pt-4 px-4">
          <h5 class="modal-title font-weight-bolder" id="viewAllModalLabel">
            <span style="color: #cb0c9f;">Parking History</span>
            <span class="text-secondary fw-normal ms-1">| All Completed Transactions</span>
          </h5>
          <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"
            style="font-size: 1.2rem; outline: none; box-shadow: none; border: none;">×</button>
        </div>
        <div class="modal-body px-4 pt-0">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No.</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ticket Number</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Police Number</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Location</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Vehicle Type</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time In</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time Out</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Duration
                    (Min)</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Days</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Pay</th>
                </tr>
              </thead>
              <tbody>
                @forelse($allTransactions as $index => $tr)
                  <tr>
                    <td><span class="text-secondary text-xs font-weight-bold">{{ $index + 1 }}.</span></td>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <span class="text-dark text-xs font-weight-bold">#{{ $tr->no_tiket }}</span>
                      </div>
                    </td>
                    <td><span class="text-dark text-xs font-weight-bold">{{ $tr->no_polisi }}</span></td>
                    <td><span class="text-secondary text-xs font-weight-bold">{{ $tr->location->location_name }}</span></td>
                    <td>
                      <span class="badge bg-gradient-secondary text-xxs px-2 py-1">
                        {{ $tr->vehicleType->jenis }}
                      </span>
                    </td>
                    <td><span
                        class="text-secondary text-xs">{{ \Carbon\Carbon::parse($tr->masuk)->format('d/m/Y H:i') }}</span>
                    </td>
                    <td><span
                        class="text-secondary text-xs">{{ \Carbon\Carbon::parse($tr->keluar)->format('d/m/Y H:i') }}</span>
                    </td>
                    <td class="text-center"><span class="text-dark text-xs font-weight-bold">{{ $tr->total_hours }}</span>
                    </td>
                    <td class="text-center"><span class="text-dark text-xs font-weight-bold">{{ $tr->total_days }}</span>
                    </td>
                    <td><span class="text-success text-xs font-weight-bold">Rp
                        {{ number_format($tr->total_pays, 0, ',', '.') }}</span></td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="10" class="text-center py-4">
                      <span class="text-secondary text-xs">No completed transaction history found.</span>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer border-0 px-4 pb-4">
          <button type="button" class="btn btn-sm mb-0 px-4 text-white font-weight-bold"
            style="background-color: #2c3266; border-radius: 0.5rem;" data-bs-dismiss="modal">Close Window</button>
        </div>
      </div>
    </div>
  </div>
@endsection