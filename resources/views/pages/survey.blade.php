@extends('layouts.app')

@section('title', session('lang', 'ar') === 'ar' ? 'الاستبيان' : 'Survey')

@section('content')
    <section class="page-placeholder">
        <div class="container">
            <div class="page-placeholder__card surface-card slide-up">
                <h1 data-lang-key="survey.title">{{ session('lang', 'ar') === 'ar' ? 'الاستبيان' : 'Survey' }}</h1>
                <p data-lang-key="survey.welcome_msg">{{ session('lang', 'ar') === 'ar' ? 'يرجى تقييم تجربتكِ بصدق، إجاباتكِ ستُثري هذا البحث العلمي' : 'Please rate your experience honestly — your answers will enrich this research' }}</p>
            </div>
        </div>
    </section>
@endsection
