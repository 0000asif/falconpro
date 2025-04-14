<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\Company;
use App\Models\Project;
use App\Models\Employee;
use App\Models\WorkOrder;
use App\Models\SalaryRecord;
use Illuminate\Http\Request;
use App\Models\IncomeExpence;
use App\Models\WorkOrderItem;
use Illuminate\Support\Carbon;
use App\Models\IncomeExpenceCategory;

class ReportController extends Controller
{
    // -------------- expense controller -------------
    public function ExportReport()
    {
        $staffs = Project::get();
        $category = IncomeExpenceCategory::get();
        return view('reports.expense-report', compact('staffs', 'category'));
    }
    public function GetExpenseReport(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $staff_id = $request->staff_id;
        $category_id = $request->category_id;

        $query = IncomeExpence::wherebetween('date', [$from_date, $to_date])->where('type', 2);

        if ($staff_id) {
            $query->where('project_id', $staff_id);
        }
        if ($category_id) {
            $query->where('income_expence_category_id', $category_id);
        }
        $expense_report = $query->get();
        return view('reports.view-expense', compact('staff_id', 'expense_report', 'from_date', 'to_date', 'category_id'));
    }

    // -------------- Income controller -------------
    public function IncomeReport()
    {
        $staffs = Project::get();
        $category = IncomeExpenceCategory::get();
        return view('reports.income-report', compact('staffs', 'category'));
    }
    public function GetIncomeReport(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $staff_id = $request->staff_id;
        $category_id = $request->category_id;

        $query = IncomeExpence::wherebetween('date', [$from_date, $to_date])->where('type', 1);

        if ($staff_id) {
            $query->where('project_id', $staff_id);
        }
        if ($category_id) {
            $query->where('income_expence_category_id', $category_id);
        }
        $expense_report = $query->get();
        return view('reports.view-income', compact('staff_id', 'expense_report', 'from_date', 'to_date', 'category_id'));
    }
    // -------------- Salary controller -------------
    public function SalaryReport()
    {
        $staffs = Employee::get();

        return view('reports.salaryrecord', compact('staffs'));
    }

    public function GetsalaryReport(Request $request)
    {

        $from_date = Carbon::createFromFormat('m-d-Y', $request->from_date)->startOfDay();
        $to_date = Carbon::createFromFormat('m-d-Y', $request->to_date)->endOfDay();
        $staff_data = $request->staff_data;

        $query = SalaryRecord::with('staff')->whereBetween('payment_date', [$from_date, $to_date]);

        if ($staff_data) {
            $query->where('employee_id', $staff_data);
        }
        $salary_report = $query->get();
        return view('reports.view-salary-report', compact('salary_report', 'from_date', 'to_date', 'staff_data'));
    }




    //WorkOrder Report
    public function workorder()
    {
        return view('reports.workorder');
    }

    public function GetWorkorderReport(Request $request)
    {
        $from_date = Carbon::createFromFormat('m-d-Y', $request->from_date)->startOfDay();
        $to_date = Carbon::createFromFormat('m-d-Y', $request->to_date)->endOfDay();

        $query = WorkOrder::whereBetween('created_at', [$from_date, $to_date]);

        $workorder_report = $query->get();
        // dd($workorder_report, $from_date, $to_date);
        return view('reports.view-workorder', compact('from_date', 'to_date', 'workorder_report'));
    }

    //WorkOrder Item Report
    public function workorderitem()
    {
        $orders = WorkOrder::all();
        return view('reports.workorderitem', compact('orders'));
    }
    public function GetWorkorderitemReport(Request $request)
    {
        $from_date = Carbon::createFromFormat('m-d-Y', $request->from_date)->startOfDay();
        $to_date = Carbon::createFromFormat('m-d-Y', $request->to_date)->endOfDay();
        $work_order = $request->work_order;

        $query = WorkOrderItem::whereBetween('created_at', [$from_date, $to_date]);
        if ($work_order) {
            $query->where('work_order_id', $work_order);
        }
        $workorder_report = $query->get();
        // dd($workorder_report, $from_date, $to_date);
        return view('reports.view-workorderitem', compact('from_date', 'to_date', 'workorder_report'));
    }

    //daily Payment Report
    public function dailypayment()
    {
        $orders = WorkOrder::all();
        return view('reports.dailypayment', compact('orders'));
    }

    public function GetdailypaymentReport(Request $request)
    {
        $from_date = Carbon::createFromFormat('m-d-Y', $request->from_date)->startOfDay();
        $to_date = Carbon::createFromFormat('m-d-Y', $request->to_date)->endOfDay();
        $work_order = $request->work_order;

        $query = WorkOrder::with('bids', 'vendorinvoice', 'clientinvoice')->whereBetween('created_at', [$from_date, $to_date]);
        if ($work_order) {
            $query->where('id', $work_order);
        }
        $workorder_report = $query->get();
        // dd($workorder_report, $from_date, $to_date);
        return view('reports.view-dailypayment', compact('from_date', 'to_date', 'workorder_report'));
    }

    //Client Payment Report
    public function clientpayment()
    {
        $companies = Company::all();
        $orders = WorkOrder::all();
        return view(
            'reports.clientpayment',
            compact('orders', 'companies')
        );
    }

    public function GetclientpaymentReport(Request $request)
    {
        // Parse date inputs
        $from_date = Carbon::createFromFormat('m-d-Y', $request->from_date)->startOfDay();
        $to_date = Carbon::createFromFormat('m-d-Y', $request->to_date)->endOfDay();
        $workorder = $request->work_order;
        $company_id = $request->company_id;

        $query = WorkOrder::with(['clientinvoice' => function ($q) {
            $q->select('work_order_id', 'total_amount');
        }]);

        $query->whereBetween('created_at', [$from_date, $to_date]);

        if ($company_id) {
            $query->where('company_id', $company_id);
        }

        if ($workorder) {
            $query->where('id', $workorder);
        }

        $workorder_report = $query->get();

        return view('reports.view-clientpayment', compact('from_date', 'to_date', 'workorder_report'));
    }

    //vendor Payment Report
    public function vendorpayment()
    {
        $companies = Company::all();
        $orders = WorkOrder::all();
        return view('reports.vendorpayment', compact('orders', 'companies'));
    }

    public function GetvendorpaymentReport(Request $request)
    {
        // Parse date inputs
        $from_date = Carbon::createFromFormat('m-d-Y', $request->from_date)->startOfDay();
        $to_date = Carbon::createFromFormat('m-d-Y', $request->to_date)->endOfDay();
        $workorder = $request->work_order;
        $company_id = $request->company_id;

        $query = WorkOrder::with(['vendorinvoice' => function ($q) {
            $q->select('work_order_id', 'total_amount');
        }]);

        $query->whereBetween('created_at', [$from_date, $to_date]);

        if ($company_id) {
            $query->where('company_id', $company_id);
        }

        if ($workorder) {
            $query->where('id', $workorder);
        }

        $workorder_report = $query->get();

        return view('reports.view-vendorpayment', compact('from_date', 'to_date', 'workorder_report'));
    }
}
