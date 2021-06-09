<?php

namespace App\Http\Controllers;

use App\Exports\SalaryExport;
use Illuminate\Http\Request;

use App\Salary;

use App\User;

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
}
