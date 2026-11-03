# Student Management System (BUC3131)

**Makerere University Business School (MUBS)**  
**Course:** Advanced Web Application Development (BUC3131)  
**Academic Year:** 2026/2027  
**Year of Study:** III | **Semester:** I  

---

## 👥 Group Members & Task Allocation

| Member Name | GitHub Username | Assigned Task / Coursework Section | Feature Branch |
| :--- | :--- | :--- | :--- |
| **Denis Wawomola** (Lead) | [`@eldeno-pro`](https://github.com/eldeno-pro) | **Question 1**: Database Design, Migrations, Models & Eloquent Relationships | `feature/database-relationships` |
| **Namwase Whitney** | [`@zwella256`](https://github.com/zwella256) | **Question 2**: Seeders, Sample Data & Duplicate Prevention | `feature/seeders-and-sample-data` |
| **Muganga Anthony** | [`@Muganga9145`](https://github.com/Muganga9145) | **Question 3**: Authentication, Spatie Roles, Permissions & Middleware | `feature/auth-and-roles` |
| **Nyaika Keith** | [`@K3ITHH-TECH`](https://github.com/K3ITHH-TECH) | **Questions 4 & 5**: CRUD Controllers, Registration Logic & Blade Layouts | `feature/student-management`, `feature/course-and-registration`, `feature/blade-layouts-and-views` |

---

## 🌿 Git Collaboration & Branching Strategy

In compliance with the MUBS AWAD guidelines:
* **`main`**: Production-ready, stable releases.
* **`develop`**: Central integration branch for all tested feature pull requests.
* **Feature Branches**:
  * `feature/database-relationships`: Migrations, models, Eloquent `hasMany`, `belongsTo`, `belongsToMany`, unique composite indexes.
  * `feature/seeders-and-sample-data`: Idempotent seeders for students, courses, user accounts, and course registrations.
  * `feature/auth-and-roles`: Authentication setup, Spatie role-and-permission access control, and route middleware.
  * `feature/student-management`: Student CRUD operations and role-based access policies.
  * `feature/course-and-registration`: Course CRUD and course registration with duplicate prevention.
  * `feature/blade-layouts-and-views`: Responsive Blade master layout, navigation permissions, and form validation.
  * `feature/documentation`: Complete setup instructions, sample login credentials, and report.

---

## 🚀 Setup & Installation Instructions

### Prerequisites
* PHP >= 8.2 (with `pdo_sqlite`, `pdo_mysql`, `curl`, `mbstring`, `fileinfo` enabled)
* Composer 2.x
* Git

### Local Setup
```bash
# Clone the repository
git clone https://github.com/eldeno-pro/Student_Management_System.git
cd Student_Management_System

# Install PHP dependencies
composer install

# Environment configuration
cp .env.example .env
php artisan key:generate

# Run database migrations and seeders
php artisan migrate --seed

# Start the local development server
php artisan serve
```
