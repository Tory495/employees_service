<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use App\Repositories\EmployeeTransactionRepository;
use App\Services\EmployeeService;
use App\Services\EmployeeTransactionService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EmployeeApiTest extends TestCase
{
    use RefreshDatabase;

    public function testEmployeesStore(): void
    {
        $data = [
            'email' => 'example@mail.ru',
            'password' => '12345'
        ];

        $employeeRepository = new EmployeeRepository();
        $employeeService = new EmployeeService($employeeRepository);

        $employee = $employeeService->create($data);

        $this->assertInstanceOf(Employee::class, $employee);
        $this->assertEquals('example@mail.ru', $employee->email);
        $this->assertTrue(Hash::check('12345', $employee->password));
        $this->assertDatabaseCount('employees', 1);
        $this->assertDatabaseHas('employees', [
            'email' => 'example@mail.ru'
        ]);

        $this->expectException(QueryException::class);

        $employeeService->create($data);

        $this->assertDatabaseCount('employees', 1);

        $response = $this->post('/api/employees', [
            'email' => 'test@mail.ru',
            'password' => 'test'
        ]);

        $response->assertOk()->assertJsonPath('data.email', 'test@mail.ru');
        $this->assertDatabaseCount('employees', 2);
        $this->assertDatabaseHas('employees', [
            'email' => 'test@mail.ru'
        ]);
    }

    public function testEmployeesIndex(): void
    {
        $payment = config('employee.payment');

        $employeeRepository = new EmployeeRepository();
        $employeeService = new EmployeeService($employeeRepository);

        $emp1 = $employeeService->create([
            'email' => 'example1@mail.ru',
            'password' => '123456'
        ]);

        $emp2 = $employeeService->create([
            'email' => 'example2@mail.ru',
            'password' => '123456'
        ]);

        $emp3 = $employeeService->create([
            'email' => 'example3@mail.ru',
            'password' => '123456'
        ]);

        $employeeTransactionRepository = new EmployeeTransactionRepository();
        $employeeTransactionService = new EmployeeTransactionService($employeeTransactionRepository);

        $employeeTransactionService->create([
            'employee_id' => $emp1->id,
            'hours' => 7
        ]);

        $employeeTransactionService->create([
            'employee_id' => $emp1->id,
            'hours' => 3
        ]);

        $response = $this->get('/api/employees/index');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['employee_id', 'total_sum']
                ]
            ])
            ->assertJson(
                function (AssertableJson $json) use ($payment) {
                    $json->where('data.0.total_sum', 10 * $payment);
                    $json->where('data.1.total_sum', 0);
                    $json->where('data.2.total_sum', 0);
                }
            );

        $this->assertDatabaseCount('employees', 3);
        $this->assertDatabaseCount('employee_transactions', 2);
        $this->assertDatabaseMissing('employee_transactions', [
            'is_paid' => true
        ]);
    }
}
