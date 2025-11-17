@extends('layouts.admin.app')

@section('title', translate('affiliate_transaction_report'))

@push('css_or_js')
  <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/backend/css/bootstrap-select.min.css') }}">
@endpush
@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ translate('affiliate_transaction_report') }}</h3>
          </div>
          <div class="row g-3">
            @include('admin-views.affiliate._stats', ['stats' => $stats])
          </div>
          @include('admin-views.affiliate._tabs')
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table-hover table-striped table-bordered table align-middle">
                        <thead>
                          <tr>
                            <th>{{ translate('SL') }}</th>
                            <th>{{ translate('User') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th>{{ translate('Reference') }}</th>
                            <th>{{ translate('Created At') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($affiliateTransactions as $key => $transaction)
                            <tr>
                              <td>{{ $key + 1 }}</td>
                              <td>
                                @if ($transaction->user)
                                  {{ $transaction->user->name }}
                                @else
                                  {{ translate('User not found') }}
                                @endif
                              </td>
                              <td>
                                @if ($transaction->credit > 0)
                                  <span class="fw-bold text-success">+{{ number_format($transaction->credit, 2) }}
                                    ৳</span>
                                @else
                                  <span class="fw-bold text-danger">-{{ number_format($transaction->debit, 2) }} ৳
                                  </span>
                                @endif
                              </td>
                              <td>{{ $transaction->reference }}</td>
                              <td>{{ date('d M Y', strtotime($transaction->created_at)) }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <div class="d-flex justify-content-end">
                        {!! $affiliateTransactions->links() !!}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endsection
