<?php

namespace App\Http\Controllers;

use App\Imports\EmployeeImport;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use alhimik1986\PhpExcelTemplator\PhpExcelTemplator;

class FileController extends Controller
{
    public function downloadTemplateEmployee()
    {
        $filePath = 'templates/employees.xlsx';

        return Storage::disk('local')->download($filePath, 'employees.xlsx');
    }

    public function importTemplateEmployee(Request $request)
    {
        try {
            Excel::import(new EmployeeImport, $request->file('file'));
            return redirect('/')->with('success', 'Import success!');
        } catch (ValidationException $e) {
            $array_ers = [];
            $errors = $e->validator->errors()->toArray();

            foreach ($errors as $error) {
                foreach (array_values($error) as $key => $value) {
                    array_push($array_ers, $value);
                }
            }

            foreach ($e->failures() as $failure) {
                $row = $failure->row();
            }
            return redirect('/')->with('errors', ['error' => $array_ers, 'row_error' => 'Lỗi trên dòng ' . $row . ' ']);
        }
    }

    public function exportTemplateEmployee()
    {
        $employees = Employee::all();
        $callbacks = [];
        $templateFile = Storage::disk('local')->path('export-template/template-export-employee.xlsx');
        $fileName = Storage::disk('local')->path('result-export');
        $params = [];
        $stt = 1;
        foreach ($employees as $key => $employee) {
            $params['stt'][] = $stt;
            $params['name'][] = $employee->name;
            $params['address'][] = $employee->address;
            $params['phone'][] = $employee->phone;
            $params['avatar'][] = $employee->avatar;
            $stt++;
        }
        PhpExcelTemplator::saveToFile($templateFile, $fileName, $params, $callbacks);
    }
}
