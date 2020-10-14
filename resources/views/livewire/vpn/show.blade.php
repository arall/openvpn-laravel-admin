<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('VPN Settings') }}
    </h2>
</x-slot>

<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Download Config Files') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Download the VPN config files for your client.') }}
                </x-slot>

                <x-slot name="content">
                    <x-jet-button wire:click="download">
                        {{ __('Download') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-action-section>

            <x-jet-section-border />

            <x-jet-form-section submit="updatePassword">
                <x-slot name="title">
                    {{ __('Update Password') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="password" value="{{ __('New Password') }}" />
                        <x-jet-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password" />
                        <x-jet-input-error for="password" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-jet-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
                        <x-jet-input-error for="password_confirmation" class="mt-2" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-jet-action-message class="mr-3" on="saved">
                        {{ __('Saved.') }}
                    </x-jet-action-message>

                    <x-jet-button>
                        {{ __('Save') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-form-section>
        </div>
    </div>
</div>