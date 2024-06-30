<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeTransactionRequest;
use App\Services\Contracts\EmployeeTransactionServiceInterface;
use Illuminate\Http\JsonResponse;

class EmployeeTransactionController extends Controller
{
    protected EmployeeTransactionServiceInterface $service;

    public function __construct(EmployeeTransactionServiceInterface $service)
    {
        $this->service = $service;
    }

    public function store(EmployeeTransactionRequest $request): JsonResponse
    {
        $data = $request->all();
        $transaction = $this->service->create($data);

        return response()->json([
            'data' => $transaction
        ]);
    }

    public function closeAll(): JsonResponse
    {
        $this->service->closeAllTransactions();

        return response()->json([
            'data' => []
        ]);
    }
}
