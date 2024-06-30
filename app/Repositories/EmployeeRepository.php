<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function create(array $attributes): ?Employee
    {
        $employee = new Employee($attributes);
        $employee->save();

        return $employee;
    }

    public function getAllWithTransactionsSum(): Collection
    {
        $config = config('employee');

        $employees = Employee::withSum(['transactions as total_sum' => function (Builder $query) {
            $query->where('is_paid', false);
        }], 'hours')
            ->get()
            ->map(function (Employee $emp) use ($config) {
                $emp->total_sum *= $config['payment'];
                return $emp;
            });

        return $employees;
    }
}
