@php
    list(
        $left_image_url,
        $right_title,
        $right_wysiwyg,
        $right_cta_label,
        $right_cta_url,
    ) = json_decode($content)
@endphp
<div class="vc vc-left-image-right-text">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ $left_image_url }}"
                     alt="{{ $right_title }}">
            </div>
            <div class="col-md-6">
                <h2>
                    {{ $right_title }}
                </h2>
                <div>
                    {!! $right_wysiwyg !!}
                </div>
                @if($right_cta_url)
                    <a href="{{ $right_cta_url }}">
                        {{ $right_cta_label }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
