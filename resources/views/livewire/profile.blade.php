<div>
    <x-slot name="header">{{ __('Edit Profile') }}</x-slot>

    <form wire:submit.prevent="save"
          class="space-y-4"
    >

        <div>
            <x-label for="username" :value="__('Username')"/>

            <x-input id="username" class="block my-1 w-full" type="text" wire:model.debounce.500ms="user.username"/>

            <x-error error="user.username"/>

        </div>

        <div>
            <x-label for="email" :value="__('Email')"/>

            <x-input id="email" class="block my-1 w-full" type="text" wire:model.debounce.500ms="user.email"/>

            <x-error error="user.email"/>
        </div>

        <div>
            <x-label for="password" :value="__('Password')"/>

            <x-input id="password" class="block my-1 w-full" type="password" wire:model.lazy="password"/>

            <x-error error="password"/>
        </div>

        <div>
            <x-label for="password_confirmation" :value="__('Password Confirmation')"/>

            <x-input id="password_confirmation" class="block my-1 w-full" type="password" wire:model.lazy="password_confirmation"/>

            <x-error error="password_confirmation"/>
        </div>

        <div>
            <x-label for="upload" :value="__('Avatar')"/>

            <div class="mt-1 flex space-x-6 ">
                <!--
                Memo:
                Solved: Facade\Ignition\Exceptions\ViewException : This driver does not support creating temporary URLs.
                Use "$upload?->isPreviewable()" with if statement in blade views, or the file tests will fail with the message above. Only images has temporaryUrl() methods, which means only images is reviewable.
                -->
                <div>
                    <img class="h-24 w-24 rounded-full"
                         src="{{ $upload?->isPreviewable() ? $upload->temporaryUrl() : auth()->user()->avatar_url }}"
                         alt="avatar"
                    >
                </div>

                <div class="flex-1">
                    <x-filepond
                        wire:model="upload"
                        acceptedFileTypes="['image/jpeg','image/jpg','image/png']"
                        maxfilesize="{{$maxfilesize*4}}"
                        allowImagePreview
                        imageResizeTargetWidth="250"
                        imageCropAspectRatio="'1:1'"
                    />
                </div>
            </div>

            <x-error error="upload"/>
        </div>

        <div class="flex justify-end">
            <x-button>
                {{ __('Update') }}
            </x-button>
        </div>
    </form>
</div>
