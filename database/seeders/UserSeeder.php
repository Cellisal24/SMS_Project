<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ParentModel;
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Default admin account — change the password after first login
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'password_hash' => Hash::make('Admin@12345'),
                'role' => 'admin',
            ]
        );
           // --- Teachers ---
        // Links a login to every existing teacher record.
        // Username pattern: firstname initial + lastname, lowercase (e.g. "jsmith")
        Teacher::all()->each(function (Teacher $teacher) {
            $username = strtolower(substr($teacher->first_name, 0, 1) . $teacher->last_name);
            $username = preg_replace('/[^a-z0-9]/', '', $username); // strip spaces/punctuation

            User::firstOrCreate(
                ['teacher_id' => $teacher->teacher_id],
                [
                    'username' => $username,
                    'password_hash' => Hash::make('Teacher@123'),
                    'role' => 'teacher',
                ]
            );
        });

        // --- Students ---
        // Username pattern: student_id lowercased (simple + guaranteed unique)
        Student::all()->each(function (Student $student) {
            User::firstOrCreate(
                ['student_id' => $student->student_id],
                [
                    'username' => strtolower($student->student_id),
                    'password_hash' => Hash::make('Student@123'),
                    'role' => 'student',
                ]
            );
        });

        // --- Parents ---
        // Username pattern: parent_id lowercased (same convention as students)
        ParentModel::all()->each(function (ParentModel $parent) {
            User::firstOrCreate(
                ['parent_id' => $parent->parent_id],
                [
                    'username' => strtolower($parent->parent_id),
                    'password_hash' => Hash::make('Parent@123'),
                    'role' => 'parent',
                ]
            );
        });
    }
}