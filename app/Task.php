<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Task
 * @package App
 */
class Task extends Model
{
    use RecordsActivity;
    /**
     * @var array
     */
    protected $guarded = [];
    /**
     * @var array
     */
    protected $touches = ['project'];

    /**
     * @var array
     */
    protected $casts = [
        'completed' => 'boolean'
    ];

    protected static $recordableEvents = ['created', 'deleted'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return string
     */
    public function path()
    {
        return '/projects/' . $this->project->id . '/tasks/' . $this->id;
    }

    /**
     * @return $this
     */
    public function complete()
    {
        $this->update(['completed' => true]);
        $this->recordActivity('completed_task');

        return $this;
    }

    /**
     * @return $this
     */
    public function incomplete()
    {
        $this->update(['completed' => false]);
        $this->recordActivity('uncompleted_task');

        return $this;
    }
}
