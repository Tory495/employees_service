<?php

namespace Tests\Feature;

use App\Models\EmployeeTransaction;
use App\Repositories\EmployeeRepository;
use App\Repositories\EmployeeTransactionRepository;
use App\Services\EmployeeService;
use App\Services\EmployeeTransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTransactionApiTest extends TestCase
{
    use RefreshDatabase;

    public function testEmployeeTransactionStore(): void
    {
        $employeeData = [
            'email' => 'example@mail.ru',
            'password' => '12345'
        ];

        $employeeRepository = new EmployeeRepository();
        $employeeService = new EmployeeService($employeeRepository);

        $employee = $employeeService->create($employeeData);

        $employeeTransactionData = [
            'employee_id' => $employee->id,
            'hours' => 8
        ];

        $employeeTransactionRepository = new EmployeeTransactionRepository();
        $employeeTransactionService = new EmployeeTransactionService($employeeTransactionRepository);

        $transaction = $employeeTransactionService->create($employeeTransactionData);

        $this->assertInstanceOf(EmployeeTransaction::class, $transaction);
        $this->assertEquals(8, $transaction->hours);
        $this->assertDatabaseCount('employee_transactions', 1);

        $response = $this->post('/api/employee_transactions/store', $employeeTransactionData);

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'employee_id',
                    'hours',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ])
            ->assertJsonPath('data.hours', 8);

        $this->assertDatabaseCount('employee_transactions', 2);
    }

    public function testEmployeesTransactionsClose(): void
    {
        $employeeData = [
            'email' => 'example@mail.ru',
            'password' => '12345'
        ];

        $employeeRepository = new EmployeeRepository();
        $employeeService = new EmployeeService($employeeRepository);

        $employee = $employeeService->create($employeeData);

        $employeeTransactionRepository = new EmployeeTransactionRepository();
        $employeeTransactionService = new EmployeeTransactionService($employeeTransactionRepository);

        $employeeTransactionService->create([
            'employee_id' => $employee->id,
            'hours' => 4
        ]);

        $employeeTransactionService->create([
            'employee_id' => $employee->id,
            'hours' => 6
        ]);

        $employeeTransactionService->create([
            'employee_id' => $employee->id,
            'hours' => 7
        ]);

        $this->assertDatabaseCount('employee_transactions', 3);

        $response = $this->post('/api/employee_transactions/close_all');

        $response->assertOk();

        $this->assertDatabaseMissing('employee_transactions', [
            'is_paid' => false
        ]);

        $this->assertDatabaseHas('employee_transactions', [
            'is_paid' => true
        ]);
    }
}
