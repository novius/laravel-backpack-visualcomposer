<div class="row-template wide-row-template">
    <textarea class="ckeditor" type="hidden"></textarea>
</div>

@push('crud_fields_scripts')
    <script>
        window['vc_boot', {!!json_encode($template)!!}] = function ($row, content)
        {
            $('textarea.ckeditor', $row)
                .val(content)
                .ckeditor({
                    "filebrowserBrowseUrl": "{{ url(config('backpack.base.route_prefix').'/elfinder/ckeditor') }}",
                    "extraPlugins" : 'oembed,widget'
                }
            );
        }
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
