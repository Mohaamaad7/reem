@extends('layouts.app')

@section('title', session('lang', 'ar') === 'ar' ? 'التقنية' : 'Technique')

@section('content')
    <section class="page-placeholder">
        <div class="container">
            <div class="page-placeholder__card surface-card slide-up">
                <h1 data-lang-key="technique.title">{{ session('lang', 'ar') === 'ar' ? 'تقنية النقشة الزائدة' : 'Extra Weft Technique' }}</h1>
                <p data-lang-key="technique.subtitle">{{ session('lang', 'ar') === 'ar' ? 'Extra Weft Technique' : 'تقنية النقشة الزائدة' }}</p>
            </div>
        </div>
    </section>
@endsection
