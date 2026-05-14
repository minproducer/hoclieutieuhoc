

<?php $__env->startSection('title', ($document->meta_title ?: $document->title) . ' - ' . \App\Models\Setting::get('site_name', 'HocLieuTieuHoc')); ?>
<?php $__env->startSection('description', $document->meta_description ?: Str::limit($document->description ?? '', 160)); ?>

<?php $__env->startSection('meta'); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->thumbnail_display_url): ?>

<meta property="og:image" content="<?php echo e($document->thumbnail_display_url); ?>">
<meta name="twitter:image" content="<?php echo e($document->thumbnail_display_url); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<meta property="og:type" content="article">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    use Illuminate\Support\Str;
    $fileTypeColors = [
        'pdf'   => 'badge-pdf',
        'docx'  => 'badge-docx',
        'pptx'  => 'badge-pptx',
        'xlsx'  => 'badge-xlsx',
        'zip'   => 'badge-zip',
        'image' => 'badge-image',
    ];
    $fileTypeIcons = [
        'pdf'   => 'fa-file-pdf',
        'docx'  => 'fa-file-word',
        'pptx'  => 'fa-file-powerpoint',
        'xlsx'  => 'fa-file-excel',
        'zip'   => 'fa-file-zipper',
        'image' => 'fa-file-image',
    ];
    $gradeGroup = null;
    if ($document->grade_level) {
        if ($document->grade_level <= 5) $gradeGroup = 'Tiểu học';
        elseif ($document->grade_level <= 9) $gradeGroup = 'THCS';
        else $gradeGroup = 'THPT';
    }
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="<?php echo e(route('home')); ?>" class="hover:text-primary-600">Trang chủ</a>
        <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->category): ?>
        <a href="<?php echo e(route('category.show', $document->category->slug)); ?>" class="hover:text-primary-600">
            <?php echo e($document->category->name); ?>

        </a>
        <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <span class="text-gray-700 font-medium truncate max-w-xs"><?php echo e($document->title); ?></span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        
        <div class="lg:col-span-1 space-y-4">

            
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

                
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-primary-50 flex items-center justify-center">
                        <i class="fa-solid <?php echo e($fileTypeIcons[$document->file_type] ?? 'fa-file'); ?> text-3xl text-primary-400"></i>
                    </div>
                    <div>
                        <span class="inline-block <?php echo e($fileTypeColors[$document->file_type] ?? ''); ?> text-xs font-bold px-2.5 py-1 rounded-full uppercase mb-1">
                            <?php echo e(strtoupper($document->file_type)); ?>

                        </span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->file_size_kb): ?>
                        <div class="text-xs text-gray-500"><?php echo e($document->file_size_formatted); ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <h1 class="text-lg font-bold text-gray-900 mb-3 leading-snug"><?php echo e($document->title); ?></h1>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->description): ?>
                <p class="text-sm text-gray-600 mb-4 leading-relaxed"><?php echo e($document->description); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <dl class="space-y-2 text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->category): ?>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-folder text-gray-400 w-4"></i>Môn học
                        </dt>
                        <dd>
                            <a href="<?php echo e(route('category.show', $document->category->slug)); ?>"
                               class="text-primary-600 hover:underline font-medium">
                                <?php echo e($document->category->name); ?>

                            </a>
                        </dd>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->grade_level): ?>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-graduation-cap text-gray-400 w-4"></i>Khối lớp
                        </dt>
                        <dd class="text-gray-700 font-medium">Lớp <?php echo e($document->grade_level); ?> · <?php echo e($gradeGroup); ?></dd>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->page_count): ?>
                    <div class="flex justify-between">
                        <dt class="text-gray-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-file-lines text-gray-400 w-4"></i>Số trang
                        </dt>
                        <dd class="text-gray-700"><?php echo e(number_format($document->page_count)); ?> trang</dd>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="flex justify-between">
                        <dt class="text-gray-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-eye text-gray-400 w-4"></i>Lượt xem
                        </dt>
                        <dd class="text-gray-700"><?php echo e(number_format($document->view_count)); ?></dd>
                    </div>

                    <div class="flex justify-between">
                        <dt class="text-gray-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-download text-gray-400 w-4"></i>Lượt tải
                        </dt>
                        <dd class="text-gray-700"><?php echo e(number_format($document->download_count)); ?></dd>
                    </div>

                    <div class="flex justify-between">
                        <dt class="text-gray-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar text-gray-400 w-4"></i>Đăng lúc
                        </dt>
                        <dd class="text-gray-700"><?php echo e($document->created_at->format('d/m/Y')); ?></dd>
                    </div>
                </dl>

                
                <?php echo $__env->make('components.ad-slot', ['key' => 'ad_slot_in_content'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->drive_file_id): ?>
                <a href="<?php echo e(route('document.download.page', $document->slug)); ?>"
                   class="mt-6 w-full flex items-center justify-center gap-2 bg-accent-500 hover:bg-accent-600 text-white font-bold py-3 px-6 rounded-xl transition-colors shadow-md hover:shadow-lg">
                    <i class="fa-solid fa-download"></i>
                    Tải xuống miễn phí
                </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <a href="<?php echo e(url()->previous()); ?>"
                   class="mt-3 w-full flex items-center justify-center gap-2 text-sm text-gray-500 hover:text-gray-700 py-2 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                    Quay lại
                </a>
            </div>
        </div>

        
        <div class="lg:col-span-2 space-y-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->drive_file_id): ?>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-eye text-gray-400"></i>
                    <span class="text-sm font-medium text-gray-700">Xem trước tài liệu</span>
                </div>
                <iframe
                    src="https://drive.google.com/file/d/<?php echo e($document->drive_file_id); ?>/preview"
                    class="w-full"
                    style="height:clamp(320px, 60vh, 700px);"
                    allow="autoplay"
                    loading="lazy"
                    title="Preview: <?php echo e($document->title); ?>">
                </iframe>
            </div>
            <?php else: ?>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 flex flex-col items-center justify-center text-center">
                <i class="fa-solid fa-file-circle-question text-6xl text-gray-200 mb-4"></i>
                <p class="text-gray-500">Chưa có file xem trước cho tài liệu này.</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->content): ?>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-bold text-gray-800 mb-4">
                    <i class="fa-solid fa-circle-info text-primary-400 mr-2"></i>Thông tin chi tiết
                </h2>
                <div class="prose prose-sm max-w-none text-gray-700">
                    <?php echo $document->content; ?>

                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php echo $__env->make('components.ad-slot', ['key' => 'ad_slot_sidebar'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedByCategory->isNotEmpty() || $relatedByGrade->isNotEmpty()): ?>
            <div id="related-section">
                
                <div class="flex items-center gap-1 mb-5">
                    <h2 class="font-bold text-gray-800 mr-3">
                        <i class="fa-solid fa-layer-group text-primary-400 mr-2"></i>Tài liệu liên quan
                    </h2>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedByCategory->isNotEmpty()): ?>
                    <button onclick="switchRelatedTab('category')" id="tab-btn-category"
                            class="related-tab-btn active flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold transition-all bg-primary-600 text-white shadow-sm">
                        <i class="fa-solid fa-folder"></i>
                        <?php echo e($relatedLabel); ?>

                        <span class="opacity-70">(<?php echo e($relatedByCategory->count()); ?>)</span>
                    </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedByGrade->isNotEmpty()): ?>
                    <button onclick="switchRelatedTab('grade')" id="tab-btn-grade"
                            class="related-tab-btn flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
                        <i class="fa-solid fa-graduation-cap"></i>
                        Lớp <?php echo e($document->grade_level); ?>

                        <span class="opacity-70">(<?php echo e($relatedByGrade->count()); ?>)</span>
                    </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedByCategory->isNotEmpty()): ?>
                <div id="tab-panel-category" class="related-tab-panel">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $relatedByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal1869097a6231e2ce70c4554b764f4faa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1869097a6231e2ce70c4554b764f4faa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.document-card','data' => ['document' => $related]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('document-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['document' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1869097a6231e2ce70c4554b764f4faa)): ?>
