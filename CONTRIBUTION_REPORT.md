# GROUP CONTRIBUTION REPORT

**MAKERERE UNIVERSITY BUSINESS SCHOOL (MUBS)**  
**DEPARTMENT OF BUSINESS COMPUTING**  
**COURSEWORK TWO: ADVANCED WEB APPLICATION DEVELOPMENT (BUC3131)**  
**ACADEMIC YEAR:** 2026/2027  

**PROJECT:** STUDENT MANAGEMENT SYSTEM  
**REPOSITORY URL:** https://github.com/eldeno-pro/Student_Management_System  

---

## 1. Group Members & Task Allocation Summary

| # | Student Name | Student No. | Registration No. | GitHub Username | Assigned Coursework Section | Feature Branch | Pull Request |
| :- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | **Denis Wawomola** (Lead) | 2400711902 | 24/U/1902/EVE | `@eldeno-pro` | **Question 1**: Database Design, Migrations & Eloquent Relationships | `feature/database-relationships` | PR #1 $\rightarrow$ `develop` |
| 2 | **Namwase Whitney** | 2400712101 | 24/U/2101/EVE | `@zwella256` | **Question 2**: Database Seeders & Sample Data | `feature/seeders-and-sample-data` | PR #2 $\rightarrow$ `develop` |
| 3 | **Muganga Anthony** | 2400712102 | 24/U/2102/DAY | `@Muganga9145` | **Question 3**: Authentication, Roles, Permissions & Middleware | `feature/auth-and-roles` | PR #3 $\rightarrow$ `develop` |
| 4 | **Nyaika Keith** | 2400712103 | 24/U/2103/EVE | `@K3ITHH-TECH` | **Questions 4 & 5**: CRUD Functionality, Blade Layouts & Form Validation | `feature/student-management` | PR #4 $\rightarrow$ `develop` |

---

## 2. Detailed Member Contributions & Technical Breakdown

### Member 1: Denis Wawomola (`@eldeno-pro`)
* **Branch:** `feature/database-relationships`
* **Contributions**:
  * Designed and authored database migrations for `students`, `courses`, and `course_registrations`.
  * Configured foreign key cascades and composite unique constraint `unique(['student_id', 'course_id'])` to prevent duplicate course registrations.
  * Implemented Eloquent relationships:
    * `User -> hasMany(Course)` (Lecturer courses)
    * `Student -> hasMany(CourseRegistration)`
    * `Course -> hasMany(CourseRegistration)`
    * `Course -> belongsTo(User, 'lecturer_id')`
    * `CourseRegistration -> belongsTo(Student)` & `belongsTo(Course)`
    * `Student -> belongsToMany(Course)` & `Course -> belongsToMany(Student)`
  * Wrote automated test suite: `tests/Feature/DatabaseRelationshipsTest.php`.

### Member 2: Namwase Whitney (`@zwella256`)
* **Branch:** `feature/seeders-and-sample-data`
* **Contributions**:
  * Created `RoleAndPermissionSeeder` defining roles (`admin`, `lecturer`, `student`) and permissions.
  * Created `UserSeeder` with sample user accounts across all 3 roles using bcrypt hashing and `firstOrCreate` for idempotency.
  * Created `CourseSeeder` populating 5 MUBS BBC courses with assigned lecturers.
  * Created `StudentSeeder` populating 6 student profiles linked to their user accounts.
  * Created `CourseRegistrationSeeder` populating sample registrations.
  * Ensured complete idempotency so running `db:seed` multiple times never crashes or duplicates records.
  * Wrote automated test suite: `tests/Feature/SeedersAndSampleDataTest.php`.

### Member 3: Muganga Anthony (`@Muganga9145`)
* **Branch:** `feature/auth-and-roles`
* **Contributions**:
  * Configured `spatie/laravel-permission` package and published configuration and tables.
  * Added `HasRoles` trait to the `User` model.
  * Created `AuthController` supporting login with credential validation, remember me, session regeneration, role-scoped redirects, and logout.
  * Configured route middleware protection using `role:admin`, `role:lecturer`, and `role:student`.
  * Created authorization policies (`StudentPolicy` and `CourseRegistrationPolicy`) preventing unauthorized access to other users' records.
  * Wrote automated test suite: `tests/Feature/AuthenticationAndRolesTest.php`.

### Member 4: Nyaika Keith (`@K3ITHH-TECH`)
* **Branch:** `feature/student-management`
* **Contributions**:
  * Developed `StudentController` with full CRUD operations and role-filtered access.
  * Developed `CourseController` with full CRUD operations and lecturer assignment.
  * Developed `CourseRegistrationController` with pre-validation duplicate checks and drop functionality.
  * Designed master Blade layout `layouts/app.blade.php` with responsive navigation, dynamic user badge, flash alerts, and MUBS footer.
  * Built all Blade views for students, courses, registrations, and role dashboards.
  * Implemented form request validations with inline `@error` alerts.
  * Wrote automated test suite: `tests/Feature/ApplicationFunctionalityAndViewsTest.php`.

---

## 3. Individual Presentation Preparation Guide (10 Marks)

| Criterion | Marks | Preparation & Key Talking Points |
| :--- | :---: | :--- |
| **Demonstration of application features** | 3 | Demonstrate logging in as Admin (CRUD on students/courses), Lecturer (viewing assigned courses and class lists), and Student (viewing catalog, enrolling, and duplicate rejection). |
| **Explanation of database relationships** | 3 | Explain Eloquent pivot tables, `belongsToMany` between Students and Courses, `hasMany` between Lecturer and Courses, and composite unique keys. |
| **Explanation of auth, roles and permissions** | 2 | Explain Spatie permission integration, role assignment during seeding, route middleware aliases in `bootstrap/app.php`, and policy checks. |
| **Technical questions & code understanding** | 2 | Explain MVC architecture, CSRF protection, Eloquent eager loading (`withCount`, `with`), form request validation, and test automation. |

