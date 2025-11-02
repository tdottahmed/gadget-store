<?php

namespace App\Http\Controllers\Admin\ThirdParty;

use App\Http\Controllers\Controller;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;


class SteadfastCourierController extends Controller
{
    public function index()
    {
        return view('admin-views.third-party.steadfast-courier');
    }

    public function update(Request $request)
    {
        $request->validate([
            'STEADFAST_BASE_URL' => 'required|url',
            'STEADFAST_API_KEY' => 'required|string',
            'STEADFAST_SECRET_KEY' => 'required|string',
            'STEADFAST_BEARER_TOKEN' => 'required|string',
        ]);
        try {
            // Update .env variables
            $envUpdates = [
                'STEADFAST_BASE_URL' => $request->input('STEADFAST_BASE_URL'),
                'STEADFAST_API_KEY' => $request->input('STEADFAST_API_KEY'),
                'STEADFAST_SECRET_KEY' => $request->input('STEADFAST_SECRET_KEY'),
                'STEADFAST_BEARER_TOKEN' => $request->input('STEADFAST_BEARER_TOKEN'),
            ];
            foreach ($envUpdates as $key => $value) {
                \App\Utils\Helpers::setEnvironmentValue($key, $value);
            }
            Artisan::call('config:clear');
            ToastMagic::success('Steadfast Courier credentials updated successfully.');
            return back();
        } catch (\Exception $e) {
            ToastMagic::error('Steadfast Courier credentials update failed.');
        }
    }
}
