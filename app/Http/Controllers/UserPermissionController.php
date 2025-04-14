<?php

namespace App\Http\Controllers;

use App\Models\PermissionCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;

use Session;

class UserPermissionController extends Controller
{
    // Function for data view page
    public function User()
    {
        $role_permissions = Role::with('permissions')->get();
        return view('admin.user',compact('role_permissions'));
    }

    public function DatatableData()
    {
        $posts      = User::get();
        $this->i    = 1;
        return DataTables::of($posts)
        ->addColumn('id', function ($data) {
            return $this->i++;
        })
        ->addColumn('action', function ($data) {
            $htmlData = '';
            $htmlData .= '<a href="'.route('user-restriction', ['id' => "$data->id"]).'" data-id="'.$data->id.'" class="btn btn-primary btn-sm" title="Permission"><i class="fa fa-lock"></i></a>&nbsp;';
            $htmlData .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="btn btn-info btn-sm tableEdit" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;';
            $htmlData .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="btn btn-danger btn-sm tableDelete" title="Delete"><i class="fa fa-trash"></i></a>';
            return $htmlData;
        })
        ->rawColumns(['action'])
        ->toJson();
    }

    public function UserInsert(Request $request)
    {
        if ($request->has('delete')) {
            $query = User::find($request->delete);
            $query->delete();

            $message = 'User Deleted Successfully!';
        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
            ]);

            $message = 'User Create Successfully!';

            if ($request->has('id')) {
                $query = User::find($request->id);
                $message = 'User Updated Successfully!';

                if (!$query) {
                    return response()->json([
                    'status' => 'error',
                    'message' => 'Not Found, Please Try Again...',
                    ], 422);
                }
            } else {
                $query = new User();
            }


            $query->name  = $request->name;
            $query->email = $request->email;
            $query->type  = $request->user_role;
            if (!empty($request->password)) {
                $query->password = Hash::make($request->password);
            }
            $query->save();
            $query->assignRole($request->user_role);
            // $query->syncRoles($request->user_role);
        }

        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);
    }

    public function UserEdit(Request $request)
    {
        $query = User::find($request->id);
        if (!$query) {
            return response()->json([
            'status' => 'error',
            'message' => 'Not Found, Please Try Again...',
            ], 422);
        }

        return response()->json([
        'status' => 'success',
        'data' => $query,
        ]);
    }

    public function UserRestriction($id)
    {
        $user                   = User::find($id);
        $permissions            = $user->getPermissionNames()->toArray();
        $permissionCategory     = PermissionCategory::orderBy('type')->get();
        $permissionCategorys    = $permissionCategory->groupBy('type');

        return view('admin.user_restictions', compact('permissionCategorys','user','permissions'));
    }

    public function UserRectictionsUpdate(Request $request)
    {
        $user       = User::find($request->id);
        $user->syncPermissions($request->permission);
        Session::put('success','Permission Assign Successfully');
        return redirect('view');
    }

    // Function for add user role
    public function userRoleLists()
    {
        $role_permissions = Role::with('permissions')->get();
        // return $role_permissions;
        return view('admin.user_role_list', compact('role_permissions'));
    }

    public function userRole(Request $request)
    {
        if($request->role){
            $role = Role::findByName($request->role);
            $permissions = $role->getPermissionNames()->toArray();
        }else{
            $role = [];
            $permissions = [];
        }
        $permissionCategory = PermissionCategory::orderBy('type')->get();
        $permissionCategorys = $permissionCategory->groupBy('type');
        return view('admin.user_role', compact('permissionCategorys', 'permissions','role'));
    }

    public function UserRoleUpdate(Request $request)
    {
        // return true;
        $role = Role::where('name', $request->role)->firstOrNew();
        $role ->name = $request->role;
        $role ->save();
        $role->syncPermissions($request->permission);

        Session::put('success','User Role Assign Successfully');

        return redirect()->route('user_role_list');
    }

    public function Language()
    {
        return view('language');
    }

    public function createallpermission()
    {
        $categories = [
            'User Role'         => ['User Role'],
            'Attendance'        => ['Attendance'],
            'Type'              => ['Type'],
            'Company'           => ['Company'],
            'Client'            => ['Client'],
            'Vendor'            => ['Vendor'],
            'Payment Method'    => ['Payment Method'],
            'HRM'               => ['Designation', 'Employee', 'Salary Payment', 'Salary Record'],
            'Work Order'        => ['Work Order', 'Bids', 'Client Invoice', 'Vendor Invoice', 'Comment'],
            'Report'            => ['Salary Report', 'Work Order Report', 'Work Order Item', 'Client Payment', 'Vendor Payment', 'Dashboard', 'Complete Work Order'],
        ];

        foreach ($categories as $category => $subcategories) {
            // Determine permissions to be created
            $permissionsToCreate = $category === 'Report' ? ['view'] : ['view', 'create', 'edit', 'delete'];
            // Create permissions for each subcategory
            foreach ($subcategories as $subcategory) {
                PermissionCategory::firstOrCreate(
                    ['title' => $subcategory, 'name' => $subcategory],
                    ['type' => $category, 'status' => 'Active']
                );

                foreach ($permissionsToCreate as $action) {
                    $permissionName = $action . ' ' . strtolower($subcategory);
                    Permission::firstOrCreate(['name' => $permissionName]);
                }
            }
        }

        // Clear cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        echo 'Successfully created permissions for all categories.';
    }

    // public function Datatable()
    // {
    //     return view('datatable');
    // }

    // public function DatatableData()
    // {
    //     $posts = User::get();
    //     $this->i = 1;
    //     return DataTables::of($posts)
    //     ->addColumn('id', function ($data) {
    //         return $this->i++;
    //     })
    //     ->addColumn('action', function ($data) {
    //         $htmlData = '';
    //         $htmlData .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="btn btn-info btn-sm tableEdit"><i class="fa fa-edit"></i></a>';
    //         $htmlData .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="btn btn-danger btn-sm tableDelete"><i class="fa fa-trash"></i></a>';
    //         return $htmlData;
    //     })
    //     ->rawColumns(['action'])
    //     ->toJson();
    // }

}
