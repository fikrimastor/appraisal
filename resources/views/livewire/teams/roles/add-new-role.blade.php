<div>
    <x-section-border />
    <x-form-section submit="createNewRole">
        <x-slot name="title">
            {{ __('Role Name') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The role\'s name and description.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Role -->
            @if ($this->teamRoles->count() > 0)
                <div class="col-span-6 lg:col-span-4">
                    <x-label for="role" value="{{ __('Role') }}" />
                    <x-input-error for="role" class="mt-2" />

                    <div class="relative z-0 mt-1 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer">
                        @foreach ($this->teamRoles as $index => $role)
                            <button  wire:click="managePermissions('{{ $role->uuid }}')" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600 {{ $index > 0 ? 'border-t border-gray-200 dark:border-gray-700 focus:border-none rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}">
                                <div class="">
                                    <!-- Role Name -->
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-600 dark:text-gray-400 font-semibold">
                                            {{ $role->name }}
                                        </div>
                                    </div>

                                    <!-- Role Description -->
                                    <div class="mt-2 text-xs text-gray-600 dark:text-gray-400 text-start">
                                        {{ $role->description }}
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Role Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Role Name') }}" />

                <x-input id="name"
                         type="text"
                         class="mt-1 block w-full"
                         wire:model="form.name"
                         :disabled="! Gate::check('update', $team)" />

                <x-input-error for="name" class="mt-2" />
            </div>

            <!-- Role Description -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="description" value="{{ __('Role Description') }}" />

                <x-input id="description"
                         type="text"
                         class="mt-1 block w-full"
                         wire:model="form.description"
                         :disabled="! Gate::check('update', $team)" />

                <x-input-error for="description" class="mt-2" />
            </div>
        </x-slot>

        @if (Gate::check('update', $team))
            <x-slot name="actions">
                <x-action-message class="me-3" on="roleAdded">
                    {{ __('Added.') }}
                </x-action-message>

                <x-button>
                    {{ __('Save') }}
                </x-button>
            </x-slot>
        @endif
    </x-form-section>

    <!-- Permission Management Modal -->
    <x-dialog-modal wire:model.live="currentlyManagingPermission">
        <x-slot name="title">
            {{ __("Manage Permission for {$this->role?->name}") }}
        </x-slot>

        <x-slot name="content">
            <div class="relative z-0 mt-1 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer">
                @foreach ($this->teamRoles as $index => $role)
                    <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600 {{ $index > 0 ? 'border-t border-gray-200 dark:border-gray-700 focus:border-none rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                            wire:click="$set('currentRole', '{{ $role->uuid }}')">
                        <div class="
{{--                        {{ $currentRole !== $role->uuid ? 'opacity-50' : '' }}--}}
                        ">
                            <!-- Role Name -->
                            <div class="flex items-center">
                                <div class="text-sm text-gray-600 dark:text-gray-400
{{--                                {{ $currentRole == $role->uuid ? 'font-semibold' : '' }}--}}
                                ">
                                    {{ $role->name }}
                                </div>

{{--                                @if ($currentRole == $role->uuid)--}}
{{--                                    <svg class="ms-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">--}}
{{--                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />--}}
{{--                                    </svg>--}}
{{--                                @endif--}}
                            </div>

                            <!-- Role Description -->
                            <div class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                {{ $role->description }}
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="stopManagingPermissions" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ms-3" wire:click="updatePermissions" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
