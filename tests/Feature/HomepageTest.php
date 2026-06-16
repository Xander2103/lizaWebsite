<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_homepage_loads_successfully(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_homepage_contains_business_name(): void
    {
        $this->get('/')->assertSee(config('site.name'));
    }

    public function test_homepage_contains_contact_email(): void
    {
        $this->get('/')->assertSee(config('contact.email'));
    }

    public function test_homepage_html_language_is_english(): void
    {
        $this->get('/')->assertSee('lang="en"', false);
    }

    public function test_hero_section_uses_centered_layout(): void
    {
        $this->get('/')->assertSee('hero-centered', false);
    }

    public function test_approach_section_hidden_by_default(): void
    {
        $this->get('/')->assertDontSee('id="approach"', false);
    }

    public function test_approach_section_rendered_when_enabled(): void
    {
        config(['site.sections.approach' => true]);
        $this->get('/')->assertSee('id="approach"', false);
    }

    public function test_vascular_surgery_section_rendered(): void
    {
        $this->get('/')->assertSee('id="vascular-surgery"', false);
    }

    public function test_weight_loss_section_rendered(): void
    {
        $this->get('/')->assertSee('id="weight-loss"', false);
    }

    public function test_aesthetic_medicine_section_rendered(): void
    {
        $this->get('/')->assertSee('id="aesthetic-medicine"', false);
    }

    public function test_vascular_surgery_section_hidden_when_disabled(): void
    {
        config(['site.sections.vascular_surgery' => false]);
        $this->get('/')->assertDontSee('id="vascular-surgery"', false);
    }

    public function test_cta_banner_rendered(): void
    {
        $this->get('/')->assertSee('cta-banner', false);
    }

    public function test_cta_banner_hidden_when_disabled(): void
    {
        config(['site.sections.cta_banner' => false]);
        $this->get('/')->assertDontSee('cta-banner-heading', false);
    }

    public function test_noindex_meta_rendered_when_enabled(): void
    {
        config(['seo.noindex' => true]);
        $this->get('/')->assertSee('<meta name="robots" content="noindex">', false);
    }

    public function test_gallery_section_hidden_when_disabled(): void
    {
        config(['site.sections.gallery' => false]);
        $this->get('/')->assertDontSee('id="gallery"', false);
    }

    public function test_trust_section_hidden_by_default(): void
    {
        $this->get('/')->assertDontSee('id="trust"', false);
    }
}
