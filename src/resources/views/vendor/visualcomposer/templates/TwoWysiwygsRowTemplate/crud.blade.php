<div class="row-template TwoWysiwygsRowTemplate">
    <input type="hidden">
    <textarea class="ckeditor"></textarea>
    <textarea class="ckeditor"></textarea>
</div>

@push('crud_fields_scripts')
    <script>
        window['vc_boot', {!!json_encode($template)!!}] = function ($row, content)
        {
            // Setup update routine
            var update = function () {
                var contents = [];
                $row.find('textarea.ckeditor').each(function () {
                    contents.push($(this).val());
                });
                $row.find('[type=hidden]').val(
                    JSON.stringify(contents)
                );
            };
            // Parse content from json passed in params
            var wysiwygContent = [,,];
            try {
                wysiwygContent = JSON.parse(content);
            } catch(e) {
                console.log('Empty or invalid json:', content);
                wysiwygContent.fill('');
            }
            // Fill textareas and setup ckeditor
            $row.find('textarea.ckeditor').each(function(i, textarea){
                $(textarea)
                    .val(wysiwygContent[i])
                    .ckeditor({
                        width: "49%",
                        filebrowserBrowseUrl: "{{ url(config('backpack.base.route_prefix').'/elfinder/ckeditor') }}",
                        extraPlugins: 'oembed,widget',
                        on: {
                            change: update
                        }
                    });
            });
            update();
        }
    </script>
@endpush

@push('crud_fields_styles')
    <style>
        .TwoWysiwygsRowTemplate .cke_chrome {
            display: inline-block;
        }
    </style>
@endpush
