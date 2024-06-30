# Employees Service

## Requirments

### 1. Configure env

### 2. Install

```bash
composer install
```

### 3. Run migrations

```bash
php artisan migrate
```

### 4. Run tests

```bash
php artisan test
```

## REST

### Request Store Employee

`POST /api/employees/store`
```json
{
    "email": "example1@mail.ru",
    "password": "123456"
}
```

### Response
```json
{
    "data": {
        "email": "example1@mail.ru",
        "updated_at": "2024-06-30T12:05:06.000000Z",
        "created_at": "2024-06-30T12:05:06.000000Z",
        "id": 3
    }
}
```

### Request Store Employee Transaction

`POST /api/employee_transactions/store`
```json
{
    "employee_id": 3,
    "hours": 24
}
```

### Response
```json
{
    "data": {
        "employee_id": 3,
        "hours": 24,
        "updated_at": "2024-06-30T10:07:18.000000Z",
        "created_at": "2024-06-30T10:07:18.000000Z",
        "id": 6
    }
}
```

### Request Get Employees

`POST /api/employees/index`
```json
{

}
```

### Response
```json
{
    "data": [
        {
            "employee_id": 1,
            "total_sum": 0
        },
        {
            "employee_id": 2,
            "total_sum": 0
        },
        {
            "employee_id": 3,
            "total_sum": 60000
        }
    ]
}
```

### Request Close Transactions

`POST /api/employee_transactions/close_all`
```json
{

}
```

### Response
```json
{

}
```