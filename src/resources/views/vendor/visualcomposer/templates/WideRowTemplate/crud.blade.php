<div class="row-template wide-row-template">
    <input type="hidden">
    <textarea>{{ $content }}</textarea>
</div>

@push('crud_fields_scripts')
    <script>
        jQuery(document).ready(function () {
            $('.vc-rows').on(
                'change blur keydown',
                '.wide-row-template textarea',
                function () {
                    $(this)
                        .closest('.row-template')
                            .find('[type=hidden]').val(this.value);
                }
            );
        });
    </script>
@endpush

@push('crud_fields_styles')
    <style>
        .wide-row-template textarea {
            min-width: 100%;
            max-width: 100%;
        }
    </style>
@endpush
