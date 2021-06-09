<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\transection;

use App\User;

use App\Expense;

use App\Gain;

use App\notification;

use Illuminate\Support\Facades\Auth;


class transectionController extends Controller
{

    /**
     * GET: Show add amount page && POST : Add ammount to gain and trasection table
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view  add ammount with ammount histroy
     */

    public function addamount(Request $request)
    {
        if ($request->isMethod("GET")) {
            $Gain = Gain::where("user_id", "=", Auth::user()->id)
                ->orderBy("created_at", "desc")
                ->get(['id', 'created_at', 'amount', 'gain_details', 'transection_id']);
            //dd($Gain);
            return view("admin.addamount", ['Gain' => $Gain]);
        } elseif ($request->isMethod("POST")) {
            $addamount = transection::create([
                'user_id' => Auth::user()->id,
                'amount' => $request->amount,
                'type' => 1,
            ]);

            $addgain = Gain::create([
                'user_id' => Auth::user()->id,
                'transection_ID' => $addamount->id,
                'amount' => $request->amount,
                'gain_details' => $request->description,
            ]);
            $notification = notification::create([
                'user_ID' => $addamount->user_id,
                'transection_ID' => $addamount->id,
                'expense_ID' => null,
                'notification' => "Fund Added:",
                'type' => 1,

            ]);

            return redirect()->back()->with(session()->flash('alert-success', 'Amount added to this system'));
        }
    }
    /**
     *Update indiviusal gain record form transection Table and Gain table
     *
     * @param  \Illuminate\Http\Request  $request @param App\Gain $id
     *
     * @return view Addamount @return redirect with flash message
     */

    public function updategaininfo($id, Request $request)
    {
        if ($request->isMethod("POST")) {
            if ($request != null) {
                if ($request->gain_description != '') {
                    $gain = Gain::where("id", "=", $id)->update(["gain_details" => $request->gain_description]);
                }
                if ($request->gain_amount != '') {
                    $gain = Gain::find($id);
                    $transection = transection::where("id", "=", $gain->transection_ID)->update(["amount" => $request->gain_amount]);
                    $gain = $gain->update(["amount" => $request->gain_amount]);
                }
                return redirect()->back()->with(session()->flash('alert-success', 'Amount Upgraded'));
            }
        } else {
            return redirect()->back()->with(session()->flash('alert-warning', 'Something Went Wrong'));
        }
    }
    /**
     *DELETE indiviusal gain record form transection Table and Gain table
     *
     * @param  \Illuminate\Http\Request  $Request && @param App\transection $id
     *
     * @return view Addamount || @return redirect with flash message
     */
    public function deletegaininfo($id, Request $request)
    {
        if ($request->isMethod("POST")) {
            $transection = transection::find($id);
            $transection->delete();
            return redirect()->back()->with(session()->flash('alert-success', 'Amount record Deleted'));
        } else {
            return redirect()->back();
        }
    }
    /**
     *GET: Shows (Admin) office expense && POST: Add office expence and add in the transection table & expense table
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view office expense  ||  @return redirect with flash message
     */
    public function officeexpense(Request $request)
    {
        if ($request->isMethod(("GET"))) {
            $myexpense = Expense::where("user_id", "=", Auth::user()->id)
                ->where("type", "=", "office")
                ->orderBy("expense.created_at", "desc")->get(["*"]);
            $allexpense = Expense::where("type", "=", "office")
                ->join("users", "users.id", "=", "expense.user_ID")
                ->orderBy("expense.created_at", "desc")->get(["users.name", "users.designation", "users.department", "expense.*"]);
            //dd($allexpense);
            $users = User::get(["users.name"]);
            // dd($users);
            return view("admin.officeExpense", ['users' => $users, "myexpense" => $myexpense, "allexpense" => $allexpense]);
        } elseif ($request->isMethod(("POST"))) {
            $transection = transection::create([
                'user_id' => Auth::user()->id,
                'amount' => $request->amount,
                'type' => 0,
            ]);
            $expense = Expense::create([
                'user_id' => Auth::user()->id,
                'transection_ID' => $transection->id,
                'amount' => $request->amount,
                'expense_details' => $request->expense_details,
                'type' => "office",
                'remarks' => $request->remarks,
                'date' => $request->date,
            ]);
            $notification = notification::create([
                'user_ID' => $transection->user_id,
                'transection_ID' => $transection->id,
                'expense_ID' => $expense->id,
                'notification' => "Office Expense:",
                'type' => 0,

            ]);
            return redirect()->back()->with(session()->flash('alert-success', 'Expense registered to the system'));
        } else {
            $amount = transection::where("type", "=", 1)->sum('amount');
            $user = count(User::where("role", "=", "user")->get());
            return view("admin.dashboard", ['amount' => $amount, 'user' => $user]);
        }
    }
    /**
     *GET: Shows (Admin) food expense && POST: Add food expence and add in the transection table & expense table
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view food expense || @return  redirect with flash message
     */
    public function foodexpense(Request $request)
    {
        if ($request->isMethod("GET")) {
            // $myexpense = Expense::where("user_id", "=", Auth::user()->id)->get();
            $allexpense = Expense::where("type", "=", "food")
                ->join("users", "users.id", "=", "expense.user_ID")
                ->orderBy("expense.created_at", "desc")->get(["users.name", "users.designation", "users.department", "expense.*"]);
            //dd($allexpense);
            $users = User::get(["users.name"]);
            // dd($users);
            return view("admin.foodExpense", ['users' => $users, "allexpense" => $allexpense]);
        } elseif ($request->isMethod(("POST"))) {
            $transection = transection::create([
                'user_id' => Auth::user()->id,
                'amount' => $request->amount,
                'type' => 0,
            ]);
            $expense = Expense::create([
                'user_id' => Auth::user()->id,
                'transection_ID' => $transection->id,
                'amount' => $request->amount,
                'expense_details' => $request->expense_details,
                'type' => "food",
                'remarks' => $request->remarks,
                'date' => $request->date,
            ]);
            $notification = notification::create([
                'user_ID' => $transection->user_id,
                'transection_ID' => $transection->id,
                'expense_ID' => $expense->id,
                'notification' => "Food Expense ",
                'type' => 0,

            ]);
            return redirect()->back()->with(session()->flash('alert-success', 'Expense registered to the system'));
        }
    }
    /**
     *DELETE: Delete Admin Food expense
     *
     * @param  \Illuminate\Http\Request  $request @param $expense id
     *
     * @return redirect with flash message
     */
    public function deletefoodexpenseinfo(Request $request, $id)
    {
        if ($request->isMethod("POST")) {
            $expense = Expense::find($id);
            $transection = transection::find($expense->transection_ID);
            $transection->delete();
            return redirect()->back()->with(session()->flash('alert-success', 'Expense record Deleted'));
        } else {
            return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong'));
        }
    }
    /**
     *Update: Update Admin Food expense
     *
     * @param  \Illuminate\Http\Request  $request @param $expense id
     *
     * @return redirect with flash message
     */
    public function updatefoodexpenseinfo(Request $request, $id)
    {
        if ($request->isMethod("POST")) {
            if ($request != null) {
                if ($request->expense_details != '') {
                    $expense = Expense::where("id", "=", $id)->update(["expense_details" => $request->expense_details]);
                }
                if ($request->date != '') {
                    $expense = Expense::where("id", "=", $id)->update(["date" => $request->date]);
                }
                if ($request->remarks != '') {
                    $expense = Expense::where("id", "=", $id)->update(["remarks" => $request->remarks]);
                }
                if ($request->amount != '') {
                    $expense = Expense::find($id);
                    $transection = transection::where("id", "=", $expense->transection_ID)->update(["amount" => $request->amount]);
                    $expense = $expense->update(["amount" => $request->amount]);
                }
                return redirect()->back()->with(session()->flash('alert-success', 'Expense Upgraded'));
            }
        } else {
            return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong'));
        }
    }
    /**
     *GET: Shows (User) office expense && POST: Add office expence and add in the transection table & expense table
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view office expense || @return redirect with flash message
     */

