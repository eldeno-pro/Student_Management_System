<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class AuthenticationAndRolesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Question 3a: Configure authentication - login form displays.
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Student Management System');
    }

    /**
     * Question 3a: Users can authenticate with valid credentials.
     */
    public function test_users_can_authenticate_and_redirect_based_on_role(): void
    {
        // 1. Admin login redirects to admin dashboard
        $response = $this->post('/login', [
            'email' => 'admin@mubs.ac.ug',
            'password' => 'password123',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));

        // 2. Logout
        $this->post('/logout');
        $this->assertGuest();

        // 3. Lecturer login redirects to lecturer dashboard
        $response = $this->post('/login', [
            'email' => 'bmutebi@mubs.ac.ug',
            'password' => 'password123',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(route('lecturer.dashboard'));
    }

    /**
     * Question 3a: Users cannot authenticate with invalid credentials.
     */
    public function test_users_cannot_authenticate_with_invalid_password(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@mubs.ac.ug',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /**
     * Question 3d: Protect routes using authentication and authorization middleware.
     */
    public function test_routes_are_protected_by_auth_and_role_middleware(): void
    {
        // Guest is redirected to login
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));

        // Student is denied access to admin dashboard (403 Forbidden)
        $studentUser = User::where('email', '2400711902@mubs.ac.ug')->first();
        $this->actingAs($studentUser)->get(route('admin.dashboard'))->assertStatus(403);

        // Lecturer is denied access to admin dashboard (403 Forbidden)
        $lecturerUser = User::where('email', 'bmutebi@mubs.ac.ug')->first();
        $this->actingAs($lecturerUser)->get(route('admin.dashboard'))->assertStatus(403);

        // Admin is granted access (200 OK)
        $adminUser = User::where('email', 'admin@mubs.ac.ug')->first();
        $this->actingAs($adminUser)->get(route('admin.dashboard'))->assertStatus(200);
    }

    /**
     * Question 3e: Prevent unauthorized access to other users' records.
     */
    public function test_students_cannot_access_other_students_records(): void
    {
        $studentUser1 = User::where('email', '2400711902@mubs.ac.ug')->first();
        $student1 = Student::where('email', '2400711902@mubs.ac.ug')->first();

        $studentUser2 = User::where('email', 'wnamwase@mubs.ac.ug')->first();
        $student2 = Student::where('email', 'wnamwase@mubs.ac.ug')->first();

        // Student 1 can view their own record
        $this->assertTrue(Gate::forUser($studentUser1)->allows('view', $student1));

        // Student 1 CANNOT view Student 2's record
        $this->assertFalse(Gate::forUser($studentUser1)->allows('view', $student2));

        // Admin CAN view any student's record
        $adminUser = User::where('email', 'admin@mubs.ac.ug')->first();
        $this->assertTrue(Gate::forUser($adminUser)->allows('view', $student2));
    }
}
