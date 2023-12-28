<?php

namespace App\Livewire\Teams;

use App\Livewire\Forms\Teams\AddTeamMemberForm;
use App\Models\TeamInvitation;
use App\Models\User;
use App\Traits\Livewire\AuthTrait;
use App\Traits\Livewire\TeamsTrait;
use Illuminate\Validation\ValidationException;
use App\Actions\Jetstream\UpdateTeamMemberRole;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class TeamMemberManagement extends Component
{
    use TeamsTrait, AuthTrait;

    public AddTeamMemberForm $addTeamMemberForm;
    /**
     * @var true
     */
    public bool $currentlyManagingRole = false;
    public $managingRoleFor;
    public $currentRole;
    /**
     * @var false
     */
    public bool $confirmingLeavingTeam = false;
    public bool $confirmingTeamMemberRemoval;
    public ?int $teamMemberIdBeingRemoved;

    public function getListeners()
    {
        return [
            'roleAdded' => '$refresh',
        ];
    }

    /**
     * @throws ValidationException
     */
    public function addTeamMember()
    {
        $this->resetErrorBag();
        $validated = $this->addTeamMemberForm->submit();

        if (Features::sendsTeamInvitations()) {
            app(InvitesTeamMembers::class)->invite(
                $this->user,
                $this->team,
                $validated['email'],
                $validated['role']
            );
        } else {
            app(AddsTeamMembers::class)->add(
                $this->user,
                $this->team,
                $validated['email'],
                $validated['role']
            );
        }

        $this->team = $this->team->fresh();

        $this->dispatch('teamMemberInvited');
    }

    /**
     * Cancel a pending team member invitation.
     *
     * @param  int  $invitationId
     * @return void
     */
    public function cancelTeamInvitation($invitationId)
    {
        if (! empty($invitationId)) {
            TeamInvitation::whereKey($invitationId)?->delete();
        }

        $this->team = $this->team->fresh();
    }

    /**
     * Allow the given user's role to be managed.
     *
     * @param  int  $userId
     * @return void
     */
    public function manageRole($userId)
    {
        $this->currentlyManagingRole = true;
        $this->managingRoleFor = User::findOrFail($userId);
        $this->currentRole = $this->managingRoleFor->teamRole($this->team)->uuid;
    }

    /**
     * Save the role for the user being managed.
     *
     * @param  \App\Actions\Jetstream\UpdateTeamMemberRole  $updater
     * @return void
     */
    public function updateRole(UpdateTeamMemberRole $updater)
    {
        $updater->update(
            $this->user,
            $this->team,
            $this->managingRoleFor->id,
            $this->currentRole
        );

        $this->team = $this->team->fresh();

        $this->stopManagingRole();
    }

    /**
     * Stop managing the role of a given user.
     *
     * @return void
     */
    public function stopManagingRole()
    {
        $this->currentlyManagingRole = false;
    }

    /**
     * Remove the currently authenticated user from the team.
     *
     * @param  \Laravel\Jetstream\Contracts\RemovesTeamMembers  $remover
     * @return void
     */
    public function leaveTeam(RemovesTeamMembers $remover)
    {
        $remover->remove(
            $this->user,
            $this->team,
            $this->user
        );

        $this->confirmingLeavingTeam = false;

        $this->team = $this->team->fresh();

        return redirect(config('fortify.home'));
    }

    /**
     * Confirm that the given team member should be removed.
     *
     * @param  int  $userId
     * @return void
     */
    public function confirmTeamMemberRemoval($userId)
    {
        $this->confirmingTeamMemberRemoval = true;

        $this->teamMemberIdBeingRemoved = $userId;
    }

    /**
     * Remove a team member from the team.
     *
     * @param  \Laravel\Jetstream\Contracts\RemovesTeamMembers  $remover
     * @return void
     */
    public function removeTeamMember(RemovesTeamMembers $remover)
    {
        $user = Jetstream::findUserByIdOrFail($this->teamMemberIdBeingRemoved);

        $remover->remove(
            $this->user,
            $this->team,
            $user
        );

        $this->confirmingTeamMemberRemoval = false;

        $this->teamMemberIdBeingRemoved = null;

        $this->team = $this->team->fresh();
    }

    public function render()
    {
        return view('livewire.teams.team-member-management');
    }
}
