@php
list(
    $title,
    $date,
    $author,
    $subtitle,
    $wysiwyg,
    $cta_label,
    $cta_url,
    $bg_color_container,
    $bg_color_fullwidth
) = json_decode($content)
@endphp
<div class="vc vc-article" style="background:{{ $bg_color_container }}">
    <div class="container" style="background:{{ $bg_color_fullwidth }}">
        <div class="row">
            <h2>
                {{ $title }}
            </h2>
            <div>
                <time>
                    le {{ $date }}
                </time>
                par
                <span rel="author">
                    {{ $author }}
                </span>
            </div>
            <h3>
                {{ $subtitle }}
            </h3>
            <div>
                {!! $wysiwyg !!}
            </div>
            @if($cta_url)
                <a href="{{ $cta_url }}">
                    {{ $cta_label }}
                </a>
            @endif
        </div>
    </div>
</div>
