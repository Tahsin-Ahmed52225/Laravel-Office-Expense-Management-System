<?php

namespace App\Exports;

use App\Salary;

use Maatwebsite\Excel\Concerns\FromQuery;

use Maatwebsite\Excel\Concerns\Exportable;

use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithStyles;

use Maatwebsite\Excel\Concerns\WithProperties;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalaryExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings, WithProperties, WithStyles
{
    use Exportable;

    public $year, $month;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($year)
    {
        $this->year = $year;
    }
    public function query()
    {
        return Salary::query()->join("users", "users.id", "=", "user_ID")->whereYear('salary.created_at', '=', $this->year);
    }
    public function map($row): array
    {
        $fields = [
            $row->name,
            $row->designation,
            $row->department,
            $row->amount,
            $row->created_at,
        ];
        return $fields;
    }
    public function headings(): array
    {
        return [
            'Name',
            'Designation',
            'Department',
            'Amount',
            'Date',
        ];
    }
    public function properties(): array
    {
        return [
            'creator'        => 'TDG Admin',
            'lastModifiedBy' => 'TDG Admin',
            'title'          => 'Salary Record Export',
            'description'    => 'TDG member salary record exported into CSV formate',
            'subject'        => 'Salary Record',
            'company'        => 'TheDevGarden',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
