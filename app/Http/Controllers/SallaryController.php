<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Salary;

use App\transection;

use Illuminate\Support\Facades\Auth;

/**
 * Shows all user with their salary and payment option
 *
 * @param  \Illuminate\Http\Request  $request
 *
 * @return view with user and salary
 */

class SallaryController extends Controller
{
    public function paysallary(Request $request)
    {
        if ($request->isMethod("GET")) {
            $sallary = Salary::whereMonth("created_at", "=", now())->get();
            //  dd($sallary);
            $user = User::where("id", "!=", Auth::user()->id)->where("stage", "=", "1")->get();
            return view("admin.paysalary", ["user" => $user, 'salary' => $sallary]);
        } else {
            return redirect()->back();
        }
    }
    /**
     * Pays indivisual member salary
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return redirect view to paysallary page
     */
    public function paysallaryIn(Request $request, $id)
    {
        if ($request->isMethod("POST")) {
            if ($request->amount == '') {
                return redirect()->back()->with(session()->flash('alert-warning', 'Salary amount could not be empty '));
            } else {
                $transection = transection::create([
                    'user_id' => Auth::user()->id,
                    'amount' => $request->amount,
                    'type' => 0,
                ]);
                $sallary = Salary::create([
                    'user_ID' => $id,
                    'transection_ID' => $transection->id,
                    'amount' => $transection->amount,
                ]);
                return redirect()->back()->with(session()->flash('alert-success', 'Salary record updated for the user '));
            }
        } else {
            return redirect()->back();
        }
    }
    /**
     * Shows all record of the paid sallray
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view salaryrecord
     */
    public function sallaryRecord(Request $request)
    {
        if ($request->isMethod("GET")) {

            $sallary_Record = Salary::join("users", "users.id", "=", "user_ID")
                ->orderBy("salary.created_at", "desc")->get(["users.*", "salary.*"]);
            return view("admin.salaryrecord", ["salary_Record" => $sallary_Record]);
        } else {
            return redirect()->back();
        }
    }
    /**
     * Pays All member fixed salary at once
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return redirect view to paysallary page shows flash message
     */
    public function payallsalary(Request $request)
    {
        if ($request->isMethod("POST")) {
            $user = User::where("id", "!=", Auth::user()->id)->where("stage", "=", "1")->get();
            //  dd($user);
            foreach ($user as $mem) {
                $transection = transection::create([
                    'user_id' => Auth::user()->id,
                    'amount' => $mem->salary,
                    'type' => 0,
                ]);
                $sallary = Salary::create([
                    'user_ID' => $mem->id,
                    'transection_ID' => $transection->id,
                    'amount' => $transection->amount,
                ]);
            }
            return redirect()->back()->with(session()->flash('alert-success', 'Salary record updated for All of the user '));
        } else {
            return redirect()->back();
        }
    }
    /**
     *Indivisual User salary record
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view specifice user salary with ammount and date
     */
    public function salary(Request $request)
    {
        if ($request->isMethod("GET")) {
            $sallary_Record = Salary::where("user_ID", "=", Auth::user()->id)
                ->orderBy("salary.created_at", "desc")->get(["salary.*"]);
            //dd($sallary_Record);
            return view("user.salary", ["salary" => $sallary_Record]);
        }
    }
}
