<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\transection;

use App\Expense;

use App\Salary;

use App\notification;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{

    /**
     *GET: Shows admin dashboard
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view admin dashboard with total debit , total credit , total user , total salary given , notifiction table
     */
    public function dashboard(Request $request)
    {
        if ($request->isMethod("GET")) {
            $debit = transection::where("type", "=", 1)->sum('amount');
            $credit = transection::where("type", "=", 0)->sum('amount');
            $amount = $debit - $credit;
            $user = count(User::where("role", "=", "user")->get());
            $expense = Expense::whereMonth('date', '=', now()->month)->sum("amount");
            $salary = Salary::whereMonth('created_at', '=', now()->month)->sum("amount");
            $notification = notification::join("users", "users.id", "=", "notification.user_ID")
                ->join("transection", "transection.id", "=", "notification.transection_ID")
                ->orderBy("notification.created_at", "desc")->get(["notification.*", "users.name", "transection.amount"]);
            // dd($notification);
            // return Carbon\Carbon::parse($date->created_at)->month;
            return view("admin.dashboard", ['amount' => $amount, 'user' => $user, 'expense' => $expense, 'salary' => $salary, 'notification' => $notification]);
        } else {
            return "echo 'Ongoing'";
        }
    }
    /**
     *GET: Shows add member form && POST: Adds member to the system
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view addmember form and redirct with flash message
     */
    public function addmember(Request $request)
    {
        if ($request->isMethod("GET")) {
            return view("admin.addmember");
        } else if ($request->isMethod("POST")) {
            $user = User::where("email", "=", $request->m_email);
            if ($user->count() != 0) {
                return redirect()->back()->with(session()->flash('alert-warning', 'Email Already Used'));
            } else {
                $user = User::create([
                    'name' => $request->m_name,
                    'email' => $request->m_email,
                    'image_path' => 'None',
                    'verification_code' => 'ItsNotNeed',
                    'stage' => $request->m_stage,
                    'role' => 'user',
                    'is_verified' => '0',
                    'designation' => $request->m_positon,
                    'department' => $request->m_department,
                    'number' => $request->m_num,
                    'password' => Hash::make($request->m_passoword),
                    'salary' =>  $request->m_sal,
                ]);
                return redirect()->back()->with(session()->flash('alert-success', 'Member Added'));
            }
        } else {
            return redirect()->back()->with(session()->flash('alert-warning', 'Something wrong'));
        }
    }
    /**
     * View All members
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view viewmember table with all user data
     */
    public function viewmember(Request $request)
    {
        if ($request->isMethod("GET")) {
            $user = User::where("role", "=", "user")->get()->all();
            //  dd($user);
            return view("admin.viewmember", compact(["user", $user]));
        } else {
            return redirect()->back();
        }
    }
    /**
     * Delete member
     *
     * @param  \Illuminate\Http\Request  $request @param App\User $id
     *
     * @return redirect admin edit profile with flash message
     */
    public function deletemember($id, Request $request)
    {
        if ($request->isMethod("POST")) {
            $user = User::find($id);
            $user->delete();
            return redirect()->back()->with(session()->flash('alert-success', 'Member Deleted'));
        } else {
            return redirect()->back();
        }
    }
    /**
     * Admin updates all member data
     *
     * @param  \Illuminate\Http\Request  $request , $id( user )
     *
     * @return view viewmember table with all user updated data + Flash message
     */
    public function updateinfo($id, Request $request)
    {
        // dd($request);
        if ($request != null) {
            if ($request->name != '') {
                $user = User::where("id", "=", $id)->update(["name" => $request->name]);
            }
            if ($request->email != '') {
                $user = User::where("id", "=", $id)->update(["email" => $request->email]);
            }
            if ($request->number != '') {
                $user = User::where("id", "=", $id)->update(["number" => $request->number]);
            }
            if ($request->department != '') {
                $user = User::where("id", "=", $id)->update(["department" => $request->department]);
            }
            if ($request->position != '') {
                $user = User::where("id", "=", $id)->update(["position" => $request->position]);
                //  return redirect()->back()->with(session()->flash('alert-success', 'Profile Name Updated'));
            }
            if ($request->salary != '') {
                $user = User::where("id", "=", $id)->update(["salary" => $request->salary]);
                //  return redirect()->back()->with(session()->flash('alert-success', 'Profile Name Updated'));
            }
            if ($request->password != '') {
                $user = User::where("id", "=", $id)->update(["password" => Hash::make($request->password)]);
                //  return redirect()->back()->with(session()->flash('alert-success', 'Profile Name Updated'));
            }

            return redirect()->back()->with(session()->flash('alert-success', 'Profile Updated'));
        } else {
            return redirect()->back()->with(session()->flash('alert-warning', 'Something Went Wrong'));
        }
    }

    /**
     * Lock Unlocks member state | Updates user table
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view viewmember table with all user updated data
     */
    public function changeStage(Request $request)
    {
        if ($request->ajax()) {
            $user = User::where("id", "=", $request->id)->first();
            if ($user->stage == 0) {
                $user->stage = 1;
                $user->save();

                return redirect()->back();
            } else {
                $user->stage = 0;
                $user->save();
                return redirect()->back();
            }
        }
        return redirect()->route("index");
    }
    /**
     * Shows Admin profile with details
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return view admin profile
     */
    public function profile(Request $request)
    {
        if ($request->isMethod("GET")) {
            return view("admin.profile");
        } else {
            return redirect()->back();
        }
    }
    /**
     * Edit admin profile
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return redirect admin edit profile with flash message
     */
    public function editprofile(Request $request)
    {
        if ($request->isMethod("GET")) {
            return view("admin.editprofile");
        } elseif ($request->isMethod("POST")) {
            $id = Auth::user()->id;
            if ($request != null) {
                if ($request->name != '') {
                    $user = User::where("id", "=", $id)->update(["name" => $request->name]);

                    //return redirect()->back()->with(session()->flash('alert-success', 'Profile Name Updated'));
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
                if ($request->hasFile('profile_image')) {
                    $image = $request->file('profile_image');
                    $name = time() . '.' . $image->getClientOriginalExtension();
                    $path = '/images/';
                    $destinationPath = public_path('images');
                    $image->move($destinationPath, $name);

                    $user_image = '';
                    if (isset($name)) {
                        $user_image = $path . $name;
                    }
                    User::where('id', '=', Auth::user()->id)->update(["image_path" => $user_image]);
                }
                return redirect()->back()->with(session()->flash('alert-success', 'Profile Updated'));
            }
        } else {
            return redirect()->back();
        }
    }
}
