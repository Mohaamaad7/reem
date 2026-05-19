@extends('layouts.app')
@section('title', 'تم الإرسال بنجاح')
@section('content')
<div class="container mx-auto px-4 py-16 text-center h-screen flex flex-col justify-center items-center">
    <div class="bg-white rounded-xl shadow-lg p-12 max-w-lg w-full border border-gray-100">
        <svg class="w-20 h-20 text-green-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ session('success', 'تم استلام تقييمكم بنجاح') }}</h1>
        <p class="text-gray-600 text-lg mb-8">نشكر لكم وقتكم وجهدكم في إثراء هذا البحث العلمي. تقييمكم محل تقدير واهتمام.</p>
        <a href="/" class="bg-gray-800 text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-900 transition">العودة للرئيسية</a>
    </div>
</div>
@endsection