<?php $attributes = $__attributesOriginal1869097a6231e2ce70c4554b764f4faa; ?>
<?php unset($__attributesOriginal1869097a6231e2ce70c4554b764f4faa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1869097a6231e2ce70c4554b764f4faa)): ?>
<?php $component = $__componentOriginal1869097a6231e2ce70c4554b764f4faa; ?>
<?php unset($__componentOriginal1869097a6231e2ce70c4554b764f4faa); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->category): ?>
                    <div class="mt-4 text-center">
                        <a href="<?php echo e(route('category.show', $document->category->slug)); ?>"
                           class="inline-flex items-center gap-2 text-sm text-primary-600 hover:text-primary-700 font-semibold hover:underline">
                            Xem tất cả trong <?php echo e($document->category->name); ?>

                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedByGrade->isNotEmpty()): ?>
                <div id="tab-panel-grade" class="related-tab-panel" style="display:none">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $relatedByGrade; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal1869097a6231e2ce70c4554b764f4faa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1869097a6231e2ce70c4554b764f4faa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.document-card','data' => ['document' => $related]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('document-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['document' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1869097a6231e2ce70c4554b764f4faa)): ?>
<?php $attributes = $__attributesOriginal1869097a6231e2ce70c4554b764f4faa; ?>
<?php unset($__attributesOriginal1869097a6231e2ce70c4554b764f4faa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1869097a6231e2ce70c4554b764f4faa)): ?>
<?php $component = $__componentOriginal1869097a6231e2ce70c4554b764f4faa; ?>
<?php unset($__componentOriginal1869097a6231e2ce70c4554b764f4faa); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="<?php echo e(route('search', ['grade' => $document->grade_level])); ?>"
                           class="inline-flex items-center gap-2 text-sm text-emerald-600 hover:text-emerald-700 font-semibold hover:underline">
                            Xem thêm tài liệu Lớp <?php echo e($document->grade_level); ?>

                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function switchRelatedTab(name) {
    // Update panels
    document.querySelectorAll('.related-tab-panel').forEach(function(el) {
        el.style.display = 'none';
        el.style.opacity = '0';
    });
    var panel = document.getElementById('tab-panel-' + name);
    if (panel) {
        panel.style.display = 'block';
        requestAnimationFrame(function() { panel.style.transition = 'opacity .2s'; panel.style.opacity = '1'; });
    }
    // Update buttons
    document.querySelectorAll('.related-tab-btn').forEach(function(btn) {
        btn.classList.remove('bg-primary-600','bg-emerald-600','text-white','shadow-sm');
        btn.classList.add('bg-gray-100','text-gray-600');
    });
    var activeBtn = document.getElementById('tab-btn-' + name);
    if (activeBtn) {
        activeBtn.classList.remove('bg-gray-100','text-gray-600');
        activeBtn.classList.add(name === 'grade' ? 'bg-emerald-600' : 'bg-primary-600', 'text-white', 'shadow-sm');
    }
}

// Lazy load document card images with IntersectionObserver
if ('IntersectionObserver' in window) {
    var imgObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                imgObserver.unobserve(img);
            }
        });
    }, { rootMargin: '200px' });
    document.querySelectorAll('img[data-src]').forEach(function(img) { imgObserver.observe(img); });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Development\Webhoclieu-laravel\resources\views/documents/show.blade.php ENDPATH**/ ?>