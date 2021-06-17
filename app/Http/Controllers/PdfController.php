<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Salary;

use App\transection;

use \PDF;

class PdfController extends Controller
{
    public function Salary_PDF_Yearly(Request $request)
    {
        if ($request->isMethod("POST")) {
            $year = $request->year;
            $data =  Salary::join("users", "users.id", "=", "user_ID")->whereYear('salary.created_at', '=', $year)->get(["users.*", "salary.*"]);
            if (!$data->isEmpty()) {
                $pdf = PDF::loadView('layouts.pdf.salary_layout', compact('data', 'year'));
                return $pdf->stream('data.pdf', array('Attachment' => 0));
            } else {
                return redirect()->back()->with(session()->flash('alert-warning', 'No records for this year'));
            }
        }
    }
    public function Salary_PDF_Monthly(Request $request)
    {
        if ($request->isMethod("POST")) {
            $month = $request->month;
            $year = $request->myear;

            $data =  Salary::join("users", "users.id", "=", "user_ID")->whereMonth('salary.created_at', '=', $month)->whereYear('salary.created_at', '=', $year)->get(["users.*", "salary.*"]);
            if (!$data->isEmpty()) {
                //month number to month name
                $year = "(" . date("F", mktime(0, 0, 0, $month, 10)) . ")-" . $year;
                $pdf = PDF::loadView('layouts.pdf.salary_layout', compact('data', 'year'));
                return $pdf->stream('data.pdf', array('Attachment' => 0));
            } else {
                return redirect()->back()->with(session()->flash('alert-warning', 'No records for this Month'));
            }
        }
    }
    public function Transaction_PDF_Yearly(Request $request, $type)
    {
        if ($request->isMethod("POST")) {
            $year = $request->year;
            $total_gain =  transection::whereYear('transection.created_at', '=', $year)->where("type", "=", 1)->sum("amount");
            $total_expense =  transection::whereYear('transection.created_at', '=', $year)->where("type", "=", 0)->sum("amount");
            if ($type == "All") {
                $data =  transection::join("users", "users.id", "=", "user_id")->whereYear('transection.created_at', '=', $year)->get(["users.*", "transection.*"]);
            } else if ($type == "All_Gain") {
                $data =  transection::join("users", "users.id", "=", "user_id")
                    ->whereYear('transection.created_at', '=', $year)
                    ->where("category", "=", "Gain")
                    ->get(["users.*", "transection.*"]);
            } else if ($type == "All_Expense") {
                $data =  transection::join("users", "users.id", "=", "user_id")
                    ->whereYear('transection.created_at', '=', $year)
                    ->where("type", "=", 0)
                    ->get(["users.*", "transection.*"]);
            } else if ($type == "Office_Expence") {
                $data =  transection::join("users", "users.id", "=", "user_id")
                    ->whereYear('transection.created_at', '=', $year)
                    ->where("category", "=", "Office Expense")
                    ->get(["users.*", "transection.*"]);
            } else if ($type == "Food_Expence") {
                $data =  transection::join("users", "users.id", "=", "user_id")
                    ->whereYear('transection.created_at', '=', $year)
                    ->where("category", "=", "Food Expense")
                    ->get(["users.*", "transection.*"]);
            } else if ($type == "Advance_Histroy") {
                $data =  transection::join("users", "users.id", "=", "user_id")
                    ->whereYear('transection.created_at', '=', $year)
                    ->where("category", "=", "Advance out")
                    ->orwhere("category", "=", "Advance in")
                    ->get(["users.*", "transection.*"]);
            }

            if (!$data->isEmpty()) {
                $pdf = PDF::loadView('layouts.pdf.transaction_layout', compact('data', 'year', 'total_gain', 'total_expense'));
                return $pdf->stream('data.pdf', array('Attachment' => 0));
            } else {
                return redirect()->back()->with(session()->flash('alert-warning', 'No records for this year'));
            }
        }
    }
    public function Transaction_PDF_Monthly(Request $request, $type)
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
            } else if ($type == "All_Gain") {
                $data =  transection::join("users", "users.id", "=", "user_id")
                    ->whereMonth('transection.created_at', '=', $month)
                    ->whereYear('transection.created_at', '=', $year)
                    ->where("category", "=", "Gain")
                    ->get(["users.*", "transection.*"]);
            } else if ($type == "All_Expense") {
                $data =  transection::join("users", "users.id", "=", "user_id")
                    ->whereMonth('transection.created_at', '=', $month)
                    ->whereYear('transection.created_at', '=', $year)
                    ->where("type", "=", 0)
                    ->get(["users.*", "transection.*"]);
            } else if ($type == "Office_Expence") {
                $data =  transection::join("users", "users.id", "=", "user_id")
                    ->whereMonth('transection.created_at', '=', $month)
                    ->whereYear('transection.created_at', '=', $year)
                    ->where("category", "=", "Office Expense")
                    ->get(["users.*", "transection.*"]);
            } else if ($type == "Food_Expence") {
                $data =  transection::join("users", "users.id", "=", "user_id")
                    ->whereMonth('transection.created_at', '=', $month)
                    ->whereYear('transection.created_at', '=', $year)
                    ->where("category", "=", "Food Expense")
                    ->get(["users.*", "transection.*"]);
            } else if ($type == "Advance_Histroy") {
                $data =  transection::join("users", "users.id", "=", "user_id")
                    ->whereMonth('transection.created_at', '=', $month)
                    ->whereYear('transection.created_at', '=', $year)
                    ->where("category", "=", "Advance out")
                    ->orwhere("category", "=", "Advance in")
                    ->get(["users.*", "transection.*"]);
            }

            // $data =  transection::join("users", "users.id", "=", "user_id")->whereMonth('transection.created_at', '=', $month)->whereYear('transection.created_at', '=', $year)->get(["users.*", "transection.*"]);
            if (!$data->isEmpty()) {
                //month number to month name
                $year = "(" . date("F", mktime(0, 0, 0, $month, 10)) . ")-" . $year;
                $pdf = PDF::loadView('layouts.pdf.transaction_layout', compact('data', 'year', 'total_gain', 'total_expense'));
                return $pdf->stream('data.pdf', array('Attachment' => 0));
            } else {
                return redirect()->back()->with(session()->flash('alert-warning', 'No records for this Month'));
            }
        }
    }
}
