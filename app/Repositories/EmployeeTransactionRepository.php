<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\EmployeeTransaction;
use App\Repositories\Contracts\EmployeeTransactionRepositoryInterface;

class EmployeeTransactionRepository implements EmployeeTransactionRepositoryInterface
{
    public function create(array $attributes): ?EmployeeTransaction
    {
        $transaction = new EmployeeTransaction($attributes);
        $transaction->save();

        return $transaction;
    }

    public function closeAllTransactions(): void
    {
        $transactions = EmployeeTransaction::where('is_paid', false);
        $transactions->update(['is_paid' => true]);
    }
}
