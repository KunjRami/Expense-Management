<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use App\Models\Expense;
use App\Models\Approval;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_can_submit_expense(): void
    {
        $company = Company::create([
            'name' => 'Test Company',
            'currency' => 'USD',
        ]);

        $manager = User::create([
            'name' => 'Test Manager',
            'email' => 'manager@test.com',
            'password' => bcrypt('password'),
            'role' => 'Manager',
            'company_id' => $company->id,
        ]);

        $employee = User::create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
            'role' => 'Employee',
            'manager_id' => $manager->id,
            'company_id' => $company->id,
        ]);

        $response = $this->actingAs($employee)->post(route('employee.expenses.store'), [
            'amount' => 100.00,
            'currency' => 'USD',
            'category' => 'Travel',
            'description' => 'Test expense',
            'expense_date' => now()->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('employee.expenses.index'));
        $this->assertDatabaseHas('expenses', [
            'user_id' => $employee->id,
            'amount' => 100.00,
            'category' => 'Travel',
            'status' => 'Pending',
        ]);
        $this->assertDatabaseHas('approvals', [
            'approver_id' => $manager->id,
            'status' => 'Pending',
        ]);
    }

    public function test_manager_can_approve_expense(): void
    {
        $company = Company::create([
            'name' => 'Test Company',
            'currency' => 'USD',
        ]);

        $manager = User::create([
            'name' => 'Test Manager',
            'email' => 'manager@test.com',
            'password' => bcrypt('password'),
            'role' => 'Manager',
            'company_id' => $company->id,
        ]);

        $employee = User::create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
            'role' => 'Employee',
            'manager_id' => $manager->id,
            'company_id' => $company->id,
        ]);

        $expense = Expense::create([
            'user_id' => $employee->id,
            'amount' => 100.00,
            'currency' => 'USD',
            'converted_amount' => 100.00,
            'category' => 'Travel',
            'description' => 'Test expense',
            'expense_date' => now(),
            'status' => 'Pending',
        ]);

        $approval = Approval::create([
            'expense_id' => $expense->id,
            'approver_id' => $manager->id,
            'sequence' => 1,
            'is_manager_approver' => true,
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($manager)->post(route('manager.approvals.approve', $approval), [
            'comments' => 'Approved',
        ]);

        $response->assertRedirect(route('manager.approvals.index'));
        $this->assertDatabaseHas('approvals', [
            'id' => $approval->id,
            'status' => 'Approved',
        ]);
        $this->assertDatabaseHas('expenses', [
            'id' => $expense->id,
            'status' => 'Approved',
        ]);
    }

    public function test_manager_can_reject_expense(): void
    {
        $company = Company::create([
            'name' => 'Test Company',
            'currency' => 'USD',
        ]);

        $manager = User::create([
            'name' => 'Test Manager',
            'email' => 'manager@test.com',
            'password' => bcrypt('password'),
            'role' => 'Manager',
            'company_id' => $company->id,
        ]);

        $employee = User::create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
            'role' => 'Employee',
            'manager_id' => $manager->id,
            'company_id' => $company->id,
        ]);

        $expense = Expense::create([
            'user_id' => $employee->id,
            'amount' => 100.00,
            'currency' => 'USD',
            'converted_amount' => 100.00,
            'category' => 'Travel',
            'description' => 'Test expense',
            'expense_date' => now(),
            'status' => 'Pending',
        ]);

        $approval = Approval::create([
            'expense_id' => $expense->id,
            'approver_id' => $manager->id,
            'sequence' => 1,
            'is_manager_approver' => true,
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($manager)->post(route('manager.approvals.reject', $approval), [
            'comments' => 'Not approved - missing receipt',
        ]);

        $response->assertRedirect(route('manager.approvals.index'));
        $this->assertDatabaseHas('approvals', [
            'id' => $approval->id,
            'status' => 'Rejected',
            'comments' => 'Not approved - missing receipt',
        ]);
        $this->assertDatabaseHas('expenses', [
            'id' => $expense->id,
            'status' => 'Rejected',
        ]);
    }

    public function test_admin_can_manage_users(): void
    {
        $company = Company::create([
            'name' => 'Test Company',
            'currency' => 'USD',
        ]);

        $admin = User::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
            'company_id' => $company->id,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'New User',
            'email' => 'newuser@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'Employee',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@test.com',
            'role' => 'Employee',
            'company_id' => $company->id,
        ]);
    }
}
