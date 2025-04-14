<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BidController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ExpenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeadNoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpertiseController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ProjectNoteController;
use App\Http\Controllers\SalaryRecordController;
use App\Http\Controllers\ClientInvoiceController;
use App\Http\Controllers\IncomeExpenceController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\VendorInvoiceController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\IncomeExpenceCategoryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserPermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', [AuthenticatedSessionController::class, 'create'])->name('login');
// Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('userlogin');

Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('userlogin');

Route::middleware('auth')->group(function () {

    // Route::get('/dashboard', function () {
    //     return view('admin.dashboard');
    // })->name('dashboard');

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('payment_method', PaymentMethodController::class);

    Route::resource('collection', CollectionController::class);
    Route::get('/get-collected-amount', [CollectionController::class, 'getCollectedAmount'])->name('get-amount');


    Route::resource('IEcategory', IncomeExpenceCategoryController::class);

    Route::resource('income', IncomeController::class);
    Route::resource('expence', ExpenceController::class);
    Route::resource('designation', DesignationController::class);
    Route::resource('employee', EmployeeController::class);
    Route::resource('salary', SalaryRecordController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('city', CityController::class);
    Route::resource('state', StateController::class);
    Route::resource('company', CompanyController::class);
    Route::resource('client', ClientController::class);
    Route::resource('vandors', VendorController::class);
    Route::resource('expertise', ExpertiseController::class);
    Route::resource('type', TypeController::class);
    Route::resource('work-order', WorkOrderController::class);
    Route::get('work-order/{id}/print', [WorkOrderController::class, 'print'])->name('work-order.print');
    Route::resource('note', NoteController::class);
    Route::resource('bids', BidController::class);
    Route::resource('clientinvoice', ClientInvoiceController::class);
    Route::resource('vendorinvoice', VendorInvoiceController::class);

    Route::resource('setting', SettingController::class);
    Route::resource('profile', ProfileController::class);
    Route::resource('attendence', AttendenceController::class);
    Route::get('print/attendance', [AttendenceController::class, 'print'])->name('print.attendance');

    Route::post('/check-out', [AttendenceController::class, 'checkOut'])->name('check-out');


    Route::get('bids/create/{id}', [BidController::class, 'createbids'])->name('createbids');

    Route::get('clientinvoice/create/{id}', [ClientInvoiceController::class, 'clientinvoice'])->name('clientinvoice');

    Route::get('vendorinvoice/create/{id}', [VendorInvoiceController::class, 'vendorinvoice'])->name('vendorinvoice');

    Route::get('bids/print/{id}', [BidController::class, 'print'])->name('bids.print');

    Route::get('clientinvoice/print/{id}', [ClientInvoiceController::class, 'print'])->name('clientinvoice.print');

    Route::get('vendorinvoice/print/{id}', [VendorInvoiceController::class, 'Print'])->name('vendorinvoice.print');

    Route::get('/companyview/{id}', [CompanyController::class, 'view'])->name('company.view');



    // ------ salary report ---------
    Route::get('/salary-report', [ReportController::class, 'salaryreport'])->name('salary.report');

    Route::get('getsalaryreport', [ReportController::class, 'GetsalaryReport']);

    // ------ expense report ---------
    Route::get('expense-report', [ReportController::class, 'ExportReport'])->name('expense.report');
    Route::get('getexpensereport', [ReportController::class, 'GetExpenseReport']);


    // ------ Income report ---------
    Route::get('income-report', [ReportController::class, 'IncomeReport'])->name('income.report');
    Route::get('getincomereport', [ReportController::class, 'GetIncomeReport']);

    //work-order Report
    Route::get('workorder-report', [ReportController::class, 'workorder'])->name('workorder');
    Route::get('getworkorderreport', [ReportController::class, 'GetWorkorderReport']);

    //work-order Report
    Route::get('workorderitem-report', [ReportController::class, 'workorderitem'])->name('workorderitem');
    Route::get('getworkorderitemreport', [ReportController::class, 'GetWorkorderitemReport']);

    //daily payment Report
    Route::get('dailypayment-report', [ReportController::class, 'dailypayment'])->name('dailypayment');
    Route::get('getdailypaymentreport', [ReportController::class, 'GetdailypaymentReport']);

    //Client payment Report
    Route::get('clientpayment-report', [ReportController::class, 'clientpayment'])->name('clientpayment');
    Route::get('getclientpaymentreport', [ReportController::class, 'GetclientpaymentReport']);

    //vendor payment Report
    Route::get('vendorpayment-report', [ReportController::class, 'vendorpayment'])->name('vendorpayment');
    Route::get('getvendorpaymentreport', [ReportController::class, 'GetvendorpaymentReport']);

    Route::get('user_role_list', [UserPermissionController::class, 'userRoleLists'])->name('user_role_list');
    Route::get('user_role/{id?}', [UserPermissionController::class, 'userRole'])->name('user-role');
    Route::post('user_role/update', [UserPermissionController::class, 'userRoleUpdate'])->name('user_role.update');

    // Route::get('datatable', [UserPermissionController::class, 'Datatable'])->name('datatable');
    Route::get('user', [UserPermissionController::class, 'User'])->name('user');
    Route::post('user_insert', [UserPermissionController::class, 'UserInsert'])->name('user.insert');
    Route::get('datatable_data', [UserPermissionController::class, 'DatatableData'])->name('datatable.data');
    Route::get('user_edit', [UserPermissionController::class, 'UserEdit'])->name('user.edit');

});


Route::get('createallpermission', [UserPermissionController::class, 'createallpermission']);

require __DIR__ . '/auth.php';