    public function userofficeexpense(Request $request)
    {
        if ($request->isMethod(("GET"))) {
            $myexpense = Expense::where("user_id", "=", Auth::user()->id)
                ->where("type", "=", "office")
                ->orderBy("expense.created_at", "desc")->get(["*"]);
            //dd($allexpense);
            $users = User::get(["users.name"]);
            // dd($users);
            return view("user.officeexpense", ['users' => $users, "myexpense" => $myexpense]);
        } elseif ($request->isMethod(("POST"))) {
            $transection = transection::create([
                'user_id' => Auth::user()->id,
                'amount' => $request->amount,
                'type' => 0,
            ]);
            $expense = Expense::create([
                'user_id' => Auth::user()->id,
                'transection_ID' => $transection->id,
                'amount' => $request->amount,
                'expense_details' => $request->expense_details,
                'type' => "office",
                'remarks' => '-',
                'date' => $request->date,
            ]);
            $notification = notification::create([
                'user_ID' => $transection->user_id,
                'transection_ID' => $transection->id,
                'expense_ID' => $expense->id,
                'notification' => "Office Expense:",
                'type' => 0,

            ]);
            return redirect()->back()->with(session()->flash('alert-success', 'Expense registered to the system'));
        } else {
            $amount = transection::where("type", "=", 1)->sum('amount');
            $user = count(User::where("role", "=", "user")->get());
            return view("admin.dashboard", ['amount' => $amount, 'user' => $user]);
        }
    }
    /**
     *GET: Shows (User) food expense && POST: Add food expence and add in the transection table & expense table
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view food expense && @return redirect with flash message
     */
    public function userfoodexpense(Request $request)
    {
        if ($request->isMethod("GET")) {
            // $myexpense = Expense::where("user_id", "=", Auth::user()->id)->get();
            $myexpense = Expense::where("user_id", "=", Auth::user()->id)
                ->where("type", "=", "food")
                ->orderBy("expense.created_at", "desc")->get(["*"]);
            //dd($allexpense);
            $users = User::get(["users.name"]);
            // dd($users);
            return view("user.foodexpense", ['users' => $users, "myexpense" => $myexpense]);
        } elseif ($request->isMethod(("POST"))) {
            $transection = transection::create([
                'user_id' => Auth::user()->id,
                'amount' => $request->amount,
                'type' => 0,
            ]);
            $expense = Expense::create([
                'user_id' => Auth::user()->id,
                'transection_ID' => $transection->id,
                'amount' => $request->amount,
                'expense_details' => $request->expense_details,
                'type' => "food",
                'remarks' => '-',
                'date' => $request->date,
            ]);
            $notification = notification::create([
                'user_ID' => $transection->user_id,
                'transection_ID' => $transection->id,
                'expense_ID' => $expense->id,
                'notification' => "Food Expense ",
                'type' => 0,

            ]);
            return redirect()->back()->with(session()->flash('alert-success', 'Expense registered to the system'));
        }
    }
}
