<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Vendor;
use App\Models\Company;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use App\Models\ClientInvoice;
use App\Models\VendorInvoice;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $companyId = getuser();
        if($companyId){
            $companyId = $companyId;
        }else{
            $companyId = $request->get('company_id');
        }

        if (!$companyId) {
            // Calculate global data only when no filter is applied
            $totalWorkOrder = WorkOrder::count();
            $totalVendor = Vendor::count();
            $totalClient = Client::count();
            $completeorders = WorkOrder::where('status_id', '7')->get();
            $totalClientPayment = ClientInvoice::sum('total_amount');
            $totalVendorPayment = VendorInvoice::sum('total_amount');
            $totalWOrkorderAmount = WorkOrder::sum('grand_total');
            $totalProfit = $totalClientPayment - $totalVendorPayment;
        } else {
            // Set global data variables to null or empty
            $totalWorkOrder = null;
            $totalVendor = null;
            $totalClient = null;
            $completeorders = collect(); // Empty collection
            $totalClientPayment = null;
            $totalVendorPayment = null;
            $totalWOrkorderAmount = null;
            $totalProfit = null;
        }

        if($companyId){
            $companies = Company::where('id', $companyId)->get();
        }else{
            $companies = Company::get();
        }

        $companyStats = collect(); // Default to an empty collection
        $workOrdersByCompany = collect(); // Default to an empty collection

        if ($companyId) {
            $companyStats = Company::with(['workOrders.clientInvoice', 'workOrders.vendorInvoice', 'vendors', 'clients'])
                ->when($companyId, function ($query) use ($companyId) {
                    $query->where('id', $companyId); // Fetch the selected company only when $companyId is provided
                })
                ->get()
                ->map(function ($company) {
                    return [
                        'company' => $company->name,
                        'total_work_orders' => $company->workOrders->count(),
                        'total_work_order_amount' => $company->workOrders->sum('grand_total'),
                        'total_vendors' => $company->vendors->count(),
                        'total_clients' => $company->clients->count(),
                        'total_client_payments' => $company->workOrders->flatMap(function ($workOrder) {
                            return $workOrder->clientInvoice;
                        })->sum('total_amount'),
                        'total_vendor_payments' => $company->workOrders->flatMap(function ($workOrder) {
                            return $workOrder->vendorInvoice;
                        })->sum('total_amount'),
                        'total_profit' => $company->workOrders->sum('profit'),
                    ];
                });


            $workOrdersByCompany = WorkOrder::where('company_id', $companyId) // Filter work orders
                ->get()
                ->groupBy('company.name');
        }


        return view('admin.dashboard', compact('companies', 'companyId', 'companyStats', 'workOrdersByCompany', 'totalWorkOrder', 'totalVendor', 'totalClient', 'completeorders', 'totalClientPayment', 'totalVendorPayment', 'totalWOrkorderAmount', 'totalProfit'));
    }
}
