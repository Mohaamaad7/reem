@extends('admin.layouts.admin')

@section('title', $page->title_ar)
@section('page_title', 'تعديل: ' . $page->title_ar)

@section('content')
    <form method="POST" action="{{ route('admin.content.update', $page->slug) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Hero Image + Titles -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
            <h2 class="text-lg font-semibold text-slate-800">معلومات الصفحة</h2>

            <!-- Hero Image -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">صورة الغلاف</label>
                @if($page->hero_image)
                    <div class="mb-3">
                        <img src="{{ $page->hero_image }}" alt="Hero" class="h-32 rounded-lg object-cover">
                    </div>
                @endif
                <input type="file" name="hero_image" accept="image/*"
                       class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100">
            </div>

            <!-- Titles -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">العنوان (عربي)</label>
                    <input type="text" name="title_ar" value="{{ old('title_ar', $page->title_ar) }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Title (English)</label>
                    <input type="text" name="title_en" value="{{ old('title_en', $page->title_en) }}" dir="ltr"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none" required>
                </div>
            </div>

            <!-- Intros -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">المقدمة (عربي)</label>
                    <textarea name="intro_ar" rows="4"
                              class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none resize-y" required>{{ old('intro_ar', $page->intro_ar) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Introduction (English)</label>
                    <textarea name="intro_en" rows="4" dir="ltr"
                              class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none resize-y" required>{{ old('intro_en', $page->intro_en) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Sections -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-slate-800">الأقسام</h2>
                <button type="button" id="add-section-btn"
                        class="flex items-center gap-2 px-4 py-2 bg-primary-50 text-primary-600 rounded-xl text-sm font-medium hover:bg-primary-100 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    إضافة قسم
                </button>
            </div>

            <div id="sections-container" class="space-y-6">
                @foreach($page->sections ?? [] as $index => $section)
                    <div class="section-block border border-slate-200 rounded-xl p-5 relative" data-index="{{ $index }}">
                        <button type="button" onclick="removeSection(this)"
                                class="absolute top-3 left-3 w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>

                        <div class="space-y-4">
                            {{-- Anchor ID + Titles row --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 mb-1">Anchor ID (للـ TOC)</label>
                                    <input type="text" name="sections[{{ $index }}][anchor_id]" value="{{ $section['anchor_id'] ?? '' }}" dir="ltr"
                                           class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm font-mono focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none"
                                           placeholder="e.g. intro, early, philosophy">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 mb-1">عنوان القسم (عربي)</label>
                                    <input type="text" name="sections[{{ $index }}][title_ar]" value="{{ $section['title_ar'] ?? '' }}"
                                           class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 mb-1">Section Title (English)</label>
                                    <input type="text" name="sections[{{ $index }}][title_en]" value="{{ $section['title_en'] ?? '' }}" dir="ltr"
                                           class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none">
                                </div>
                            </div>

                            {{-- Body fields with Summernote --}}
                            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 mb-1">المحتوى (عربي) — HTML Editor</label>
                                    <textarea name="sections[{{ $index }}][body_ar]"
                                              class="summernote-ar w-full rounded-lg border border-slate-200 text-sm"
                                              data-index="{{ $index }}" data-lang="ar">{{ $section['body_ar'] ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 mb-1">Content (English) — HTML Editor</label>
                                    <textarea name="sections[{{ $index }}][body_en]"
                                              class="summernote-en w-full rounded-lg border border-slate-200 text-sm"
                                              data-index="{{ $index }}" data-lang="en" dir="ltr">{{ $section['body_en'] ?? '' }}</textarea>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">رابط الصورة (اختياري)</label>
                                <input type="text" name="sections[{{ $index }}][image_url]" value="{{ $section['image_url'] ?? '' }}" dir="ltr"
                                       class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none"
                                       placeholder="/images/content/...">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit"
                    class="px-8 py-3 bg-primary-500 text-white rounded-xl font-medium hover:bg-primary-600 transition-colors shadow-sm">
                حفظ التغييرات
            </button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    // ── Summernote config ───────────────────────────────────────────
    const snCommon = {
        height: 300,
        toolbar: [
            ['style',  ['bold', 'italic', 'underline', 'clear']],
            ['font',   ['strikethrough']],
            ['para',   ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'hr']],
            ['misc',   ['codeview', 'fullscreen']],
        ],
        callbacks: {
            onInit: function() { $(this).summernote('code', $(this).val() || $(this).html()); }
        }
    };

    function initSummernote(el) {
        const lang = $(el).data('lang') === 'en' ? 'en-US' : 'ar-AR';
        const dir  = $(el).data('lang') === 'en' ? 'ltr' : 'rtl';
        $(el).summernote($.extend({}, snCommon, {
            lang: lang,
            direction: dir,
        }));
    }

    $(document).ready(function () {
        // init all existing editors
        $('.summernote-ar, .summernote-en').each(function () {
            initSummernote(this);
        });
    });

    // ── Dynamic section add ─────────────────────────────────────────
    let sectionIndex = {{ count($page->sections ?? []) }};

    document.getElementById('add-section-btn').addEventListener('click', function () {
        const container = document.getElementById('sections-container');
        const idx = sectionIndex;
        const block = document.createElement('div');
        block.className = 'section-block border border-slate-200 rounded-xl p-5 relative';
        block.dataset.index = idx;

        block.innerHTML = `
            <button type="button" onclick="removeSection(this)"
                    class="absolute top-3 left-3 w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Anchor ID (للـ TOC)</label>
                        <input type="text" name="sections[${idx}][anchor_id]" dir="ltr"
                               class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm font-mono focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none"
                               placeholder="e.g. intro, early, philosophy">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">عنوان القسم (عربي)</label>
                        <input type="text" name="sections[${idx}][title_ar]"
                               class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Section Title (English)</label>
                        <input type="text" name="sections[${idx}][title_en]" dir="ltr"
                               class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">المحتوى (عربي) — HTML Editor</label>
                        <textarea id="sn-ar-${idx}" name="sections[${idx}][body_ar]"
                                  class="summernote-ar w-full rounded-lg border border-slate-200 text-sm"
                                  data-index="${idx}" data-lang="ar"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Content (English) — HTML Editor</label>
                        <textarea id="sn-en-${idx}" name="sections[${idx}][body_en]"
                                  class="summernote-en w-full rounded-lg border border-slate-200 text-sm"
                                  data-index="${idx}" data-lang="en" dir="ltr"></textarea>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">رابط الصورة (اختياري)</label>
                    <input type="text" name="sections[${idx}][image_url]" dir="ltr"
                           class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none"
                           placeholder="/images/content/...">
                </div>
            </div>
        `;

        container.appendChild(block);

        // Init Summernote on the new textareas
        $(`#sn-ar-${idx}`).summernote($.extend({}, snCommon, { direction: 'rtl' }));
        $(`#sn-en-${idx}`).summernote($.extend({}, snCommon, { direction: 'ltr' }));

        sectionIndex++;
        lucide.createIcons();
    });

    function removeSection(btn) {
        if (confirm('هل أنت متأكد من حذف هذا القسم؟')) {
            const block = btn.closest('.section-block');
            // Destroy any summernote editors inside before removing
            $(block).find('.summernote-ar, .summernote-en').each(function () {
                if ($(this).data('summernote')) { $(this).summernote('destroy'); }
            });
            block.remove();
        }
    }
</script>
@endpush
