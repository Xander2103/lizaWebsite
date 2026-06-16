<section id="gallery" class="client-section-alt">
    <div class="client-container">

        <div class="section-header">
            <span class="section-eyebrow">Sfeerbeelden</span>
            <h2 class="section-title">Een blik in onze garage</h2>
        </div>

        <div class="gallery-grid">
            @foreach(config('images.gallery', []) as $index => $imagePath)
                @if(!empty($imagePath))
                    <div
                        class="gallery-item"
                        style="background-image:url('{{ asset($imagePath) }}')"
                        role="img"
                        aria-label="Galerij afbeelding {{ $index + 1 }}"
                    ></div>
                @else
                    <div class="gallery-item image-fallback" aria-hidden="true">
                        <span>Foto {{ $index + 1 }}</span>
                    </div>
                @endif
            @endforeach
        </div>

    </div>
</section>
