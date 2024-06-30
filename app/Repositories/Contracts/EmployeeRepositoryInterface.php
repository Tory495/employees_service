<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeRepositoryInterface
{
    public function create(array $attributes): ?Employee;
    public function getAllWithTransactionsSum(): Collection;
}
