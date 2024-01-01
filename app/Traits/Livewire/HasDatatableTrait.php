<?php

namespace App\Traits\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;

trait HasDatatableTrait
{
    use LivewireAlert;

    public function initializeHasDatatableTrait()
    {
        $this->listeners = array_merge($this->listeners, [
            'confirmedDelete',
        ]);
    }

    public function deleteRow($id): void
    {
        $this->alert('warning', 'Confirm to delete?', [
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'cancelButtonText' => 'No',
            'confirmButtonText' => 'Yes',
            'timer' => null,
            'toast' => false,
            'position' => 'center',
            'onConfirmed' => 'confirmedDelete',
            'data' => compact('id'),
        ]);
    }

    public function confirmedDelete($data)
    {
        // Do something
    }
}
