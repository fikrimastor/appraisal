<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Jetstream\Membership as JetstreamMembership;
use Spatie\Permission\Traits\HasRoles;

class Membership extends JetstreamMembership
{
    use HasRoles, SoftDeletes;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public function memberRole(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role', 'uuid');
    }
}
