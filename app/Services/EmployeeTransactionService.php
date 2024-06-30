<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\EmployeeTransaction;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\EmployeeTransactionRepositoryInterface;
use App\Services\Contracts\EmployeeTransactionServiceInterface;

class EmployeeTransactionService implements EmployeeTransactionServiceInterface
{
    protected EmployeeTransactionRepositoryInterface $repo;

    public function __construct(EmployeeTransactionRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function create(array $attributes): ?EmployeeTransaction
    {
        $transaction = $this->repo->create($attributes);

        return $transaction;
    }

    public function closeAllTransactions(): void
    {
        $this->repo->closeAllTransactions();
    }
}
