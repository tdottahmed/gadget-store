@extends('layouts.admin.app')

@section('title', translate(''))

@section('content')
  <div class="content container-fluid">
    <div class="mb-sm-20 mb-3">
      <h2 class="h1 text-capitalize d-flex align-items-center mb-0 gap-2">
        {{ translate('3rd_Party') }} - {{ translate('Steadfast Courier') }}
      </h2>
    </div>
    @include('admin-views.third-party._third-party-others-menu')
    <div class="card mb-4 border-0 shadow-sm">
      <div class="card-header bg-light d-flex justify-content-between align-items-center border-0">
        <div>
          <h4 class="mb-0">{{ translate('Steadfast Courier Integration') }}</h4>
          <small class="text-muted">
            {{ translate('Configure your Steadfast Courier API credentials to enable automatic order delivery management.') }}
          </small>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.third-party.steadfast-courier.update') }}" method="POST">
          @csrf
          <div class="row g-4">
            <!-- Base URL -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold">
                  {{ translate('Steadfast Base URL') }}
                  <i class="fi fi-sr-info text-muted ms-1" data-bs-toggle="tooltip"
                     title="Enter the API endpoint provided by Steadfast Courier."></i>
                </label>
                <input type="text" class="form-control" name="STEADFAST_BASE_URL"
                       value="{{ env('STEADFAST_BASE_URL') }}" placeholder="https://portal.packzy.com/api/v1">
              </div>
            </div>

            <!-- API Key -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold">
                  {{ translate('API Key') }}
                  <i class="fi fi-sr-info text-muted ms-1" data-bs-toggle="tooltip"
                     title="Your unique API key for authentication."></i>
                </label>
                <input type="text" class="form-control" name="STEADFAST_API_KEY" value="{{ env('STEADFAST_API_KEY') }}"
                       placeholder="Enter your API key">
              </div>
            </div>

            <!-- Secret Key -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold">
                  {{ translate('Secret Key') }}
                  <i class="fi fi-sr-info text-muted ms-1" data-bs-toggle="tooltip"
                     title="The secret key provided by Steadfast for secure communication."></i>
                </label>
                <input type="text" class="form-control" name="STEADFAST_SECRET_KEY"
                       value="{{ env('STEADFAST_SECRET_KEY') }}" placeholder="Enter your secret key">
              </div>
            </div>

            <!-- Bearer Token -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold">
                  {{ translate('Bearer Token') }}
                  <i class="fi fi-sr-info text-muted ms-1" data-bs-toggle="tooltip"
                     title="Bearer token used for authorization with the Steadfast API."></i>
                </label>
                <input type="text" class="form-control" name="STEADFAST_BEARER_TOKEN"
                       value="{{ env('STEADFAST_BEARER_TOKEN') }}" placeholder="Enter your bearer token">
              </div>
            </div>

            <!-- Submit Button -->
            <div class="col-12 text-end">
              <button type="submit" class="btn btn-primary px-4">
                <i class="fi fi-br-check me-1"></i>
                {{ translate('Save Settings') }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
@endsection

@push('script')
  <script></script>
@endpush
