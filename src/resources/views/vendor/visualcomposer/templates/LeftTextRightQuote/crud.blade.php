<div class="row-template vc-left-text-right-quote">
    <input type="hidden" class="content">

    <div class="float-left">
        <input class="left_title" placeholder="{{ trans('visualcomposer::left-text-right-quote.crud.left_title') }}">
        <textarea class="left_wysiwyg"></textarea>
        <input class="left_cta_label" placeholder="{{ trans('visualcomposer::left-text-right-quote.crud.left_cta_label') }}">
        <input class="left_cta_url" placeholder="{{ trans('visualcomposer::left-text-right-quote.crud.left_cta_url') }}">
    </div>

    <div class="float-right">
        <textarea class="right_wysiwyg"></textarea>
        <textarea class="right_author"></textarea>
        <input class="right_cta_label" placeholder="{{ trans('visualcomposer::left-text-right-quote.crud.right_cta_label') }}">
        <input class="right_cta_url" placeholder="{{ trans('visualcomposer::left-text-right-quote.crud.right_cta_url') }}">
        <label>
            {{ trans('visualcomposer::left-text-right-quote.crud.right_color') }}
            <select class="right_color">
                @foreach(config('visualcomposer.colors') as $name => $code)
                    <option value="{{ $code }}">{{ trans("visualcomposer::colors.$name") }}</option>
                @endforeach
            </select>
        </label>
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
                'right_wysiwyg',
                'right_author',
                'right_cta_label',
                'right_cta_url',
                'right_color',
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
            $('.right_wysiwyg', $row).ckeditor({
                height: '150px',
                filebrowserBrowseUrl: "{{ url(config('backpack.base.route_prefix').'/elfinder/ckeditor') }}",
                extraPlugins: '{{ implode(',', config('visualcomposer.ckeditor.extra_plugins', [])) }}',
                toolbar: @json(config('visualcomposer.ckeditor.toolbar')),
                on: {change: update}
            });
            $('.right_author', $row).ckeditor({
                height: '70px',
                toolbar: [['Bold','Italic']],
                on: {change: update}
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
        .vc-left-text-right-quote .cke_chrome {
            width: 100%;
        }
        .vc-left-text-right-quote input {
            display: block;
            width: 100%;
            margin: 1rem 0;
        }
        .vc-left-text-right-quote .float-right {
            width: 49%;
            float: right;
        }
        .vc-left-text-right-quote .float-left {
            width: 49%;
            float: left;
        }
        .vc-left-text-right-quote label {
            font-weight: inherit;
            margin-right: 3rem;
        }
    </style>
@endpush
