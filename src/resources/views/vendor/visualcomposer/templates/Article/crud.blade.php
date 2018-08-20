<div class="row-template vc-article">
    <input type="hidden" class="content">

    <input class="title" placeholder="{{ trans('visualcomposer::article.crud.title') }}">
    <input class="date" placeholder="{{ trans('visualcomposer::article.crud.date') }}">
    <input class="author" placeholder="{{ trans('visualcomposer::article.crud.author') }}">
    <input class="subtitle" placeholder="{{ trans('visualcomposer::article.crud.subtitle') }}">

    <textarea class="wysiwyg"></textarea>

    <input class="cta_label" placeholder="{{ trans('visualcomposer::article.crud.cta_label') }}">
    <input class="cta_url" placeholder="{{ trans('visualcomposer::article.crud.cta_url') }}">

    <label>
        {{ trans('visualcomposer::article.crud.bg_color_container') }}
        <select class="bg_color_container">
            @foreach(config('visualcomposer.colors') as $name => $code)
                <option value="{{ $code }}">{{ trans("visualcomposer::colors.$name") }}</option>
            @endforeach
        </select>
    </label>

    <label>
        {{ trans('visualcomposer::article.crud.bg_color_fullwidth') }}
        <select class="bg_color_fullwidth">
            @foreach(config('visualcomposer.colors') as $name => $code)
                <option value="{{ $code }}">{{ trans("visualcomposer::colors.$name") }}</option>
            @endforeach
        </select>
    </label>
</div>

@push('crud_fields_scripts')
    <script src="{{ asset('vendor/backpack/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/backpack/ckeditor/adapters/jquery.js') }}"></script>
    <script>
        window['vc_boot', {!!json_encode($template)!!}] = function ($row, content)
        {
            var $hiddenInput = $(".content[type=hidden]", $row);
            var fields = [
                'title',
                'date',
                'author',
                'subtitle',
                'wysiwyg',
                'cta_label',
                'cta_url',
                'bg_color_container',
                'bg_color_fullwidth',
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

            // Setup wysiwyg
            $('.wysiwyg', $row).ckeditor({
                filebrowserBrowseUrl: "{{ url(config('backpack.base.route_prefix').'/elfinder/ckeditor') }}",
                extraPlugins: '{{ implode(',', config('visualcomposer.ckeditor.extra_plugins', [])) }}',
                toolbar: @json(config('visualcomposer.ckeditor.toolbar')),
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
        .vc-article .cke_chrome {
            width: 100%;
        }
        .vc-article input {
            display: block;
            width: 100%;
            margin: 1rem 0;
        }
        .vc-article label {
            font-weight: inherit;
            margin-right: 3rem;
        }
    </style>
@endpush
