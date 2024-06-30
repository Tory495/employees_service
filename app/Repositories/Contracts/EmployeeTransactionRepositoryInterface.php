<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\EmployeeTransaction;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeTransactionRepositoryInterface
{
    public function create(array $attributes): ?EmployeeTransaction;
    public function closeAllTransactions(): void;
}
