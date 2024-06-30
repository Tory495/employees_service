<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\EmployeesIndexResource;
use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Services\Contracts\EmployeeServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EmployeeService implements EmployeeServiceInterface
{
    protected EmployeeRepositoryInterface $repo;

    public function __construct(EmployeeRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function create(array $attributes): ?Employee
    {
        $employee = $this->repo->create($attributes);

        return $employee;
    }

    public function getAllWithTransactionsSum(): AnonymousResourceCollection
    {
        $employees = EmployeesIndexResource::collection($this->repo->getAllWithTransactionsSum());

        return $employees;
    }
}
