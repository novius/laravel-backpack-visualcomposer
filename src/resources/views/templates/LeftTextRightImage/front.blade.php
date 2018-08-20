@php
    list(
        $left_title,
        $left_wysiwyg,
        $left_cta_label,
        $left_cta_url,
        $right_image_url,
    ) = json_decode($content)
@endphp
<div class="vc vc-left-text-right-image">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>
                    {{ $left_title }}
                </h2>
                <div>
                    {!! $left_wysiwyg !!}
                </div>
                @if($left_cta_url)
                    <a href="{{ $left_cta_url }}">
                        {{ $left_cta_label }}
                    </a>
                @endif
            </div>
            <div class="col-md-6">
                <img src="{{ $right_image_url }}"
                     alt="{{ $left_title }}">
            </div>
        </div>
    </div>
</div>
