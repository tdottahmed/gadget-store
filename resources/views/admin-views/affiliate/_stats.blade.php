<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center">
        <h5 class="text-muted">Total Withdrawals</h5>
        <h2 class="fw-bold text-primary">{{ number_format($stats['total'], 2) }} ৳</h2>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center">
        <h5 class="text-muted">Pending Requests</h5>
        <h2 class="fw-bold text-warning">{{ $stats['pending'] }}</h2>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center">
        <h5 class="text-muted">Approved Requests</h5>
        <h2 class="fw-bold text-success">{{ $stats['approved'] }}</h2>
      </div>
    </div>
  </div>
</div>
