<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("Role Management") }}
        </h2>
    </x-slot>

    <div>
        <div class="relative max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-3">
{{--            <div class="inset-y-0 right-0">--}}
{{--                --}}
{{--            </div>--}}
{{--            <div>--}}
{{--                --}}
{{--            </div>--}}
            <x-button
                class="absolute top-0 right-0"
                type="button"
                wire:click="createRole"
                {{--                    wire:click="{{ route('admin.roles.create') }}"--}}
            >
                {{ __('Create Role') }}
            </x-button>

            <livewire:admin.roles.roles-table class="absolute" />
        </div>
    </div>
</div>
