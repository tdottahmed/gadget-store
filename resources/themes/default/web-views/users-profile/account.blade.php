@extends('layouts.front-end.app')

@section('title', auth('customer')->user()->f_name . ' ' . auth('customer')->user()->l_name)

@push('css_or_js')
  <link rel="stylesheet"
        href="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/css/intlTelInput.css') }}">
@endpush

@section('content')
  <div class="py-md-4 p-md-2 user-profile-container px-5px container p-0 py-2">
    <div class="row">
      @include('web-views.partials._profile-aside')
      <section class="col-lg-9 __customer-profile px-0">
        <div class="card">
          <div class="card-header">
            <h5 class="fs-16 m-0 font-bold">{{ translate('Affiliate Withdrawal Account Setup') }}</h5>
          </div>
          <div class="card-body">
            <div class="card-inner">
              <form class="px-sm-2 mt-3 pb-2" action="{{ route('affiliate.account-setup.update') }}" method="post"
                    enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                  {{-- Withdrawal Method --}}
                  <div class="col-md-6">
                    <label class="form-label">{{ translate('Withdrawal Method') }}</label>
                    <select name="withdraw_method" class="form-control selectpicker" required>
                      <option value="bkash" {{ $withdrawMethod == 'bkash' ? 'selected' : '' }}>Bkash</option>
                      <option value="nagad" {{ $withdrawMethod == 'nagad' ? 'selected' : '' }}>Nagad</option>
                      <option value="rocket" {{ $withdrawMethod == 'rocket' ? 'selected' : '' }}>Rocket</option>
                      <option value="bank" {{ $withdrawMethod == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                    </select>
                  </div>

                  {{-- Full Name --}}
                  <div class="col-md-6">
                    <label class="form-label">{{ translate('Full Name') }}</label>
                    <input type="text" name="full_name" class="form-control" placeholder="Enter your full name"
                           value="{{ $fullName }}" required>
                  </div>

                  {{-- Phone --}}
                  <div class="col-md-6">
                    <label class="form-label">{{ translate('Phone Number') }}</label>
                    <input type="text" name="phone" class="form-control" id="withdraw-phone"
                           placeholder="01XXXXXXXXX" value="{{ $phone }}" required>
                  </div>

                  {{-- Bank Account Fields --}}
                  <div class="col-md-6 bank-fields d-none">
                    <label class="form-label">{{ translate('Bank Name') }}</label>
                    <input type="text" class="form-control" name="bank_name" placeholder="Bank Name"
                           value="{{ $bankName }}">
                  </div>

                  <div class="col-md-6 bank-fields d-none">
                    <label class="form-label">{{ translate('Account Number') }}</label>
                    <input type="text" class="form-control" name="bank_account_no" placeholder="Account Number"
                           value="{{ $bankAccountNo }}">
                  </div>

                  <div class="col-md-6 bank-fields d-none">
                    <label class="form-label">{{ translate('Branch Name') }}</label>
                    <input type="text" class="form-control" name="bank_branch" placeholder="Branch Name"
                           value="{{ $bankBranch }}">
                  </div>

                  {{-- Mobile Wallet Number --}}
                  <div class="col-md-6 mobile-wallet">
                    <label class="form-label">{{ translate('Wallet Number') }}</label>
                    <input type="text" class="form-control" name="wallet_number"
                           placeholder="Bkash/Nagad/Rocket Number" value="{{ $walletNumber }}">
                  </div>
                </div>

                {{-- Desktop Submit --}}
                <div class="d-none d-md-block mt-4">
                  <button type="submit" class="btn btn--primary">{{ translate('Update') }}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>

  <div class="bottom-sticky_offset"></div>
  <div class="bottom-sticky_ele d-md-none bg-white p-3">
    <button type="submit" class="btn btn--primary w-100 update-account-info">
      {{ translate('update') }}
    </button>
  </div>

@endsection
@push('script')
  <script>
    document.querySelector('select[name="withdraw_method"]').addEventListener('change', function() {
      let method = this.value;
      let bankFields = document.querySelectorAll('.bank-fields');
      let mobileWallet = document.querySelector('.mobile-wallet');

      if (method === 'bank') {
        bankFields.forEach(f => f.classList.remove('d-none'));
        mobileWallet.classList.add('d-none');
      } else {
        bankFields.forEach(f => f.classList.add('d-none'));
        mobileWallet.classList.remove('d-none');
      }
    });
  </script>
@endpush
