# Expense Management System

A comprehensive Laravel-based Expense Management System with multi-level approval workflows, role-based access control, and expense tracking.

## Features

### User Roles
- **Admin**: Full system access, user management, company settings, approval rules configuration
- **Manager**: Approve/reject expenses, view team expenses, manage direct reports
- **Employee**: Submit expenses, upload receipts, track expense status

### Core Functionality

#### For Employees
- Submit expense claims with details (amount, category, date, description)
- Upload receipt attachments (JPG, PNG, PDF)
- Track expense status (Pending, Approved, Rejected)
- View approval history with manager comments
- Personal dashboard with expense statistics

#### For Managers
- Review pending expense approvals
- Approve or reject expenses with comments
- View team expense history
- Dashboard with approval statistics
- Access to approval history

#### For Admins
- Company-wide expense dashboard with statistics
- User management (Create, Edit, Delete users)
- Assign roles and managers to users
- Configure company settings (name, default currency)
- Setup approval rules (percentage-based, specific approver, or hybrid)
- View all company expenses

### Additional Features
- Multi-currency support with company default currency
- Expense categorization (Travel, Food, Accommodation, Office Supplies, Equipment, Other)
- Role-based navigation and access control
- Responsive design with Tailwind CSS
- Approval workflow with comments system

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- SQLite/MySQL/PostgreSQL database

### Setup Instructions

1. **Clone the repository**
```bash
git clone https://github.com/KunjRami/Expense-Management.git
cd Expense-Management
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node dependencies**
```bash
npm install
```

4. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database**
Edit `.env` file and set your database credentials. For SQLite (default):
```
DB_CONNECTION=sqlite
```

For MySQL:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expense_management
DB_USERNAME=root
DB_PASSWORD=
```

6. **Run migrations**
```bash
php artisan migrate
```

7. **Create storage symlink**
```bash
php artisan storage:link
```

8. **Seed demo data (optional)**
```bash
php artisan db:seed --class=DemoDataSeeder
```

9. **Build assets**
```bash
npm run build
```

10. **Start development server**
```bash
php artisan serve
```

Visit http://localhost:8000 in your browser.

## Demo Credentials

After seeding demo data, you can use these credentials:

- **Admin**: admin@demo.com / password
- **Manager 1**: manager1@demo.com / password
- **Manager 2**: manager2@demo.com / password
- **Employee 1**: employee1@demo.com / password
- **Employee 2**: employee2@demo.com / password
- **Employee 3**: employee3@demo.com / password

## Usage Guide

### First Time Setup

1. **Register as Admin**: Visit `/register` and create your account with company name
2. **Add Users**: Navigate to "Users" in the admin panel to add managers and employees
3. **Assign Managers**: When creating employees, assign them to their respective managers
4. **Configure Approval Rules** (Optional): Set up percentage-based or specific approver rules

### Submitting an Expense (Employee)

1. Log in with employee credentials
2. Click "Submit New Expense" or navigate to Expenses → Create
3. Fill in expense details:
   - Expense Date
   - Category
   - Amount and Currency
   - Description
   - Upload Receipt (optional)
4. Submit the expense for approval

### Approving Expenses (Manager)

1. Log in with manager credentials
2. View pending approvals on the dashboard or navigate to "Approvals"
3. Review expense details and receipt
4. Click "Approve" or "Reject" with optional comments
5. View approval history in the "Approval History" section

### Managing Users (Admin)

1. Log in with admin credentials
2. Navigate to "Users"
3. Click "Add New User" to create users
4. Edit users to change roles or assign managers
5. Delete users as needed (cannot delete yourself)

### Company Settings (Admin)

1. Navigate to "Company" in the admin panel
2. Update company name
3. Set default currency (3-letter code, e.g., USD, EUR, GBP)

## Database Schema

### Companies
- id, name, currency, timestamps

### Users
- id, name, email, password, role, manager_id, company_id, timestamps

### Expenses
- id, user_id, amount, currency, converted_amount, category, description, expense_date, status, receipt_path, timestamps

### Approvals
- id, expense_id, approver_id, sequence, is_manager_approver, status, comments, timestamps

### Approval Rules
- id, company_id, rule_type, percentage, specific_user_id, timestamps

## Technology Stack

- **Framework**: Laravel 12
- **Authentication**: Laravel Breeze
- **Permissions**: Spatie Laravel Permission
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Database**: SQLite/MySQL/PostgreSQL
- **File Storage**: Laravel File Storage

## Roadmap

Future enhancements planned:
- Currency conversion API integration (real-time exchange rates)
- OCR receipt processing for automatic data extraction
- Advanced multi-level approval workflows
- Email notifications for expense status changes
- Reports and analytics with charts
- PDF/Excel export functionality
- Bulk expense operations
- Mobile-responsive improvements
- API for mobile app integration

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues and questions, please open an issue on the GitHub repository.

