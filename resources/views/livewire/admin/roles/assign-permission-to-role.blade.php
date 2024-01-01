<div>
    {{-- Be like water. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("Manage Role {$role->name} Permissions") }}
        </h2>
    </x-slot>

{{--    <div>--}}
{{--        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">--}}

{{--        </div>--}}
{{--    </div>--}}

    @dump($this->rolePermissions, $this->permissions, $this->form->permissionForRole)
    <div class="py-12">
        <div class="max-w-11xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="border-b border-gray-200 p-6">
                    <div class="align-items-center flex">
                        <a class="align-items-center flex rounded-xl border bg-blue-100 px-4 py-1 hover:underline"
                           href="{{ route('admin.roles.list') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-6 w-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                            </svg>
                            {{ __('Back To Assign User To Roles') }}
                        </a>
                    </div>

                    <div>
                        <div class="mt-4 mb-2 border-b-2">
                            <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                                {{ __('Existing Permission') }}
                            </h4>
                            <small>
                                {{ __('Please select the permission and click save.') }}
                            </small>
                        </div>

                        <div class="my-4 flex items-center">
                            <input id="select-all-permissions" type="checkbox" wire:model.live="selectAll"
                                   class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                            <label for="select-all-permissions"
                                   class="text-gray-800 dark:text-gray-200 ml-2 text-sm font-normal">{{ __('Select All') }}</label>
                        </div>

                        <form wire:submit.prevent="assignPermission">
                            <div class="my-4">
                                <p class="text-md font-medium text-gray-800 dark:text-gray-200">
                                    {{ __('Team') }}
                                </p>

                                <div class="grid grid-cols-1 gap-2 pt-5 md:grid-cols-4 md:gap-5">
                                    @foreach ($this->permissions as $permission)
                                        @if (str_contains($permission['name'], 'teams.'))
                                            <div class="flex items-center">
                                                <div class="flex items-center justify-between">
                                                    <div class="mb-2 flex items-center">
                                                        <input id="permission-checkbox-{{ $permission->id }}"
                                                               wire:key="permissionForRole_{{ $permission->id }}"
                                                               wire:model.live="form.permissionForRole"
                                                               type="checkbox"
                                                               @if($this->role->permissions->contains('id', $permission->id)) checked @endif
                                                               value="{{ $permission->id }}"
                                                               class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                                                        <label for="permission-checkbox-{{ $permission->id }}"
                                                               class="text-gray-800 dark:text-gray-200 ml-2 text-sm font-medium">{{ $permission->name }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <br />

                            <x-action-message class="mr-3" on="saved">
                                {{ __('Saved.') }}
                            </x-action-message>

                            <x-button wire:loading.attr="disabled" wire:target="assignPermission">
                                {{ __('Save') }}
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
