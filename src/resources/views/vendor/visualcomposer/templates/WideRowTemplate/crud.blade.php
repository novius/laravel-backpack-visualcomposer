@php
    $class = uniqid('vc');
@endphp

<div class="{{ $class }}">
    <input type="hidden">
    <textarea>{{ $content }}</textarea>
</div>

@push('crud_fields_scripts')
    <script>
        jQuery(document).ready(function () {
            $('.vc-rows').on(
                'change blur keydown',
                '.{{ $class }} textarea',
                function () {
                    $('.vc-rows .{{ $class }} [type=hidden]').val(this.value);
                }
            );
        });
    </script>
@endpush

@push('crud_fields_styles')
    <style>
        .{{ $class }} textarea {
            min-width: 100%;
            max-width: 100%;
        }
    </style>
@endpush
