<?php

namespace App\Http\Controllers;

use App\Exports\SalaryExport;

use App\Exports\SalaryExportMonthly;

use Illuminate\Http\Request;

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
}
