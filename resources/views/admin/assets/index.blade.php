@extends('admin.layouts.admin')

@section('title', $title)
@section('page_title', $title)

@section('content')
    <!-- Upload Zone -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-slate-800">رفع {{ $title }} جديدة</h2>
            <span class="text-sm text-slate-400">{{ count($assets) }} ملف</span>
        </div>

        <div id="upload-zone"
             class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center hover:border-primary-400 hover:bg-primary-50/30 transition-colors cursor-pointer relative">
            <input type="file" id="file-input" accept="image/jpeg,image/png,image/jpg,image/webp"
                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" multiple>
            <div class="space-y-3">
                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                    <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-700">اسحب الملفات هنا أو اضغط للاختيار</p>
                    <p class="text-xs text-slate-400 mt-1">JPEG, PNG, WebP — الحد الأقصى 20MB</p>
                </div>
            </div>
        </div>

        <!-- Upload Progress -->
        <div id="upload-progress" class="hidden mt-4 space-y-2"></div>
    </div>

    <!-- Assets Grid -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">{{ $title }} المرفوعة ({{ count($assets) }})</h2>

        @if(count($assets) === 0)
            <div class="text-center py-12 text-slate-400">
                <i data-lucide="image-off" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                <p class="text-sm">لا توجد ملفات مرفوعة بعد</p>
            </div>
        @else
            <div id="assets-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach($assets as $asset)
                    <div class="group relative bg-slate-50 rounded-xl overflow-hidden border border-slate-100 hover:shadow-md transition-shadow"
                         data-asset-id="{{ $asset['id'] }}">
                        <div class="aspect-square">
                            <img src="{{ $asset['thumb_url'] }}" alt="{{ $asset['id'] }}"
                                 class="w-full h-full object-cover" loading="lazy">
                        </div>
                        <div class="p-2">
                            <p class="text-xs text-slate-600 truncate font-medium">{{ $asset['id'] }}</p>
                        </div>
                        <button onclick="deleteAsset('{{ $type }}', '{{ $asset['id'] }}', this)"
                                class="absolute top-2 left-2 w-7 h-7 rounded-full bg-red-500/80 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const assetType = '{{ $type }}';

    // Drag & drop + file input
    const uploadZone = document.getElementById('upload-zone');
    const fileInput = document.getElementById('file-input');

    ['dragenter', 'dragover'].forEach(evt => {
        uploadZone.addEventListener(evt, e => {
            e.preventDefault();
            uploadZone.classList.add('border-primary-400', 'bg-primary-50/30');
        });
    });

    ['dragleave', 'drop'].forEach(evt => {
        uploadZone.addEventListener(evt, e => {
            e.preventDefault();
            uploadZone.classList.remove('border-primary-400', 'bg-primary-50/30');
        });
    });

    uploadZone.addEventListener('drop', e => {
        const files = e.dataTransfer.files;
        uploadFiles(files);
    });

    fileInput.addEventListener('change', e => {
        uploadFiles(e.target.files);
        e.target.value = '';
    });

    async function uploadFiles(files) {
        const progressContainer = document.getElementById('upload-progress');
        progressContainer.classList.remove('hidden');

        for (const file of files) {
            const progressEl = document.createElement('div');
            progressEl.className = 'flex items-center gap-3 bg-slate-50 rounded-lg px-4 py-2';
            progressEl.innerHTML = `
                <span class="text-sm text-slate-600 flex-1 truncate">${file.name}</span>
                <span class="upload-status text-xs text-amber-600 font-medium">جاري الرفع...</span>
            `;
            progressContainer.appendChild(progressEl);

            const formData = new FormData();
            formData.append('type', assetType);
            formData.append('image', file);

            try {
                const res = await fetch('{{ route("admin.assets.upload") }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: formData,
                });

                if (!res.ok) throw new Error('Upload failed');

                const data = await res.json();
                progressEl.querySelector('.upload-status').textContent = 'تم ✓';
                progressEl.querySelector('.upload-status').className = 'upload-status text-xs text-emerald-600 font-medium';

                // Add to grid
                addAssetToGrid(data);
            } catch (err) {
                progressEl.querySelector('.upload-status').textContent = 'فشل ✗';
                progressEl.querySelector('.upload-status').className = 'upload-status text-xs text-red-600 font-medium';
            }
        }

        setTimeout(() => {
            progressContainer.innerHTML = '';
            progressContainer.classList.add('hidden');
        }, 3000);
    }

    function addAssetToGrid(data) {
        const grid = document.getElementById('assets-grid');
        if (!grid) {
            location.reload();
            return;
        }

        const card = document.createElement('div');
        card.className = 'group relative bg-slate-50 rounded-xl overflow-hidden border border-slate-100 hover:shadow-md transition-shadow';
        card.dataset.assetId = data.name;
        card.innerHTML = `
            <div class="aspect-square">
                <img src="${data.thumb_url}" alt="${data.name}" class="w-full h-full object-cover" loading="lazy">
            </div>
            <div class="p-2">
                <p class="text-xs text-slate-600 truncate font-medium">${data.name}</p>
            </div>
            <button onclick="deleteAsset('${assetType}', '${data.name}', this)"
                    class="absolute top-2 left-2 w-7 h-7 rounded-full bg-red-500/80 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </button>
        `;
        grid.prepend(card);
        lucide.createIcons();
    }

    async function deleteAsset(type, filename, btnEl) {
        if (!confirm('هل أنت متأكد من حذف هذا الملف؟')) return;

        try {
            const res = await fetch(`/admin/assets/${type}/${filename}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            });

            if (!res.ok) throw new Error('Delete failed');

            const card = btnEl.closest('[data-asset-id]');
            card.remove();
        } catch (err) {
            alert('فشل الحذف');
        }
    }
</script>
@endpush
