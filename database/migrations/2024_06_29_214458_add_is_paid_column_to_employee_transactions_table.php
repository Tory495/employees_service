<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee_transactions', function (Blueprint $table) {
            $table->boolean('is_paid')->default(false);
            $table->index('is_paid');
        });
    }

    public function down(): void
    {
        Schema::table('employee_transactions', function (Blueprint $table) {
            $table->dropIndex(['is_paid']);
            $table->dropColumn('is_paid');
        });
    }
};
