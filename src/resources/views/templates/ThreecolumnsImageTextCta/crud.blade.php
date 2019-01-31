@php $columns = range(0, 2) @endphp

<div class="row-template vc-three-columns-image-text-cta">
    <input type="hidden" class="content">

    @foreach($columns as $i)
        <div class="float-left">
            <input class="c{{$i}}_image_url" type="hidden" rel="c{{$i}}_image">
            <div class="c{{$i}}_image">
                <img src>
                <input type="file">
            </div>

            <input class="c{{$i}}_title" placeholder="{{ trans('visualcomposer::templates.three-columns-image-text-cta.crud.title') }}">
            <textarea class="c{{$i}}_wysiwyg"></textarea>
            <input class="c{{$i}}_cta_label" placeholder="{{ trans('visualcomposer::templates.three-columns-image-text-cta.crud.cta_label') }}">
            <input class="c{{$i}}_cta_url" placeholder="{{ trans('visualcomposer::templates.three-columns-image-text-cta.crud.cta_url') }}">
        </div>
    @endforeach

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
                @foreach($columns as $i)
                    'c{{$i}}_image_url',
                    'c{{$i}}_title',
                    'c{{$i}}_wysiwyg',
                    'c{{$i}}_cta_label',
                    'c{{$i}}_cta_url',
                @endforeach
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

            @foreach($columns as $i)
            // Setup wysiwyg
            $('.c{{$i}}_wysiwyg', $row).ckeditor({
                filebrowserBrowseUrl: "{{ url(config('backpack.base.route_prefix').'/elfinder/ckeditor') }}",
                extraPlugins: '{{ implode(',', config('visualcomposer.ckeditor.extra_plugins', [])) }}',
                toolbar: @json(config('visualcomposer.ckeditor.toolbar')),
                on: {change: update}
            });

            // Setup picture uploader
            $('.c{{$i}}_image_url', $row).each(function () {
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
            @endforeach

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
        .vc-three-columns-image-text-cta .cke_chrome {
            width: 100%;
        }
        .vc-three-columns-image-text-cta input {
            display: block;
            width: 100%;
            margin: 1rem 0;
        }
        .vc-three-columns-image-text-cta .float-left {
            width: 33%;
            float: left;
        }
        .vc-three-columns-image-text-cta img {
            height: 250px;
            width: 100%;
            object-fit: contain;
            margin: auto;
            display: block;
        }
        .vc-three-columns-image-text-cta img[src=""] {
            display: none;
        }
    </style>
@endpush
