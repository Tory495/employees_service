<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Services\Contracts\EmployeeServiceInterface;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    protected EmployeeServiceInterface $service;

    public function __construct(EmployeeServiceInterface $service)
    {
        $this->service = $service;
    }

    public function store(EmployeeRequest $request): JsonResponse
    {
        $data = $request->all();
        $employee = $this->service->create($data);

        return response()->json([
            'data' => $employee
        ]);
    }

    public function index(): JsonResponse
    {
        $employees = $this->service->getAllWithTransactionsSum();

        return response()->json([
            'data' => $employees
        ]);
    }
}
