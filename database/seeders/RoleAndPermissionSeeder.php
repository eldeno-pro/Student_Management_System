<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Define permissions
        $permissions = [
            'manage-students',
            'manage-courses',
            'manage-registrations',
            'view-courses',
            'view-assigned-courses',
            'register-courses',
            'view-own-registrations',
            'manage-users',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(
                ['name' => $permissionName, 'guard_name' => 'web']
            );
        }

        // 2. Define roles and sync permissions
        // Role: Administrator (Manages students, courses, registrations, and user access)
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        // Role: Lecturer (Views assigned courses and their registered students)
        $lecturerRole = Role::firstOrCreate(['name' => 'lecturer', 'guard_name' => 'web']);
        $lecturerRole->syncPermissions([
            'view-courses',
            'view-assigned-courses',
        ]);

        // Role: Student (Views available courses and their own registrations)
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $studentRole->syncPermissions([
            'view-courses',
            'register-courses',
            'view-own-registrations',
        ]);
    }
}
