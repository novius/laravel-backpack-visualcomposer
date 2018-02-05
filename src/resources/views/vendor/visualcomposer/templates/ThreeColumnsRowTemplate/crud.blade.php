<div class="row-template three-columns-row-template">
    <input type="hidden">
    <textarea class="n-0"></textarea>
    <textarea class="n-1"></textarea>
    <textarea class="n-2"></textarea>
</div>

@push('crud_fields_scripts')
    <script>
        window['vc_boot', {!!json_encode($template)!!}] = function ($row, content) {
            try {
                $.each(JSON.parse(content), function (i, val) {
                    $row.find('textarea.n-' + i).val(val);
                });
            } catch(e) {
                console.log('Empty or invalid json:', content);
            }
            var update = function () {
                var contents = [];
                $row.find('textarea').each(function () {
                    contents.push($(this).val());
                });
                $row.find('[type=hidden]').val(
                    JSON.stringify(contents)
                );
            };
            update();
            $row.on(
                'change blur keyup',
                'textarea',
                update
            );
        }
    </script>
@endpush

@push('crud_fields_styles')
    <style>
        .three-columns-row-template textarea {
            min-width: 33.2%;
            max-width: 33.2%;
        }
    </style>
@endpush
