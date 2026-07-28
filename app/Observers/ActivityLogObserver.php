<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ActivityLogObserver
{
    public function created(Model $model): void
    {
        $this->log('create', $model, null, $model->getAttributes());
    }

    public function updating(Model $model): void
    {
        $dirty = $model->getDirty();

        if (empty($dirty)) {
            return;
        }

        $old = array_intersect_key($model->getOriginal(), $dirty);

        $this->log('update', $model, $old, $dirty);
    }

    public function deleted(Model $model): void
    {
        $this->log('delete', $model, $model->getAttributes(), null);
    }

    private function log(string $action, Model $model, ?array $old, ?array $new): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'table_name' => $model->getTable(),
            'record_id' => (string) $model->getKey(),
            'old_value' => $old,
            'new_value' => $new,
            'created_at' => now(),
        ]);
    }
}