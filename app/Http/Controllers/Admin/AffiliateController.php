<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateOrder;
use App\Models\AffiliateWithdrawRequest;
use App\Models\WalletTransaction;
use App\Models\WithdrawalMethod;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function index()
    {
        $withdrawals = AffiliateWithdrawRequest::with('user')->latest()->get();

        return view('admin-views.affiliate.index', [
            'withdrawals' => $withdrawals,
            'stats' => $this->stats(),
        ]);
    }

    public function pending()
    {
        $withdrawals = AffiliateWithdrawRequest::where('status', 'pending')->with('user')->latest()->get();

        return view('admin-views.affiliate.index', [
            'withdrawals' => $withdrawals,
            'stats' => $this->stats(),
        ]);
    }

    public function approved()
    {
        $withdrawals = AffiliateWithdrawRequest::where('status', 'approved')->with('user')->latest()->get();

        return view('admin-views.affiliate.index', [
            'withdrawals' => $withdrawals,
            'stats' => $this->stats(),
        ]);
    }

    private function stats()
    {
        return [
            'total' => AffiliateWithdrawRequest::sum('amount'),
            'pending' => AffiliateWithdrawRequest::where('status', 'pending')->count(),
            'approved' => AffiliateWithdrawRequest::where('status', 'approved')->count(),
        ];
    }

    public function approve($id)
    {
        $withdrawal = AffiliateWithdrawRequest::find($id);
        $withdrawal->status = 'approved';
        $withdrawal->save();

        ToastMagic::success('Withdrawal request approved successfully');
        return redirect()->route('admin.report.affiliate.pending');
    }

    public function reject($id)
    {
        $withdrawal = AffiliateWithdrawRequest::find($id);
        $withdrawal->status = 'rejected';
        $withdrawal->save();
        ToastMagic::success('Withdrawal request rejected successfully');
        return redirect()->route('admin.report.affiliate.pending');
    }

    public function transaction()
    {
        $affiliateTransactions = WalletTransaction::where('reference', 'earned_by_referral')->orWhere('reference', 'customer_withdrawal')->latest()->paginate(20);
        return view('admin-views.affiliate.transaction', [
            'affiliateTransactions' => $affiliateTransactions,
            'stats' => $this->stats(),
        ]);
    }

    public function sales()
    {
        $affiliateOrders = AffiliateOrder::with('order', 'reffedByUser', 'customerUser')->latest()->paginate(20);
        return view('admin-views.affiliate.sales', [
            'affiliateOrders' => $affiliateOrders,
            'stats' => $this->stats(),
        ]);
    }
}
