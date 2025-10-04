<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['Admin', 'Manager', 'Employee'])->default('Employee')->after('password');
            $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null')->after('role');
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade')->after('manager_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropForeign(['company_id']);
            $table->dropColumn(['role', 'manager_id', 'company_id']);
        });
    }
};
