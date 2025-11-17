@extends('layouts.admin.app')

@section('title', translate('affiliate_Report'))

@push('css_or_js')
  <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/backend/css/bootstrap-select.min.css') }}">
@endpush

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ translate('affiliate_Report') }}</h3>
          </div>
          <div class="row g-3 mb-4">
            @include('admin-views.affiliate._stats', ['stats' => $stats])
          </div>
          @include('admin-views.affiliate._tabs')
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                @include('admin-views.affiliate.affiliate-list')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endsection
