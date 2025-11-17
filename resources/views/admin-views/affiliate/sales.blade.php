@extends('layouts.admin.app')

@section('title', translate('affiliate_sales_report'))

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{{ translate('affiliate_sales_report') }}</h3>
      </div>
      <div class="card-body">
        <div class="row g-3 mb-4">
          @include('admin-views.affiliate._stats', ['stats' => $stats])
        </div>
        @include('admin-views.affiliate._tabs')
        <div class="card">
          <div class="table-responsive">
            <table class="table-hover table-bordered table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Order ID</th>
                  <th>Referred By</th>
                  <th>Customer</th>
                  <th>First Order</th>
                  <th>Bonus Amount</th>
                  <th>Bonus Applied</th>
                  <th>Notified</th>
                  <th>Date</th>
                </tr>
              </thead>

              <tbody>
                @forelse($affiliateOrders as $key => $row)
                  <tr>
                    <td>{{ $loop->first }}</td>

                    <td>
                      <a href="{{ route('admin.orders.details', [$row->order_id]) }}">
                        #{{ $row->order_id }}
                      </a>
                    </td>

                    <td>
                      @if ($row->reffedByUser)
                        {{ $row->reffedByUser->name }} <br>
                        <small>{{ $row->reffedByUser->email }}</small>
                      @else
                        <span class="text-muted">N/A</span>
                      @endif
                    </td>

                    <td>
                      @if ($row->customerUser)
                        {{ $row->customerUser->name }} <br>
                        <small>{{ $row->customerUser->email }}</small>
                      @else
                        <span class="text-muted">N/A</span>
                      @endif
                    </td>

                    <td>
                      @if ($row->first_order)
                        <span class="badge bg-success">Yes</span>
                      @else
                        <span class="badge bg-secondary">No</span>
                      @endif
                    </td>

                    <td>
                      @if ($row->bonus_amount)
                        {{ number_format($row->bonus_amount, 2) }}
                      @else
                        <span class="text-muted">0.00</span>
                      @endif
                    </td>

                    <td>
                      @if ($row->bonus_applied)
                        <span class="badge bg-success">Applied</span>
                      @else
                        <span class="badge bg-warning">Pending</span>
                      @endif
                    </td>

                    <td>
                      @if ($row->notified)
                        <span class="badge bg-success">Sent</span>
                      @else
                        <span class="badge bg-secondary">No</span>
                      @endif
                    </td>

                    <td>{{ $row->created_at->format('d M Y') }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="9" class="text-center">No affiliate orders found</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            {{ $affiliateOrders->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
