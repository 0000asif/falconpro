<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AttendenceController extends Controller
{
    public function index()
    {

        $companyId = getuser();
        $query = Attendence::with(['user', 'employee']);
            if($companyId){
                $query->whereHas('employee', function($q) use ($companyId) {
                    $q->where('company_id', $companyId);
                });
            }
        $attendences = $query->orderBy('check_in', 'desc')
            ->get();


        return view('attendence.index', compact('attendences'));
    }

    public function create()
    {
        $todayAttendance = Attendence::where('user_id', Auth::id())
            ->whereDate('check_in', now()->toDateString())
            ->first();
        return view('attendence.create', compact('todayAttendance'));
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $existingAttendance = Attendence::where('user_id', Auth::id())
                ->whereDate('check_in', now()->toDateString())
                ->first();

            if ($existingAttendance) {
                return back()->with('failed', 'You have already checked in today.');
            }

            $attendence = Attendence::create([
                'user_id' => Auth::id(),
                'check_in' => now(),
                'check_in_ip' => request()->ip(),
                'status' => '1',
            ]);

            $user = User::where('id', $attendence->user_id)->first();

            $user->attendance_status = '1'; // 1 for checked in
            $user->updated_at = now();
            $user->save();

            DB::commit();
            return back()->with('success', 'Checked in successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while checking in.' . $e->getMessage());
        }
    }

    public function checkOut(Request $request)
    {
        try {
            DB::beginTransaction();
            $attendance = Attendence::where('user_id', Auth::id())
                ->whereDate('check_in', now()->toDateString())
                ->whereNull('check_out')
                ->first();

            if (!$attendance) {
                return back()->with('failed', 'You need to check in first.');
            }

            $attendance->update([
                'check_out' => now(),
                'check_out_ip' => request()->ip(),
                'status' => '2',
            ]);

            $user = User::where('id', $attendance->user_id)->first();

            $user->attendance_status = '2'; // 2 for checked out
            $user->updated_at = now();
            $user->save();


            DB::commit();
            return back()->with('success', 'Checked out successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'An error occurred while checking out.' . $e->getMessage());
        }
    }

    public function print()
    {
        $attendences = Attendence::with(['user', 'employee'])
            ->orderBy('check_in', 'desc')
            ->get();
        return view('attendence.print', compact('attendences'));
    }
}
