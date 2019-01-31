@php list($image_url) = json_decode($content) @endphp
<div class="vc vc-image-in-container">
    <div class="container">
        <img src="{{ $image_url }}">
    </div>
</div>
