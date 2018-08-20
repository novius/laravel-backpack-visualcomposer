<div class="row-template vc-left-text-right-image">
    <input type="hidden" class="content">

    <div class="float-left">
        <input class="left_title" placeholder="{{ trans('visualcomposer::left-text-right-image.crud.left_title') }}">
        <textarea class="left_wysiwyg"></textarea>
        <input class="left_cta_label" placeholder="{{ trans('visualcomposer::left-text-right-image.crud.left_cta_label') }}">
        <input class="left_cta_url" placeholder="{{ trans('visualcomposer::left-text-right-image.crud.left_cta_url') }}">
    </div>

    <div class="float-right">
        <input class="right_image_url" type="hidden" rel="right_image">
        <div class="right_image">
            <img src>
            <input type="file">
        </div>
    </div>

    <div class="clearfix"></div>
</div>

@push('crud_fields_scripts')
    <script src="{{ asset('vendor/backpack/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/backpack/ckeditor/adapters/jquery.js') }}"></script>
    <script>
        window['vc_boot', {!!json_encode($template)!!}] = function ($row, content)
        {
            var $hiddenInput = $(".content[type=hidden]", $row);
            var fields = [
                'left_title',
                'left_wysiwyg',
                'left_cta_label',
                'left_cta_url',
                'right_image_url',
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
            $('.left_wysiwyg', $row).ckeditor({
                height: '260px',
                filebrowserBrowseUrl: "{{ url(config('backpack.base.route_prefix').'/elfinder/ckeditor') }}",
                extraPlugins: '{{ implode(',', config('visualcomposer.ckeditor.extra_plugins', [])) }}',
                toolbar: @json(config('visualcomposer.ckeditor.toolbar')),
                on: {change: update}
            });

            // Setup picture uploader
            $('.right_image_url', $row).each(function () {
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
        .vc-left-text-right-image .cke_chrome {
            width: 100%;
        }
        .vc-left-text-right-image input {
            display: block;
            width: 100%;
            margin: 1rem 0;
        }
        .vc-left-text-right-image .float-right {
            width: 49%;
            float: right;
        }
        .vc-left-text-right-image .float-left {
            width: 49%;
            float: left;
        }
        .vc-left-text-right-image img {
            width: 100%;
            height: 450px;
            object-fit: contain;
            margin: auto;
            display: block;
        }
        .vc-left-text-right-image img[src=""] {
            display: none;
        }
    </style>
@endpush
