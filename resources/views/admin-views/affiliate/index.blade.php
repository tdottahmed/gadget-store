@extends('layouts.admin.app')

@section('title', 'Affiliate Withdrawal Report')

@section('content')
  <div class="container-fluid">

    {{-- Stats --}}
    @include('admin-views.affiliate._stats', ['stats' => $stats])

    {{-- Tabs --}}
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-body py-2">
        <ul class="nav nav-pills gap-3">
          <li class="nav-item">
            <a href="{{ route('admin.report.affiliate') }}"
               class="nav-link {{ Request::is('admin/report/affiliate') ? 'active' : '' }}">
              {{ translate('all_withdrawal_requests') }}
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.report.affiliate.pending') }}"
               class="nav-link {{ Request::is('admin/report/affiliate/pending') ? 'active' : '' }}">
              {{ translate('pending') }}
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.report.affiliate.approved') }}"
               class="nav-link {{ Request::is('admin/report/affiliate/approved') ? 'active' : '' }}">
              {{ translate('approved') }}
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.report.affiliate.transaction') }}"
               class="nav-link {{ Request::is('admin/report/affiliate/transaction') ? 'active' : '' }}">
              {{ translate('transactions') }}
            </a>
          </li>
        </ul>
      </div>
    </div>

    {{-- Withdrawal List --}}
    @include('admin-views.affiliate.affiliate-list', ['withdrawals' => $withdrawals])

  </div>
@endsection
