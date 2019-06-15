<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Arr;

trait RecordsActivity
{
    /**
     * The model old attributes
     * @var array
     */
    public $oldAttributes = [];

    /**
     * Boot the trait
     */
    public static function bootRecordsActivity()
    {
        $recordableEvents = self::recordableEvents();

        foreach($recordableEvents as $event) {
            static::$event(function($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if($event === 'updated') {
                static::updating(function($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    /**
     * @param $event
     * @return string
     */
    protected function activityDescription($event): string
    {
        return "{$event}_" . strtolower(class_basename($this));
    }

    /**
     * @return array
     */
    public static function recordableEvents()
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        } else {
            return ['created', 'updated'];
        }
    }

    /**
     * @return MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /**
     * @param string $description
     */
    public function recordActivity($description = '')
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project->id,
            'user_id' => ($this->project ?? $this)->owner->id,
        ]);
    }

    /**
     * @return array
     */
    protected function activityChanges()
    {
        if($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at'),
            ];
        }
    }
}
