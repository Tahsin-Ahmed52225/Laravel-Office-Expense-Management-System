<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\transection;

use App\User;

use App\advance;

use App\notification;

use Illuminate\Support\Facades\Auth;

class advanceController extends Controller
{
    public function advance(Request $request)
    {
        if ($request->isMethod("GET")) {
            // $myexpense = Expense::where("user_id", "=", Auth::user()->id)->get();
            $allexpense = advance::join("users", "users.id", "=", "advance.user_id")
                ->orderBy("advance.created_at", "desc")->get(["users.name", "users.designation", "users.department", "advance.*"]);
            //dd($allexpense);
            $users = User::get(["users.name", "users.id"]);
            // dd($users);
            return view("admin.advance", ['users' => $users, "allexpense" => $allexpense]);
        } elseif ($request->isMethod(("POST"))) {
            $transection = transection::create([
                'user_id' => $request->remarks,
                'amount' => $request->amount,
                'type' => 0,
                'category' => 'Advance out',
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
                'category' => 'Advance in',
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
    public function deleteAdvanceRecord(Request $request, $id)
    {
        if ($request->isMethod("POST")) {
            $transection = transection::find($id);
            if ($transection != null) {
                $transection->delete();
                return redirect()->back()->with(session()->flash('alert-success', 'Advance record deleted'));
            } else {
                return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong'));
            }
        } else {
            return redirect()->back();
        }
    }
    public function updateAdvanceRecord(Request $request, $id)
    {
        if ($request != null) {

            if ($request->name != '') {
                $advance = advance::find($id);
                $transection = transection::where("id", "=", $advance->transection_ID)->update(["user_ID" => $request->name]);
                $advance = $advance->update(["user_ID" => $request->name]);
            }
            if ($request->amount != '') {
                $advance = advance::find($id);
                $transection = transection::where("id", "=", $advance->transection_ID)->update(["amount" => $request->amount]);
                $advance = $advance->update(["amount" => $request->amount]);
            }
            return redirect()->back()->with(session()->flash('alert-success', 'Advance record Updated'));
        } else {
            return redirect()->back();
        }
    }
}
