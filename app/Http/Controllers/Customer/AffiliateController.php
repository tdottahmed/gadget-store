<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function accountSetup()
    {
        
        return view('themes.default.customer-views.affiliate.account-setup');
    }
}
