<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table-hover table-striped table-bordered table align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>User</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Account Details</th>
            <th>Status</th>
            <th>Date</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        {{-- @dd($withdrawals) --}}

        <tbody>
          @forelse($withdrawals as $key => $row)
            <tr>
              <td>{{ $key + 1 }}</td>

              <td>
                <strong>{{ $row->user->name }}</strong><br>
                <span class="text-muted">{{ $row->user->email }}</span>
              </td>

              <td>
                <span class="fw-bold text-success">
                  {{ number_format($row->amount, 2) }} ৳
                </span>
              </td>

              <td>{{ ucfirst($row->method) }}</td>

              <td>
                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                        data-bs-target="#detailsModal{{ $row->id }}">
                  View
                </button>

                <!-- Modal -->
                <div class="modal fade" id="detailsModal{{ $row->id }}">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Account Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <pre class="bg-light small rounded p-3">
{{ json_encode($row->account_details, JSON_PRETTY_PRINT) }}
                        </pre>
                      </div>
                    </div>
                  </div>
                </div>
              </td>

              <td>
                @if ($row->status == 'pending')
                  <span class="badge bg-warning">Pending</span>
                @elseif($row->status == 'approved')
                  <span class="badge bg-success">Approved</span>
                @else
                  <span class="badge bg-danger">Rejected</span>
                @endif
              </td>

              <td>{{ $row->created_at->format('d M, Y') }}</td>

              <td class="text-center">
                @if ($row->status == 'pending')
                  <a href="{{ route('admin.report.affiliate.approve', $row->id) }}"
                     class="btn btn-sm btn-success">Approve</a>

                  <a href="{{ route('admin.report.affiliate.reject', $row->id) }}"
                     class="btn btn-sm btn-danger">Reject</a>
                @else
                  <span class="text-muted">No action</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-muted p-4 text-center">
                No withdrawal requests found
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
