<div class="row-template picture-row-template">
    <input type="hidden" class="content">
    @include('crud::fields.base64_image', [
        'field' => [
            'name' => 'image',
            'label' => '',
            'filename' => 'blah.jpg',
            'type' => 'base64_image',
        ],
        'crud' => new \Backpack\CRUD\CrudPanel,
        'fields' => [],
    ])
    <div class="clearfix"></div>
</div>

@push('crud_fields_scripts')
    <script>
        window['vc_boot', {!!json_encode($template)!!}] = function ($row, content) {
            // Setup backpack image loader
            $('.form-group.image', $row).each(function(index){
                var $mainImage = $(this).find('#mainImage');
                var $uploadImage = $(this).find("#uploadImage");
                var $hiddenImage = $(".content[type=hidden]", $row);
                var $remove = $(this).find("#remove")

                // Load content if exists
                if (content) {
                    $mainImage.attr('src', content);
                    $remove.click(function() {
                        $mainImage.attr('src','');
                        $hiddenImage.val('');
                        $remove.hide();
                    });
                }
                // Hide 'Remove' button if there is no image saved
                else {
                    $remove.hide();
                }

                // Initialise hidden form input in case we submit with no change
                $hiddenImage.val($mainImage.attr('src'));

                // Update hidden field on change
                $uploadImage.change(function() {
                    var fileReader = new FileReader(),
                        files = this.files;

                    try {
                        fileReader.onload = function () {
                            $uploadImage.val("");
                            $mainImage.attr('src',this.result);
                            $hiddenImage.val(this.result);
                            $remove.show();
                        };
                        fileReader.readAsDataURL(files[0]);
                    }
                    catch (e) {
                        console.log("Not an image file");
                    }
                });
            });
        }
    </script>
@endpush

@push('crud_fields_styles')
    <style>
        .picture-row-template {
            text-align: center;
        }
        .picture-row-template img {
            max-width: 100%;
        }
        .picture-row-template .col-sm-6 {
            float: none;
            margin: 1em auto;
        }
        .picture-row-template div > label:empty,
        .picture-row-template img#mainImage[src=''] {
            display: none;
        }
    </style>
@endpush
