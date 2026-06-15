<div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
  <ul class="navbar-nav">
    <!-- Location -->
    <li class="nav-item">
      <a class="nav-link @if ($title == 'Location' || $title == 'Add Location' || $title == 'Edit Location') active @endif"
        href="{{ route('locations.index') }}">
        <div
          class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
          <i
            class="ni ni-pin-3 text-xs @if($title == 'Location' || $title == 'Add Location' || $title == 'Edit Location') text-white @else text-dark @endif"></i>
        </div>
        <span class="nav-link-text ms-1">Location</span>
      </a>
    </li>

    <!-- Transaction -->
    <li class="nav-item">
      <a class="nav-link @if ($title == 'Transaction') active @endif" href="{{ route('transactions.index') }}">
        <div
          class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
          <i class="ni ni-credit-card text-xs @if($title == 'Transaction') text-white @else text-dark @endif"></i>
        </div>
        <span class="nav-link-text ms-1">Transaction</span>
      </a>
    </li>

    <!-- Vehicle Type -->
    <li class="nav-item">
      <a class="nav-link @if ($title == 'Vehicle Type') active @endif" href="{{ route('vehicletypes.index') }}">
        <div
          class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
          <i class="ni ni-spaceship text-xs @if($title == 'Vehicle Type') text-white @else text-dark @endif"></i>
        </div>
        <span class="nav-link-text ms-1">Vehicle Type</span>
      </a>
    </li>

    <!-- Section Header: Reports -->
    <li class="nav-item mt-3">
      <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">REPORTS</h6>
    </li>

    <!-- Location Report -->
    <li class="nav-item">
      <a class="nav-link @if ($title == 'Location Report') active @endif" href="#">
        <div
          class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
          <i class="ni ni-paper-diploma text-xs @if($title == 'Location Report') text-white @else text-dark @endif"></i>
        </div>
        <span class="nav-link-text ms-1">Location Report</span>
      </a>
    </li>

    <!-- Transaction Report -->
    <li class="nav-item">
      <a class="nav-link @if ($title == 'Transaction Report') active @endif" href="#">
        <div
          class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
          <i
            class="ni ni-chart-pie-35 text-xs @if($title == 'Transaction Report') text-white @else text-dark @endif"></i>
        </div>
        <span class="nav-link-text ms-1">Transaction Report</span>
      </a>
    </li>
  </ul>
</div>