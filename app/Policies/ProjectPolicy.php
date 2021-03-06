<?php

namespace App\Policies;

use App\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ProjectPolicy
 * @package App\Policies
 */
class ProjectPolicy
{
    use HandlesAuthorization;


    /**
     * @param User $user
     * @param Project $project
     * @return mixed
     */
    public function manage(User $user, Project $project)
    {
        return $user->is($project->owner);
    }

    /**
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function update(User $user, Project $project)
    {
        return $user->is($project->owner) || $project->members->contains($user);
    }
}
