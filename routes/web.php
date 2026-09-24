<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employees/export-pdf', [\App\Exports\EmployeesPdfExport::class, 'download'])
    ->middleware('auth')
    ->name('employees.export-pdf');

Route::get('/departments/export-pdf', [\App\Exports\DepartmentsPdfExport::class, 'download'])
    ->middleware('auth')
    ->name('departments.export-pdf');

Route::get('/employee-documents/export-pdf', [\App\Exports\EmployeeDocumentsPdfExport::class, 'download'])
    ->middleware('auth')
    ->name('employee-documents.export-pdf');

Route::get('/attendances/export-pdf', [\App\Exports\AttendancesPdfExport::class, 'download'])
    ->middleware('auth')
    ->name('attendances.export-pdf');
    
Route::get('/leaves/export-pdf', [\App\Exports\LeavesPdfExport::class, 'download'])
    ->middleware('auth')
    ->name('leaves.export-pdf');    
Route::get('/payrolls/export-pdf', [\App\Exports\PayrollsPdfExport::class, 'download'])
    ->middleware('auth')
    ->name('payrolls.export-pdf');
