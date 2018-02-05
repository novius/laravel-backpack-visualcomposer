<div id="visualcomposer_{{ $field['name'] }}" @include('crud::inc.field_wrapper_attributes')>

    <label>
        {{ $field['label'] }}
    </label>

    <input type="hidden"
           name="{{ $field['name'] }}"
           value="{{ $field['value'] }}"
            @include('crud::inc.field_attributes')>

    @if (isset($field['hint']))
        <p class="help-block">
            {!! $field['hint'] !!}
        </p>
    @endif

    <div class="vc-rows"></div>

    <div class="vc-templates">
        {{-- Load available templates --}}
        @foreach(config('visualcomposer.templates') as $template)
            <div class="vc-row"
                 data-template="{{ $template }}">
                <div class="vc-handle"></div>
                <div class="vc-icons">
                    <button class="trash">
                        <i class="fa fa-trash"></i>
                    </button>
                    <button class="up">
                        <i class="fa fa-arrow-up"></i>
                    </button>
                    <button class="down">
                        <i class="fa fa-arrow-down"></i>
                    </button>
                </div>
                <div class="vc-content">
                    {!! $template::renderCrud() !!}
                </div>
            </div>
        @endforeach
    </div>

    <select name="templates">
        <option value="" disabled selected>
            Sélectionnez un type de ligne à insérer
        </option>
        @foreach(config('visualcomposer.templates') as $template)
            <option value="{{ $template }}">
                {{ $template::$name }} — {{ $template::$description }}
            </option>
        @endforeach
    </select>
    <button class="add">
        Ajouter
    </button>

</div>

@push('crud_fields_styles')
    <style>
        #visualcomposer_{{ $field['name'] }} .vc-templates {
            display: none;
        }

        .vc-row {
            border: solid 1px silver;
            background: #eee;
            position: relative;
            padding-left: 20px;
            margin-bottom: 5px;
        }

        .vc-row .vc-handle {
            background: silver;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 20px;
        }

        .vc-row .vc-icons {
            position: absolute;
            top: 0;
            right: 0;
        }

        .vc-row:first-child .vc-icons .up,
        .vc-row:last-child .vc-icons .down {
            display: none;
        }

        .vc-row .vc-content {
            padding: 20px;
        }
    </style>
@endpush

@push('crud_fields_scripts')
    <script>
        jQuery(document).ready(function($) {
            var $crudSection = $('#visualcomposer_{{ $field['name'] }}');
            var $hiddenInput = $crudSection.find('> input[name="{{ $field['name'] }}"]');
            var $rowsContainer = $crudSection.find('.vc-rows');

            // Load rows
            $.each(JSON.parse($hiddenInput.val()), function(i, row) {
                addRow(row.template, row.content);
            });

            // Add a row
            $crudSection.find('button.add').click(function (e) {
                e.preventDefault();
                var template = $crudSection.find('select[name=templates] option:checked').val();
                template && addRow(template);
            });

            // Delete a row
            $crudSection.on('click', '.vc-row button.trash', function (e) {
                e.preventDefault();
                $row = $(this).closest('.vc-row');
                $row.remove();
                refreshVisualComposerValue();
            });

            // Move a row upwards
            $crudSection.on('click', '.vc-row button.up', function (e) {
                e.preventDefault();
                $row = $(this).closest('.vc-row');
                // save previous row
                $prev = $row.prev();
                var template = $prev.attr('data-template');
                var content = $prev.find('[type=hidden]').val();
                if(content === '') throw new Error('content est vide');
                var order = $prev.index();
                // Remove it
                $prev.remove();
                // Re-insert it below
                addRow(template, content, order+1);
                refreshVisualComposerValue();
            });

            // Move a row downwards
            $crudSection.on('click', '.vc-row button.down', function (e) {
                e.preventDefault();
                $row = $(this).closest('.vc-row');
                // Save next row
                $next = $row.next();
                var template = $next.attr('data-template');
                var content = $next.find('[type=hidden]').val();
                var order = $next.index();
                // Remove it
                $next.remove();
                // Re-insert it above
                addRow(template, content, order-1);
                refreshVisualComposerValue();
            });

            // Refresh visual composer value. Didn’t find a better way yet.
            $crudSection.on('mousemove mousewheel', function (e) {
                setTimeout(refreshVisualComposerValue, 10);
            });

            function refreshVisualComposerValue()
            {
                var contents = [];
                $rowsContainer.find('.vc-row').each(function() {
                    contents.push({
                        template: $(this).attr('data-template'),
                        content: $(this).find('[type=hidden]').val()
                    });
                });
                $hiddenInput.val(JSON.stringify(contents));
            }

            function addRow(template, content, order)
            {
                var $row = $crudSection
                    .find(".vc-templates > .vc-row[data-template$='"+template.split('\\').pop()+"']").clone();
                if (order === undefined) {
                    $row.appendTo($rowsContainer);
                } else if (order <= 0) {
                    $row.prependTo($rowsContainer);
                } else {
                    $row.insertAfter($rowsContainer.children(':nth-child('+(order)+')'));
                }
                window['vc_boot', template]($row, content);
                refreshVisualComposerValue();
            }
        });
    </script>
@endpush
