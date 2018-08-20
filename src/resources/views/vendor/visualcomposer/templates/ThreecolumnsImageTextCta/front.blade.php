@php
    $columns = range(0, 2);
    $fields = json_decode($content);
    foreach ($columns as $i) {
        foreach ([
            "c{$i}_image_url",
            "c{$i}_title",
            "c{$i}_wysiwyg",
            "c{$i}_cta_label",
            "c{$i}_cta_url",
        ] as $f) {
            $$f = array_shift($fields);
        }
    }
@endphp
<div class="vc vc-two-columns-image-text-cta">
    <div class="container">
        <div class="row">
            @foreach($columns as $i)
                <div class="col-md-4">
                    <img src="{{ ${"c{$i}_image_url"} }}"
                         alt="{{ ${"c{$i}_title"} }}">
                    <h2>
                        {{ ${"c{$i}_title"} }}
                    </h2>
                    <div>
                        {!! ${"c{$i}_wysiwyg"} !!}
                    </div>
                    @if(${"c{$i}_cta_url"})
                        <a href="{{ ${"c{$i}_cta_url"} }}">
                            {{ ${"c{$i}_cta_label"} }}
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
