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
     * @return view  admin.addammount with ammount histroy
     */

    public function addamount(Request $request)
    {
        if ($request->isMethod("GET")) {
            $Gain = Gain::where("user_id", "=", Auth::user()->id)
                ->orderBy("created_at", "desc")
                ->get(['created_at', 'amount', 'gain_details']);
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
     *GET: Shows (Admin) office expense && POST: Add office expence and add in the transection table & expense table
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view office expense && redirect with flash message
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
     * @return view food expense && redirect with flash message
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
     *GET: Shows (User) office expense && POST: Add office expence and add in the transection table & expense table
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view office expense && redirect with flash message
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
     *GET: Shows (User) food expense && POST: Add food expence and add in the transection table & expense table
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view food expense && redirect with flash message
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
}
