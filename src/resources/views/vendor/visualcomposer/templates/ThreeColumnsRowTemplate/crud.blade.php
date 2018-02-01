<div class="row-template three-columns-row-template">
    <input type="hidden">
    <textarea>{{ json_decode($content)[0] }}</textarea>
    <textarea>{{ json_decode($content)[1] }}</textarea>
    <textarea>{{ json_decode($content)[2] }}</textarea>
</div>

@push('crud_fields_scripts')
    <script>
        jQuery(document).ready(function () {
            $('.vc-rows').on(
                'change blur keydown',
                '.three-columns-row-template textarea',
                function () {
                    var $rowTemplate = $(this).closest('.row-template');
                    var contents = [];
                    $rowTemplate.find('textarea').each(function() {
                        contents.push($(this).val());
                    });
                    $rowTemplate.find('[type=hidden]').val(
                        JSON.stringify(contents)
                    );
                }
            );
        });
    </script>
@endpush

@push('crud_fields_styles')
    <style>
        .three-columns-row-template textarea {
            min-width: 33%;
            max-width: 33%;
        }
    </style>
@endpush
