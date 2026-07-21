<?php

namespace App\Models\Concerns;

trait HasParentLinks
{
    protected static function bootHasParentLinks()
    {
        static::creating(function ($student) {
            if (empty($student->student_id)) {
                $student->student_id = static::generateNextId();
            }
        });
    }

    public static function generateNextId(): string
    {
        $last = self::orderByDesc('student_id')->first();
        $next = $last ? ((int) substr($last->student_id, 3)) + 1 : 1;

        return 'STU' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function parents()
    {
        return $this->belongsToMany(\App\Models\ParentModel::class, 'student_parents', 'student_id', 'parent_id')
            ->withPivot('relationship', 'is_primary')
            ->withTimestamps();
    }

    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}