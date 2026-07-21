<?php

namespace App\Models\Concerns;

trait HasStudentLinks
{
    protected static function bootHasStudentLinks()
    {
        static::creating(function ($parent) {
            if (empty($parent->parent_id)) {
                $parent->parent_id = static::generateNextId();
            }
        });
    }

    public static function generateNextId(): string
    {
        $last = self::orderByDesc('parent_id')->first();
        $next = $last ? ((int) substr($last->parent_id, 3)) + 1 : 1;

        return 'PAR' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function students()
    {
        return $this->belongsToMany(\App\Models\Student::class, 'student_parents', 'parent_id', 'student_id')
            ->withPivot('relationship', 'is_primary')
            ->withTimestamps();
    }

    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}