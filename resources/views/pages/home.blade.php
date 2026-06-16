@extends('layouts.client')

@section('content')

    @if(config('site.sections.hero', true))
        @include('sections.hero')
    @endif

    @if(config('site.sections.services', true))
        @include('sections.services')
    @endif

    @if(config('site.sections.about', true))
        @include('sections.about')
    @endif

    @if(config('site.sections.vascular_surgery', true))
        @include('sections.vascular-surgery')
    @endif

    @if(config('site.sections.weight_loss', true))
        @include('sections.medical-weight-loss')
    @endif

    @if(config('site.sections.aesthetic_medicine', true))
        @include('sections.aesthetic-medicine')
    @endif

    @if(config('site.sections.approach', true))
        @include('sections.approach')
    @endif

    @if(config('site.sections.trust', true))
        @include('sections.trust')
    @endif

    @if(config('site.sections.cta_banner', true))
        @include('sections.cta-banner')
    @endif

    @if(config('site.sections.contact', true))
        @include('sections.contact')
    @endif

@endsection
