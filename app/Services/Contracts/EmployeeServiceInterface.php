<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\Employee;

interface EmployeeServiceInterface
{
    public function create(array $attributes): ?Employee;
    public function getAllWithTransactionsSum(): AnonymousResourceCollection;
}
