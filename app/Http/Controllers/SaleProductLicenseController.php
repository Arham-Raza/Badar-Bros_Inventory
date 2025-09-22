<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleProductLicense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SaleProductLicenseController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'sale_detail_id' => 'required|exists:sales_details,id',
                'license_name' => 'required|string',
                'license_no' => 'required|string',
                'license_issue_date' => 'required|date',
                'issued_by' => 'required|string',
                'cnic_no' => 'required|string',
                'contact_no' => 'required|string',
                'valid_upto' => 'required|date',
                'weapon_type' => 'nullable|string',
                'weapon_no' => 'nullable|string',
                'status' => 'nullable|string',
            ]);

            $validated['created_by'] = Auth::id();
            $license = SaleProductLicense::create($validated);

            Log::info('SaleProductLicense created', ['license_id' => $license->id, 'user_id' => Auth::id()]);

            // Redirect to print view for this license
            return redirect()->route('sale-product-licenses.print', $license->sale_detail_id)->with('success', 'License info saved successfully.');
        } catch (\Throwable $e) {
            Log::error('Error in SaleProductLicenseController@store', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'An error occurred while saving license info.');
        }
    }

      public function print($sale_detail_id)
    {
        try {
            $license = SaleProductLicense::where('sale_detail_id', $sale_detail_id)->first();
            if ($license) {
                Log::info('SaleProductLicense print view accessed', ['license_id' => $license->id]);
                // Render a print view with license data
                return view('sales.license', compact('license'));
            } else {
                Log::warning('SaleProductLicense print attempted but not found', ['sale_detail_id' => $sale_detail_id]);
                // Redirect back with instruction to open modal (handled in JS)
                return redirect()->back()->with('open_license_modal', $sale_detail_id);
            }
        } catch (\Throwable $e) {
            Log::error('Error in SaleProductLicenseController@print', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'An error occurred while loading license print view.');
        }
    }
}
