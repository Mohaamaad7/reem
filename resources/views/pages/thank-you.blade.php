@extends('layouts.app')

@section('title', session('lang', 'ar') === 'ar' ? 'شكراً لكِ' : 'Thank You')

@section('content')
    <section class="page-placeholder">
        <div class="container">
            <div class="page-placeholder__card surface-card slide-up">
                <h1 data-lang-key="thank_you.title">{{ session('lang', 'ar') === 'ar' ? 'شكراً لكِ!' : 'Thank You!' }}</h1>
                <p data-lang-key="thank_you.message">{{ session('lang', 'ar') === 'ar' ? 'مساهمتكِ ستُثري هذا البحث العلمي' : 'Your contribution will enrich this scientific research' }}</p>
            </div>
        </div>
    </section>
@endsection
