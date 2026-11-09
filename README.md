# Student Management System (BUC3131)

**Makerere University Business School (MUBS)**  
**Faculty of Computing and Informatics**  
**Course Name:** Advanced Web Application Development (BUC3131)  
**Academic Year:** 2026/2027  
**Year of Study:** III | **Semester:** I  

---

## 👥 Group Members & Task Allocation (Question Six - b)

| Member Name | Student No. / Reg No. | GitHub Account | Assigned Task / Coursework Focus | Feature Branch |
| :--- | :--- | :--- | :--- | :--- |
| **Denis Wawomola** (Lead) | `2400711902` / `24/U/1902/EVE` | [`@eldeno-pro`](https://github.com/eldeno-pro) | **Question 1**: Database Design, Migrations, Models, Eloquent Relationships (`hasMany`, `belongsTo`, `belongsToMany`) & Duplicate Prevention | `feature/database-relationships` |
| **Namwase Whitney** | `2400712101` / `24/U/2101/EVE` | [`@zwella256`](https://github.com/zwella256) | **Question 2**: Database Seeders, Sample User Accounts, Courses, Students, Registrations & Idempotency | `feature/seeders-and-sample-data` |
| **Muganga Anthony** | `2400712102` / `24/U/2102/DAY` | [`@Muganga9145`](https://github.com/Muganga9145) | **Question 3**: Authentication, Spatie Role & Permission Package, Middleware Protection & Authorization Policies | `feature/auth-and-roles` |
| **Nyaika Keith** | `2400712103` / `24/U/2103/EVE` | [`@K3ITHH-TECH`](https://github.com/K3ITHH-TECH) | **Questions 4 & 5**: Student & Course CRUD, Course Registration Logic, Reusable Blade Master Layout & Validation | `feature/student-management`, `feature/blade-layouts-and-views` |

---

## 🔐 Sample Login Credentials (Question Six - b)

> **Default Password for all accounts:** `password123`

| Role | Name | Email Address | Access & Capabilities |
| :--- | :--- | :--- | :--- |
| **Administrator** | System Administrator | `admin@mubs.ac.ug` | Full CRUD access to students, courses, registrations, and system access. |
| **Lecturer** | Bashir Mutebi | `bmutebi@mubs.ac.ug` | Views assigned courses (`BUC3131`, `BUC3134`) and list of registered students. |
| **Lecturer** | Joy Tiko | `jtiko@mubs.ac.ug` | Views assigned courses (`BUC3132`, `BUC3135`) and list of registered students. |
| **Lecturer** | Moshin Gyagenda | `mgyagenda@mubs.ac.ug` | Views assigned courses (`BUC3133`) and list of registered students. |
| **Student** | Denis Wawomola | `2400711902@mubs.ac.ug` | Views available courses, registers for course units, views own registrations. |
| **Student** | Namwase Whitney | `wnamwase@mubs.ac.ug` | Student portal, course registration, personal registration history. |
| **Student** | Muganga Anthony | `amuganga@mubs.ac.ug` | Student portal, course registration, personal registration history. |
| **Student** | Nyaika Keith | `knyaika@mubs.ac.ug` | Student portal, course registration, personal registration history. |

---

## 🛠️ System Architecture & Database Design (Question One)

### Database Relationships:
1. **`hasMany()`**:
   * `User (Lecturer)` $\rightarrow$ `hasMany(Course::class, 'lecturer_id')`
   * `Student` $\rightarrow$ `hasMany(CourseRegistration::class)`
   * `Course` $\rightarrow$ `hasMany(CourseRegistration::class)`
2. **`belongsTo()`**:
   * `Course` $\rightarrow$ `belongsTo(User::class, 'lecturer_id')`
   * `CourseRegistration` $\rightarrow$ `belongsTo(Student::class)`
   * `CourseRegistration` $\rightarrow$ `belongsTo(Course::class)`
   * `Student` $\rightarrow$ `belongsTo(User::class)`
3. **`belongsToMany()`**:
   * `Student` $\rightarrow$ `belongsToMany(Course::class, 'course_registrations')` (Direct access via `$student->courses`)
   * `Course` $\rightarrow$ `belongsToMany(Student::class, 'course_registrations')` (Direct access via `$course->students`)
4. **Duplicate Prevention (Question 1d & 4c)**:
   * Composite database unique index on `course_registrations(student_id, course_id)`.
   * Application-level pre-validation check inside `CourseRegistrationController::store()`.

---

## 💻 Installation & Database Setup (Question Six - a)

### 1. Prerequisites
* **PHP >= 8.2** with extensions: `pdo_sqlite`, `pdo_mysql`, `mbstring`, `fileinfo`, `curl`, `openssl`, `zip`.
* **Composer 2.x**
* **Git**

### 2. Setup Commands
```bash
# 1. Clone repository
git clone https://github.com/eldeno-pro/Student_Management_System.git
cd Student_Management_System

# 2. Install dependencies
composer install

# 3. Environment configuration
cp .env.example .env
php artisan key:generate

# 4. Run database migrations & seeders (includes roles, accounts, and sample data)
php artisan migrate --seed

# 5. Start the local server
php artisan serve
```
The application will be accessible at: `http://localhost:8000`

---

## 🌿 Git Collaboration & Pull Request Strategy

This project strictly followed the Git workflow mandated by the examination board:
* **`main`**: Production-ready, stable releases.
* **`develop`**: Central integration branch where all feature PRs were tested and merged.
* **Feature Branches**:
  * `feature/database-relationships` (PR #1): Authored by **Denis Wawomola**
  * `feature/seeders-and-sample-data` (PR #2): Authored by **Namwase Whitney**
  * `feature/auth-and-roles` (PR #3): Authored by **Muganga Anthony**
  * `feature/student-management` (PR #4): Authored by **Nyaika Keith**
  * `feature/documentation` (PR #5): Collaborative documentation & final reports

---

## 🧪 Automated Test Verification

Run the full automated test suite covering all 6 coursework questions:
```bash
php artisan test
```
All 13 automated feature tests verify:
* Database relationships and Eloquent query retrieval
* Idempotent seeders with duplicate prevention
* Authentication, Spatie role middleware, and access control policies
* Student CRUD, Course CRUD, and registration duplicate rejection
* Blade layout navigation visibility by role
