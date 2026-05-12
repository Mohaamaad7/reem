<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دخول لوحة التحكم — Rawnaq</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Noto Sans Arabic', 'sans-serif'] }, colors: { primary: { 500: '#8B6914', 600: '#745810' } } } }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <div class="text-center mb-8">
                <div class="w-12 h-12 rounded-xl bg-primary-500 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="hexagon" class="w-7 h-7 text-white"></i>
                </div>
                <h1 class="text-xl font-bold text-slate-800">لوحة التحكم</h1>
                <p class="text-sm text-slate-400 mt-1">سجّل دخولك للمتابعة</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm mb-5">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">اسم المستخدم</label>
                    <input type="text" name="username" value="{{ old('username') }}" required autofocus
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">كلمة المرور</label>
                    <input type="password" name="password" required
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none">
                </div>
                <button type="submit"
                        class="w-full py-2.5 bg-primary-500 text-white rounded-xl font-medium hover:bg-primary-600 transition-colors">
                    دخول
                </button>
            </form>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
