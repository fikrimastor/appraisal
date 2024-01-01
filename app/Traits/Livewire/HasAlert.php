<?php

namespace App\Traits\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;

trait HasAlert
{
    use LivewireAlert;

    public function onSuccess(string $message, string|null $onDismissed = null): void
    {
        $this->alert('success', $message, [
            'showConfirmButton' => false,
            'timer' => 3000,
            'toast' => true,
            'position' => 'top-end',
            'text' => '',
            'showCancelButton' => false,
            'showCloseButton' => false,
            'icon' => 'success',
            'onDismissed' => $onDismissed,
        ]);
    }
    
    public function onSuccessRedirectTo(string $message, string $route): void
    {
        $this->alert('success', $message, [
            'showConfirmButton' => false,
            'timer' => 3000,
            'toast' => true,
            'position' => 'top-end',
            'text' => '',
            'showCancelButton' => false,
            'showCloseButton' => false,
            'icon' => 'success',
            'onDismissed' => to_route($route),
        ]);
    }
}
