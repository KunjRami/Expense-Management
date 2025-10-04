<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use App\Models\Expense;
use App\Models\Approval;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a company
        $company = Company::create([
            'name' => 'Demo Corporation',
            'currency' => 'USD',
        ]);

        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@demo.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
            'company_id' => $company->id,
        ]);

        // Create Managers
        $manager1 = User::create([
            'name' => 'John Manager',
            'email' => 'manager1@demo.com',
            'password' => Hash::make('password'),
            'role' => 'Manager',
            'company_id' => $company->id,
        ]);

        $manager2 = User::create([
            'name' => 'Sarah Manager',
            'email' => 'manager2@demo.com',
            'password' => Hash::make('password'),
            'role' => 'Manager',
            'company_id' => $company->id,
        ]);

        // Create Employees
        $employee1 = User::create([
            'name' => 'Alice Employee',
            'email' => 'employee1@demo.com',
            'password' => Hash::make('password'),
            'role' => 'Employee',
            'manager_id' => $manager1->id,
            'company_id' => $company->id,
        ]);

        $employee2 = User::create([
            'name' => 'Bob Employee',
            'email' => 'employee2@demo.com',
            'password' => Hash::make('password'),
            'role' => 'Employee',
            'manager_id' => $manager1->id,
            'company_id' => $company->id,
        ]);

        $employee3 = User::create([
            'name' => 'Charlie Employee',
            'email' => 'employee3@demo.com',
            'password' => Hash::make('password'),
            'role' => 'Employee',
            'manager_id' => $manager2->id,
            'company_id' => $company->id,
        ]);

        // Create some expenses
        $expense1 = Expense::create([
            'user_id' => $employee1->id,
            'amount' => 250.00,
            'currency' => 'USD',
            'converted_amount' => 250.00,
            'category' => 'Travel',
            'description' => 'Flight to client meeting',
            'expense_date' => now()->subDays(2),
            'status' => 'Pending',
        ]);

        Approval::create([
            'expense_id' => $expense1->id,
            'approver_id' => $manager1->id,
            'sequence' => 1,
            'is_manager_approver' => true,
            'status' => 'Pending',
        ]);

        $expense2 = Expense::create([
            'user_id' => $employee1->id,
            'amount' => 75.50,
            'currency' => 'USD',
            'converted_amount' => 75.50,
            'category' => 'Food',
            'description' => 'Team lunch',
            'expense_date' => now()->subDays(5),
            'status' => 'Approved',
        ]);

        Approval::create([
            'expense_id' => $expense2->id,
            'approver_id' => $manager1->id,
            'sequence' => 1,
            'is_manager_approver' => true,
            'status' => 'Approved',
            'comments' => 'Approved - valid expense',
        ]);

        $expense3 = Expense::create([
            'user_id' => $employee2->id,
            'amount' => 150.00,
            'currency' => 'USD',
            'converted_amount' => 150.00,
            'category' => 'Office Supplies',
            'description' => 'New laptop accessories',
            'expense_date' => now()->subDays(1),
            'status' => 'Rejected',
        ]);

        Approval::create([
            'expense_id' => $expense3->id,
            'approver_id' => $manager1->id,
            'sequence' => 1,
            'is_manager_approver' => true,
            'status' => 'Rejected',
            'comments' => 'Please get pre-approval for equipment purchases',
        ]);

        $expense4 = Expense::create([
            'user_id' => $employee3->id,
            'amount' => 500.00,
            'currency' => 'USD',
            'converted_amount' => 500.00,
            'category' => 'Accommodation',
            'description' => 'Hotel stay for conference',
            'expense_date' => now()->subDays(3),
            'status' => 'Pending',
        ]);

        Approval::create([
            'expense_id' => $expense4->id,
            'approver_id' => $manager2->id,
            'sequence' => 1,
            'is_manager_approver' => true,
            'status' => 'Pending',
        ]);

        $this->command->info('Demo data created successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@demo.com / password');
        $this->command->info('Manager1: manager1@demo.com / password');
        $this->command->info('Manager2: manager2@demo.com / password');
        $this->command->info('Employee1: employee1@demo.com / password');
    }
}
