<div
    wire:ignore
    x-data
    x-init="
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);

        FilePond.registerPlugin(FilePondPluginImagePreview)
        FilePond.registerPlugin(FilePondPluginImageCrop);
        FilePond.registerPlugin(FilePondPluginImageResize);
        FilePond.registerPlugin(FilePondPluginImageTransform); /* Must include this (ImageTransform) plugin, order to send the modified (resized,cropped) image to backend, instead of the originally uploaded file */
        FilePond.setOptions({
            allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
                },
            },
            allowFileTypeValidation: true,
                acceptedFileTypes: {{ $attributes['acceptedFileTypes'] ?? 'null'  }},

            allowFileSizeValidation: true,
                maxFileSize: '{{ isset($attributes['maxfilesize']) ? $attributes['maxfilesize'] : '4096' }}KB',

            allowImagePreview: {{ isset($attributes['allowImagePreview']) ? 'true' : 'false' }},

            allowImageCrop: true,
                imageCropAspectRatio: {{ $attributes['imageCropAspectRatio'] ?? 'null' }},

            allowImageResize: true,
                imageResizeTargetWidth: {{ $imageResizeTargetWidth ?? 'null'  }},
                imageResizeTargetHeight: {{ $imageResizeTargetHeight ?? 'null'  }},
                imageResizeMode: 'cover',
        });
        pond = FilePond.create($refs.input);
    "
{{--    https://laravel-livewire.com/docs/2.x/events#browser--}}
    @pond-reset.window="pond.removeFiles();"
>
    <input type="file" x-ref="input">
</div>

@once
    @push('styles')
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet" />
        <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" />
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>

        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.min.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.min.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.min.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    @endpush
@endonce
