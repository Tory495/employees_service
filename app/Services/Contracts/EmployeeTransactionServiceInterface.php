<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Models\EmployeeTransaction;

interface EmployeeTransactionServiceInterface
{
    public function create(array $attributes): ?EmployeeTransaction;
    public function closeAllTransactions(): void;
}
