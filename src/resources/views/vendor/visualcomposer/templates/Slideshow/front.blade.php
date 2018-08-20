<div class="vc vc-slideshow">
    <div class="js-swiper-simple swiper-container">
        <div class="swiper-wrapper">
            @foreach(json_decode($content) as $item)
                @php list($image_url, $image_caption) = $item @endphp
                <div class="swiper-slide">
                    <figure>
                        <img src="{{ $image_url }}">
                        <figcaption>
                            {{ $image_caption }}
                        </figcaption>
                    </figure>
                </div>
            @endforeach
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>
