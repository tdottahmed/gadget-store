<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body p-3">
    <ul class="nav nav-pills flex-wrap gap-2">

      <li class="nav-item">
        <a href="{{ route('admin.report.affiliate') }}"
           class="nav-link fw-semibold {{ Request::is('admin/report/affiliate') ? 'active' : '' }} px-3 py-2">
          <i class="bi bi-list-check me-1"></i>
          {{ translate('all_withdrawal_requests') }}
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.report.affiliate.pending') }}"
           class="nav-link fw-semibold {{ Request::is('admin/report/affiliate/pending') ? 'active' : '' }} px-3 py-2">
          <i class="bi bi-hourglass-split me-1"></i>
          {{ translate('pending') }}
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.report.affiliate.approved') }}"
           class="nav-link fw-semibold {{ Request::is('admin/report/affiliate/approved') ? 'active' : '' }} px-3 py-2">
          <i class="bi bi-check-circle text-success me-1"></i>
          {{ translate('approved') }}
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.report.affiliate.sales') }}"
           class="nav-link fw-semibold {{ Request::is('admin/report/affiliate/sales') ? 'active' : '' }} px-3 py-2">
          <i class="bi bi-graph-up-arrow text-primary me-1"></i>
          {{ translate('affiliate_sales') }}
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.report.affiliate.transaction') }}"
           class="nav-link fw-semibold {{ Request::is('admin/report/affiliate/transaction') ? 'active' : '' }} px-3 py-2">
          <i class="bi bi-cash-stack me-1"></i>
          {{ translate('transactions') }}
        </a>
      </li>

    </ul>
  </div>
</div>
