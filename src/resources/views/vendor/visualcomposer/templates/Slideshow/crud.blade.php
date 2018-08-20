<div class="row-template vc-slideshow">
    <input type="hidden" class="content">

    <div class="slides"></div>
    <a class="add btn btn-default" href="#">
        {{ trans('visualcomposer::slideshow.crud.add_slide') }}
    </a>

    <div class="slide template">
        <img src class="image">
        <input type="file" class="file">
        <textarea class="caption"
                  placeholder="{{ trans('visualcomposer::slideshow.crud.caption') }}"></textarea>
        <a class="delete btn btn-warning" href="#">
            {{ trans('visualcomposer::slideshow.crud.delete_slide') }}
        </a>
    </div>
</div>

@push('crud_fields_scripts')
    <script>
        window['vc_boot', {!!json_encode($template)!!}] = function ($row, content)
        {
            var $hiddenInput = $(".content[type=hidden]", $row);
            var $slides = $('.slides', $row),
                $template = $('.slide.template', $row);

            // Setup update routine
            var update = function () {
                var contents = [];
                $('.slides > .slide' ,$row).each(function() {
                    contents.push([
                        $(this).find('.image').attr('src'),
                        $(this).find('.caption').val()
                    ]);
                });
                $hiddenInput.val(
                    JSON.stringify(contents)
                );
            };

            var addPicture = function (url, caption) {
                var $picture = $template.clone();
                $picture.removeClass('template');
                $picture.find('.image').attr('src', url);
                $picture.find('.caption').val(caption);
                $picture.appendTo($slides);
            };

            var deletePicture = function ($picture) {
                $picture.remove();
            };

            // Parse content from json passed in params
            try {
                $slides.empty();
                $.each(JSON.parse(content), function (i, val) {
                    addPicture(val[0], val[1]);
                });
            } catch(e) {
                console.log('Empty or invalid json:', content);
            }

            // Set up add/delete events
            $row.on('click', '.add', function (e) {
                e.preventDefault();
                addPicture('', '');
                update();
            });
            $row.on('click', '.delete', function (e) {
                e.preventDefault();
                $picture = $(this).closest('.slide');
                deletePicture($picture);
                update();
            });
            $row.on('change', '.file', function (e) {
                e.preventDefault();
                $picture = $(this).closest('.slide');
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
                            return alert('Error');
                        }
                        $('.image', $picture).attr('src', data.url);
                        update();
                    },
                    error: function() {
                        alert('Error');
                    }
                });
            });

            // Update hidden field on change
            $row.on(
                'change blur keyup',
                'input, textarea',
                update
            );

            // Initialize hidden form input in case we submit with no change
            update();
        }
    </script>
@endpush

@push('crud_fields_styles')
    <style>
        .vc-slideshow input,
        .vc-slideshow textarea  {
            min-width: 100%;
            max-width: 100%;
        }
        .vc-slideshow .template {
            display: none;
        }
        .vc-slideshow .slide {
            padding: 20px 0;
            border-bottom: solid 1px silver;
        }
        .vc-slideshow .slides img {
            height: 150px;
            margin: auto;
            display: block;
        }
        .vc-slideshow .slides img[src=""] {
            display: none;
        }
    </style>
@endpush
