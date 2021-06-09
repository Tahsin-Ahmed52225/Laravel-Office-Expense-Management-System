<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\transection;

use App\Expense;

use App\notification;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     *GET: Shows user dashboard
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view admin dashboard with total debit , total credit notifiction table
     */
    public function dashboard(Request $request)
    {
        if ($request->isMethod("GET")) {
            $debit = transection::where("type", "=", 1)->sum('amount');
            $credit = transection::where("type", "=", 0)->sum('amount');
            $amount = $debit - $credit;
            $user = count(User::where("role", "=", "user")->get());
            $expense = Expense::whereMonth('date', '=', now()->month)->sum("amount");
            $notification = notification::join("users", "users.id", "=", "notification.user_ID")
                ->join("transection", "transection.id", "=", "notification.transection_ID")
                ->orderBy("notification.created_at", "desc")->get(["notification.*", "users.name", "transection.amount"]);
            // dd($notification);
            // return Carbon\Carbon::parse($date->created_at)->month;
            return view("user.dashboard", ['amount' => $amount, 'user' => $user, 'expense' => $expense, 'notification' => $notification]);
        } else {
            return "echo 'Ongoing'";
        }
    }
    /**
     * Shows User profile with details
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view user profile
     */
    public function profile(Request $request)
    {
        if ($request->isMethod("GET")) {
            return view("user.profile");
        } else {
            return redirect()->back();
        }
    }
    /**
     * Edit user profile
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view user edit profile || @return redirect with flash message
     */
    public function editprofile(Request $request)
    {
        if ($request->isMethod("GET")) {
            return view("user.editprofile");
        } elseif ($request->isMethod("POST")) {
            $id = Auth::user()->id;
            if ($request != null) {
                if ($request->name != '') {
                    $user = User::where("id", "=", $id)->update(["name" => $request->name]);
                }
                if ($request->email != '') {
                    $user = User::where("id", "=", $id)->update(["email" => $request->email]);
                }
                if ($request->designation != '') {
                    $user = User::where("id", "=", $id)->update(["designation" => $request->designation]);
                }
                if ($request->department != '') {
                    $user = User::where("id", "=", $id)->update(["department" => $request->department]);
                }
                if ($request->password != '') {
                    $user = User::where("id", "=", $id)->update(["password" => Hash::make($request->password)]);
                }
                if ($request->number != '') {
                    $user = User::where("id", "=", $id)->update(["number" => $request->number]);
                }
                return redirect()->back()->with(session()->flash('alert-success', 'Profile Updated'));
            }
        } else {
            return redirect()->back();
        }
    }
}
