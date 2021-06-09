<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\transection;

use App\User;

use App\Expense;

use App\advance;

use App\notification;

use Illuminate\Support\Facades\Auth;

class advanceController extends Controller
{
    public function advance(Request $request)
    {
        if ($request->isMethod("GET")) {
            // $myexpense = Expense::where("user_id", "=", Auth::user()->id)->get();
            $allexpense = Expense::where("type", "=", "food")
                ->join("users", "users.id", "=", "expense.user_ID")
                ->orderBy("expense.created_at", "desc")->get(["users.name", "users.designation", "users.department", "expense.*"]);
            //dd($allexpense);
            $users = User::get(["users.name", "users.id"]);
            // dd($users);
            return view("admin.advance", ['users' => $users, "allexpense" => $allexpense]);
        } elseif ($request->isMethod(("POST"))) {
            $transection = transection::create([
                'user_id' => $request->remarks,
                'amount' => $request->amount,
                'type' => 0,
            ]);
            $advance = advance::create([
                'user_ID' => $request->remarks,
                'transection_ID' => $transection->id,
                'amount' => $transection->amount,
                'type' => 0,
            ]);
            $notification = notification::create([
                'user_ID' => $transection->user_id,
                'transection_ID' => $transection->id,
                'expense_ID' => null,
                'notification' => "Advance payment : ",
                'type' => 2,

            ]);
            return redirect()->back()->with(session()->flash('alert-success', 'Advanced registered in the system'));
        }
    }
    public function receive(Request $request)
    {
        if ($request->isMethod(("POST"))) {
            $transection = transection::create([
                'user_id' => $request->remarks,
                'amount' => $request->amount,
                'type' => 1,
            ]);
            $advance = advance::create([
                'user_ID' => $request->remarks,
                'transection_ID' => $transection->id,
                'amount' => $transection->amount,
                'type' => 1,
            ]);
            $notification = notification::create([
                'user_ID' => $transection->user_id,
                'transection_ID' => $transection->id,
                'expense_ID' => null,
                'notification' => "Advance payment : ",
                'type' => 3,

            ]);
            return redirect()->back()->with(session()->flash('alert-success', 'Advanced Repaid Successfully'));
        }
    }
}
