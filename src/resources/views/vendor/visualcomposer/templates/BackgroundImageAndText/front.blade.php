@php
    list(
        $image_url,
        $image_caption,
        $wysiwyg,
    ) = json_decode($content)
@endphp
<div class="vc vc-background-image-and-text">
    <figure>
        <img src="{{ $image_url }}">
        <figcaption>
            <div class="container">
                {{ $image_caption }}
                {!! $wysiwyg !!}
            </div>
        </figcaption>
    </figure>
</div>
