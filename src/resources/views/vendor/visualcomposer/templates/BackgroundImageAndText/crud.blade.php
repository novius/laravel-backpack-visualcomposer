<div class="row-template vc-background-image-and-text">
    <input type="hidden" class="content">

    <input class="image_url" type="hidden" rel="image">
    <div class="image">
        <img src>
        <input type="file">
    </div>

    <input class="image_caption" placeholder="{{ trans('visualcomposer::background-image-and-text.crud.image_caption') }}">
    <textarea class="wysiwyg"></textarea>
</div>

@push('crud_fields_scripts')
    <script src="{{ asset('vendor/backpack/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/backpack/ckeditor/adapters/jquery.js') }}"></script>
    <script>
        window['vc_boot', {!!json_encode($template)!!}] = function ($row, content)
        {
            var $hiddenInput = $(".content[type=hidden]", $row);
            var fields = [
                'image_url',
                'image_caption',
                'wysiwyg',
            ];

            // Setup update routine
            var update = function () {
                var contents = [];
                fields.map(function (item) {
                    contents.push($('.'+item, $row).val());
                });
                $hiddenInput.val(
                    JSON.stringify(contents)
                );
            };

            // Parse and fill fields from json passed in params
            fields.map(function (item, index) {
                try {
                    $('.'+item, $row).val(JSON.parse(content)[index]);
                } catch(e) {
                    console.log('Empty or invalid json:', content);
                }
            });

            // Setup wysiwygs
            $('.wysiwyg', $row).ckeditor({
                filebrowserBrowseUrl: "{{ url(config('backpack.base.route_prefix').'/elfinder/ckeditor') }}",
                extraPlugins: '{{ implode(',', config('visualcomposer.ckeditor.extra_plugins', [])) }}',
                toolbar: @json(config('visualcomposer.ckeditor.toolbar')),
                on: {change: update}
            });

            // Setup picture uploader
            $('.image_url', $row).each(function () {
                var $field = $(this),
                    $uploader = $('.'+$field.attr('rel'), $row),
                    $preview = $('img', $uploader),
                    $file = $('[type="file"]', $uploader);
                $preview.attr('src', $field.val());
                $file.change(function (e) {
                    e.preventDefault();
                    files = e.target.files;
                    if (!files.length) return;
                    var data = new FormData();
                    data.append('file', files[0]);
                    $.ajax({
                        url: @json(route('visualcomposer.fileupload')),
                        type: 'POST',
                        data: data,
                        cache: false,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if(data.error !== false) {
                                return alert('Upload error');
                            }
                            $preview.attr('src', data.url);
                            $field.val(data.url);
                            update();
                        },
                        error: function() {
                            alert('Connection error');
                        }
                    });
                });
            });

            // Update hidden field on change
            $row.on(
                'change blur keyup',
                'input, textarea, select',
                update
            );

            // Initialize hidden form input in case we submit with no change
            update();
        }
    </script>
@endpush

@push('crud_fields_styles')
    <style>
        .vc-background-image-and-text .cke_chrome {
            width: 100%;
        }
        .vc-background-image-and-text input {
            display: block;
            width: 100%;
            margin: 1rem 0;
        }
        .vc-background-image-and-text img {
            width: 720px;
            max-width: 100%;
            margin: auto;
            display: block;
        }
        .vc-background-image-and-text img[src=""] {
            display: none;
        }
    </style>
@endpush
