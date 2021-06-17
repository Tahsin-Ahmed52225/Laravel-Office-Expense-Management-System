<?php

namespace App\Exports;

use App\transection;

use Maatwebsite\Excel\Concerns\FromQuery;

use Maatwebsite\Excel\Concerns\Exportable;

use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithProperties;

class transactionExportMonthly implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings, WithProperties
{

    use Exportable;

    public $year, $month;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }
    public function query()
    {
        return transection::query()->join("users", "users.id", "=", "user_ID")->whereMonth('transection.created_at', '=', $this->month)->whereYear('transection.created_at', '=', $this->year);
    }
    public function map($row): array
    {
        $fields = [
            $row->name,
            $row->designation,
            $row->department,
            $row->category,
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
            'Category',
            'Amount',
            'Date',
        ];
    }
    public function properties(): array
    {
        return [
            'creator'        => 'TDG Admin',
            'lastModifiedBy' => 'TDG Admin',
            'title'          => 'transection Record Export',
            'description'    => 'TDG member transection record exported into CSV formate',
            'subject'        => 'transection Record',
            'company'        => 'TheDevGarden',
        ];
    }
}
