<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EmployeeImport implements ToModel, WithStartRow, WithValidation, WithMultipleSheets
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $data = [
            'name' => $row[1],
            'address' => $row[2],
            'phone' => $row[3],
            'avatar' => $row[4]
        ];

        $a =  Employee::create($data);

        return null;
    }

    public function rules(): array
    {
        return [
            '*.1' => [
                'required'
            ],
            '*.2' => [
                'required'
            ],
            '*.3' => [
                'required'
            ],
            '*.4' => [
                'required'
            ]
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.1.required' => 'Họ và tên không được bỏ trống',
            '*.2.required' => 'Địa chỉ không được bỏ trống',
            '*.3.required' => 'Số điện thoại không được bỏ trống',
            '*.4.required' => 'Avatar không được bỏ trống'
        ];
    }

    public function startRow(): int
    {
        return 3;
    }

    // choose name sheet in file excel import
    public function sheets(): array
    {
        return [
            'Sheet1' => new EmployeeImport()
        ];
    }
}
