<?php

namespace App\Traits\Livewire;

trait AuthTrait
{
    public function getUserProperty()
    {
        return auth()->user();
    }
}
