{{--<div>--}}
{{--    --}}{{----}}{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
{{--    <!-- Role Management Modal -->--}}
{{--    --}}
{{--</div>--}}

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl transform transition-all">
    <div class="px-6 py-4">
        <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Create New Role') }}
        </div>

        <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            <div class="relative z-0 mt-1 space-y-2.5 rounded-lg cursor-pointer">

                <!-- Role Name -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model="form.name" />
                    <x-input-error for="form.name" class="mt-2" />
                </div>

                <!-- Role Description -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="description" value="{{ __('Description') }}" />
                    <x-input id="description" type="text" class="mt-1 block w-full" wire:model="form.description" />
                    <x-input-error for="form.description" class="mt-2" />
                </div>

                <!-- Team -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="team" value="{{ __('Team') }}" />
                    <x-searchable-dropdown id="team" class="" align="left" width="full" dropdownClasses="mt-1 block">
                        <x-slot name="trigger">
                                <span class="inline-flex rounded-md w-full">
                                    <x-input id="searchTeam" type="text" class="mt-1 block w-full" wire:model.live="searchTeam" />
                                </span>
                        </x-slot>

                        <x-slot name="content">
                            <div>
                                @if($searchResults->isNotEmpty())
                                    @foreach($searchResults as $result)
                                        <x-dropdown-link wire:click="setTeam({{$result}})">
                                            {{ $result->name }}
                                        </x-dropdown-link>
                                    @endforeach
                                @endif
                            </div>
                        </x-slot>
                    </x-searchable-dropdown>
                    <x-input-error for="form.teamId" class="mt-2" />
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 dark:bg-gray-800 text-end">
        <x-secondary-button wire:click="$dispatch('closeModal')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-secondary-button>

        <x-button class="ms-3" wire:click="createRole" wire:loading.attr="disabled">
            {{ __('Submit') }}
        </x-button>
    </div>
</div>
{{--</div>--}}
