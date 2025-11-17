@extends('layouts.admin.app')

@section('title', 'Affiliate Withdrawal Report')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{{ translate('all_affiliate_withdrawal_requests') }}</h3>
      </div>
      <div class="card-body">
        {{-- Stats --}}
        @include('admin-views.affiliate._stats', ['stats' => $stats])

        {{-- Tabs --}}
        @include('admin-views.affiliate._tabs')

        {{-- Withdrawal List --}}
        @include('admin-views.affiliate.affiliate-list', ['withdrawals' => $withdrawals])

      </div>
    </div>
  </div>
@endsection
