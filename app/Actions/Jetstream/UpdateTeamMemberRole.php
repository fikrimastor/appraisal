<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Events\TeamMemberUpdated;
use Laravel\Jetstream\Jetstream;

class UpdateTeamMemberRole
{
    /**
     * Update the role for the given team member.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  int  $teamMemberId
     * @param  string  $role
     * @return void
     */
    public function update($user, $team, $teamMemberId, string $role)
    {
        Gate::forUser($user)->authorize('updateTeamMember', $team);

        Validator::make([
            'role' => $role,
        ], [
            'role' => $team->roles->isNotEmpty()
                ? ['required', 'string', Rule::exists('roles', 'uuid')]
                : null,
        ])->validate();

        $team->users()->updateExistingPivot($teamMemberId, [
            'role' => $role,
        ]);

        TeamMemberUpdated::dispatch($team->fresh(), Jetstream::findUserByIdOrFail($teamMemberId));
    }
}
