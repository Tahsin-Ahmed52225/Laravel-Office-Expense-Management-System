<?php

namespace App\Http\Controllers;

use App\Exports\SalaryExport;

use App\Exports\SalaryExportMonthly;
use App\Exports\transactionExportMonthly;
use App\Exports\transactionExportYearly;
use Illuminate\Http\Request;

use App\transection;

use App\Salary;

class CsvController extends Controller
{
    public function Salary_CSV_Yearly(Request $request)
    {
        if ($request->isMethod("POST")) {
            $year = $request->year;
            $data =  Salary::join("users", "users.id", "=", "user_ID")->whereYear('salary.created_at', '=', $year)->get(["users.*", "salary.*"]);
            if (!$data->isEmpty()) {
                //  return Excel::download(new SalaryExport($year), 'data.csv');
                return (new SalaryExport($year))->download('data.csv');
            } else {
                return redirect()->back()->with(session()->flash('alert-warning', 'No records for this year'));
            }
        } else {
            return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
        }
    }
    public function Salary_CSV_Monthly(Request $request)
    {
        if ($request->isMethod("POST")) {
            $month = $request->month;
            $year = $request->myear;

            $data =  Salary::join("users", "users.id", "=", "user_ID")->whereMonth('salary.created_at', '=', $month)->whereYear('salary.created_at', '=', $year)->get(["users.*", "salary.*"]);
            if (!$data->isEmpty()) {
                //month number to month name
                return (new SalaryExportMonthly($year, $month))->download('data.csv');
            } else {
                return redirect()->back()->with(session()->flash('alert-warning', 'No records for this Month'));
            }
        } else {
            return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
        }
    }
    public function Transaction_CSV_Yearly(Request $request, $type)
    {
        if ($request->isMethod("POST")) {
            $year = $request->year;
            $total_gain =  transection::whereYear('transection.created_at', '=', $year)->where("type", "=", 1)->sum("amount");
            $total_expense =  transection::whereYear('transection.created_at', '=', $year)->where("type", "=", 0)->sum("amount");
            if ($type == "All") {
                $data =  transection::join("users", "users.id", "=", "user_id")->whereYear('transection.created_at', '=', $year)->get(["users.*", "transection.*"]);
            }
            // else if ($type == "All_Gain") {
            //     $data =  transection::join("users", "users.id", "=", "user_id")
            //         ->whereYear('transection.created_at', '=', $year)
            //         ->where("category", "=", "Gain")
            //         ->get(["users.*", "transection.*"]);
            // } else if ($type == "All_Expense") {
            //     $data =  transection::join("users", "users.id", "=", "user_id")
            //         ->whereYear('transection.created_at', '=', $year)
            //         ->where("type", "=", 0)
            //         ->get(["users.*", "transection.*"]);
            // } else if ($type == "Office_Expence") {
            //     $data =  transection::join("users", "users.id", "=", "user_id")
            //         ->whereYear('transection.created_at', '=', $year)
            //         ->where("category", "=", "Office Expense")
            //         ->get(["users.*", "transection.*"]);
            // } else if ($type == "Food_Expence") {
            //     $data =  transection::join("users", "users.id", "=", "user_id")
            //         ->whereYear('transection.created_at', '=', $year)
            //         ->where("category", "=", "Food Expense")
            //         ->get(["users.*", "transection.*"]);
            // } else if ($type == "Advance_Histroy") {
            //     $data =  transection::join("users", "users.id", "=", "user_id")
            //         ->whereYear('transection.created_at', '=', $year)
            //         ->where("category", "=", "Advance out")
            //         ->orwhere("category", "=", "Advance in")
            //         ->get(["users.*", "transection.*"]);
            // }

            if (!$data->isEmpty()) {
                return (new transactionExportYearly($year))->download('data.csv');
            } else {
                return redirect()->back()->with(session()->flash('alert-warning', 'No records for this year'));
            }
        } else {
            return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
        }
    }
    public function Transaction_CSV_Monthly(Request $request, $type)
    {
        if ($request->isMethod("POST")) {
            $month = $request->month;
            $year = $request->myear;
            $total_gain =  transection::whereYear('transection.created_at', '=', $year)->whereMonth('transection.created_at', '=', $month)->where("type", "=", 1)->sum("amount");
            $total_expense =  transection::whereYear('transection.created_at', '=', $year)->whereMonth('transection.created_at', '=', $month)->where("type", "=", 0)->sum("amount");
            if ($type == "All") {
                $data =  transection::join("users", "users.id", "=", "user_id")
                    ->whereMonth('transection.created_at', '=', $month)
                    ->whereYear('transection.created_at', '=', $year)
                    ->get(["users.*", "transection.*"]);
            }
            // else if ($type == "All_Gain") {
            //     $data =  transection::join("users", "users.id", "=", "user_id")
            //         ->whereMonth('transection.created_at', '=', $month)
            //         ->whereYear('transection.created_at', '=', $year)
            //         ->where("category", "=", "Gain")
            //         ->get(["users.*", "transection.*"]);
            // } else if ($type == "All_Expense") {
            //     $data =  transection::join("users", "users.id", "=", "user_id")
            //         ->whereMonth('transection.created_at', '=', $month)
            //         ->whereYear('transection.created_at', '=', $year)
            //         ->where("type", "=", 0)
            //         ->get(["users.*", "transection.*"]);
            // } else if ($type == "Office_Expence") {
            //     $data =  transection::join("users", "users.id", "=", "user_id")
            //         ->whereMonth('transection.created_at', '=', $month)
            //         ->whereYear('transection.created_at', '=', $year)
            //         ->where("category", "=", "Office Expense")
            //         ->get(["users.*", "transection.*"]);
            // } else if ($type == "Food_Expence") {
            //     $data =  transection::join("users", "users.id", "=", "user_id")
            //         ->whereMonth('transection.created_at', '=', $month)
            //         ->whereYear('transection.created_at', '=', $year)
            //         ->where("category", "=", "Food Expense")
            //         ->get(["users.*", "transection.*"]);
            // } else if ($type == "Advance_Histroy") {
            //     $data =  transection::join("users", "users.id", "=", "user_id")
            //         ->whereMonth('transection.created_at', '=', $month)
            //         ->whereYear('transection.created_at', '=', $year)
            //         ->where("category", "=", "Advance out")
            //         ->orwhere("category", "=", "Advance in")
            //         ->get(["users.*", "transection.*"]);
            // }

            // $data =  transection::join("users", "users.id", "=", "user_id")->whereMonth('transection.created_at', '=', $month)->whereYear('transection.created_at', '=', $year)->get(["users.*", "transection.*"]);
            if (!$data->isEmpty()) {
                //month number to month name
                return (new transactionExportMonthly($year, $month))->download('data.csv');
            } else {
                return redirect()->back()->with(session()->flash('alert-warning', 'No records for this Month'));
            }
        } else {
            return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
        }
    }
}
