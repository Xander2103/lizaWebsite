<section id="contact" class="client-section-alt" aria-labelledby="contact-heading">
    <div class="client-container">

        <div class="section-header reveal">
            <span class="section-eyebrow">{{ config('contact.booking_eyebrow', 'Booking & Contact') }}</span>
            <h2 class="section-title" id="contact-heading">
                {{ config('contact.booking_heading', 'Book Your Consultation') }}
                @if(!empty(config('contact.booking_heading_accent')))
                    <br>{{ config('contact.booking_heading_accent') }}
                @endif
            </h2>
            @if(!empty(config('contact.booking_intro')))
                <p class="section-intro">{{ config('contact.booking_intro') }}</p>
            @endif
        </div>

        <div class="contact-grid">

            <div class="reveal contact-form-card">
                <h3 class="contact-form-card-title">{{ config('contact.form_heading', 'Send a Message') }}</h3>

                @if(session('contact_success'))
                    <div class="form-alert form-alert-success" role="status">
                        {{ session('contact_success') }}
                    </div>
                @endif

                @if(session('contact_error'))
                    <div class="form-alert form-alert-error" role="alert">
                        {{ session('contact_error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="form-alert form-alert-error" role="alert">
                        Please correct the highlighted fields below.
                    </div>
                @endif

                <form class="contact-form" action="{{ route('contact.submit') }}" method="POST">
                    @csrf

                    <div class="form-field">
                        <label for="contact-name">Full name *</label>
                        <input type="text" id="contact-name" name="name" class="form-input"
                               value="{{ old('name') }}"
                               placeholder="Your name" required autocomplete="name">
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="contact-email">Email address *</label>
                        <input type="email" id="contact-email" name="email" class="form-input"
                               value="{{ old('email') }}"
                               placeholder="your@email.com" required autocomplete="email">
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="contact-phone">Phone number</label>
                        <input type="tel" id="contact-phone" name="phone" class="form-input"
                               value="{{ old('phone') }}"
                               placeholder="Your phone number" autocomplete="tel">
                        @error('phone')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    @if(!empty(config('contact.form_request_types')))
                        <div class="form-field">
                            <label for="contact-type">Service *</label>
                            <select id="contact-type" name="request_type" class="form-input" required>
                                <option value="" disabled @selected(old('request_type') === null)>Select a service</option>
                                @foreach(config('contact.form_request_types') as $type)
                                    <option value="{{ $type }}" @selected(old('request_type') === $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('request_type')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <div class="form-field">
                        <label for="contact-message">Message *</label>
                        <textarea id="contact-message" name="message" class="form-input"
                                  rows="4" required
                                  placeholder="Tell us briefly what you would like to discuss">{{ old('message') }}</textarea>
                        @error('message')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" id="contact-privacy" name="privacy" required>
                        <label for="contact-privacy">
                            I agree that my information may be used to respond to my enquiry.
                            @if(!empty(config('contact.privacy_link')))
                                <a href="{{ config('contact.privacy_link') }}" target="_blank" rel="noopener noreferrer">Privacy policy</a>.
                            @endif
                        </label>
                        @error('privacy')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-submit-row">
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>

                </form>
            </div>

            <div class="contact-side-cards reveal">

                <div class="contact-card-dark">
                    <p>{{ config('contact.doctoranytime_text') }}</p>
                    <a href="{{ config('contact.doctoranytime_url', '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                        Book on Doctoranytime<span aria-hidden="true"> →</span>
                    </a>
                </div>

                <div class="contact-card-location">
                    <h4>{{ config('contact.location_name') }}</h4>
                    <p>
                        {{ config('contact.address_line1') }}<br>
                        {{ config('contact.address_line2') }}
                    </p>
                    @if(!empty(config('contact.phone')))
                        <p><a href="tel:{{ config('contact.phone') }}">{{ config('contact.phone') }}</a></p>
                    @endif
                    @if(!empty(config('contact.phone_mobile')))
                        <p><a href="tel:{{ config('contact.phone_mobile') }}">{{ config('contact.phone_mobile') }}</a></p>
                    @endif

                    @if(!empty(config('contact.maps_embed_url')))
                        <div class="contact-map-embed">
                            <iframe
                                src="{{ config('contact.maps_embed_url') }}"
                                width="100%" height="100%"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Map — {{ config('contact.location_name') }}"
                            ></iframe>
                        </div>
                    @endif

                    @if(!empty(config('contact.maps_link')))
                        <a href="{{ config('contact.maps_link') }}" target="_blank" rel="noopener noreferrer" class="contact-card-link">
                            Open in Google Maps<span aria-hidden="true"> →</span>
                        </a>
                    @endif
                </div>

                <div class="contact-card-instagram">
                    <p class="contact-card-instagram-label">Follow on Instagram</p>
                    <p class="contact-card-instagram-handle">{{ config('contact.instagram_handle') }}</p>
                    <a href="{{ config('contact.instagram_url', '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                        Follow
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>
