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
                            <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600 {{ $index > 0 ? 'border-t border-gray-200 dark:border-gray-700 focus:border-none rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}">
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
</div>
