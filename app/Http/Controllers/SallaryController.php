<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Salary;

use App\transection;

use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

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
            $total = $user->count();
            $counter = 0;
            //  dd($user);
            if ($user->count() == 0) {
                return redirect()->back()->with(session()->flash('alert-warning', 'No user added to the Sytem'));
            } else {
                foreach ($user as $mem) {
                    $sallary = Salary::where("user_ID", "=", $mem->id)->whereMonth("created_at", "=", now())->sum("amount");
                    if ($sallary == $mem->salary) {
                        $counter++;
                    } else {
                        if ($counter == $total) {
                            break;
                        } else {
                            $transection = transection::create([
                                'user_id' => Auth::user()->id,
                                'amount' => $mem->salary - $sallary,
                                'type' => 0,
                            ]);
                            $sallary = Salary::create([
                                'user_ID' => $mem->id,
                                'transection_ID' => $transection->id,
                                'amount' => $transection->amount,
                            ]);
                        }
                    }
                }
            }

            if ($counter != $total) {
                return redirect()->back()->with(session()->flash('alert-success', 'Salary record updated for All of the user '));
            } else {
                return redirect()->back()->with(session()->flash('alert-warning', 'All member is already paid for this month'));
            }
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
        } else {
            return redirect()->back();
        }
    }
    /**
     *UPDATE : indiviual salary record
     *
     * @param  \Illuminate\Http\Request $request @param App\Salary $id
     *
     * @return redirect with a flash message
     */
    public function updateSallaryRecord($id, Request $request)
    {
        if ($request != null) {

            if ($request->salary_amount != '') {
                $salary = Salary::find($id);
                $transection = transection::where("id", "=", $salary->transection_ID)->update(["amount" => $request->salary_amount]);
                $salary = $salary->update(["amount" => $request->salary_amount]);
            }
            return redirect()->back()->with(session()->flash('alert-success', 'Amount Updated'));
        } else {
            return redirect()->back();
        }
    }
    /**
     *DELETE Indivisual User salary record
     *
     * @param  \Illuminate\Http\Request  $request && @param App\Salary $transaction_id
     *
     * @return   redirect with a flash message
     */
    public function deleteSallaryRecord($id, Request $request)
    {
        if ($request->isMethod("POST")) {
            $transection = transection::find($id);
            if ($transection != null) {
                $transection->delete();
                return redirect()->back()->with(session()->flash('alert-success', 'Salary record deleted'));
            } else {
                return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong'));
            }
        } else {
            return redirect()->back();
        }
    }
}
