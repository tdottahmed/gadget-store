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
          <div class="inline-page-menu my-4">
            <ul class="nav nav-pills nav--tab gap-3">
              <li class="nav-item"><a class="nav-link {{ Request::is('admin/report/affiliate') ? 'active' : '' }}"
                   href="{{ route('admin.report.affiliate') }}">{{ translate('Affiliate_Report') }}</a>
              </li>
              <li class="nav-item"><a class="nav-link {{ Request::is('admin/report/affiliate/pending') ? 'active' : '' }}"
                   href="{{ route('admin.report.affiliate.pending') }}">{{ translate('pending') }}</a>
              </li>
              <li class="nav-item"><a
                   class="nav-link {{ Request::is('admin/report/affiliate/approved') ? 'active' : '' }}"
                   href="{{ route('admin.report.affiliate.approved') }}">{{ translate('approved') }}</a>
              </li>

            </ul>
          </div>
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
