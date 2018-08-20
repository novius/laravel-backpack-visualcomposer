@php
    list(
        $left_title,
        $left_wysiwyg,
        $left_cta_label,
        $left_cta_url,
        $right_wysiwyg,
        $right_author,
        $right_cta_label,
        $right_cta_url,
        $right_color
    ) = json_decode($content)
@endphp
<div class="vc vc-left-text-right-quote">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>
                    {{ $left_title }}
                </h2>
                <div>
                    {!! $left_wysiwyg !!}
                </div>
                @if($right_cta_url)
                    <a href="{{ $left_cta_url }}">
                        {{ $left_cta_label }}
                    </a>
                @endif
            </div>
            <div class="col-md-6" style="background:{{ $right_color }}">
                <div>
                    {!! $right_wysiwyg !!}
                </div>
                <div rel="author">
                    {!! $right_author !!}
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
