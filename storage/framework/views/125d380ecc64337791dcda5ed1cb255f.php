

<?php $__env->startSection('title', $category->name . ' - ' . \App\Models\Setting::get('site_name', 'HocLieuTieuHoc')); ?>
<?php $__env->startSection('description', $category->description ?: "Tài liệu môn {$category->name} — PDF, DOCX, PPTX cho tất cả khối lớp. Tải miễn phí tại " . \App\Models\Setting::get('site_name', 'HocLieuTieuHoc') . "."); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="<?php echo e(route('home')); ?>" class="hover:text-primary-600">Trang chủ</a>
        <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
        <span class="text-gray-700 font-medium"><?php echo e($category->name); ?></span>
    </nav>

    
    <div class="bg-gradient-to-r from-primary-600 to-primary-500 text-white rounded-2xl p-8 mb-8 flex items-center gap-6">
        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0">
            <i class="fa-solid <?php echo e($category->icon ?? 'fa-folder'); ?> text-3xl text-white"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold mb-1"><?php echo e($category->name); ?></h1>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category->description): ?>
            <p class="text-primary-100 text-sm"><?php echo e($category->description); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="flex items-center gap-4 mt-3 text-sm text-primary-200">
                <span><i class="fa-solid fa-file-lines mr-1"></i><?php echo e(number_format($documents->total())); ?> tài liệu</span>
            </div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category->children->isNotEmpty()): ?>
    <div class="mb-8">
        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Chọn môn / dạng đề</h2>
        <div class="flex flex-wrap gap-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $category->children->sortBy('sort_order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('category.show', $child->slug)); ?>"
               class="flex items-center gap-2 bg-white border border-gray-200 hover:border-primary-400 hover:bg-primary-50 hover:text-primary-700 text-gray-700 rounded-xl px-4 py-2 text-sm font-medium transition-colors shadow-sm">
                <i class="fa-solid <?php echo e($child->icon ?? 'fa-folder'); ?> text-primary-400 text-xs"></i>
                <?php echo e($child->name); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($documents->isEmpty()): ?>
    <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
        <i class="fa-solid fa-folder-open text-6xl text-gray-200 mb-4"></i>
        <h3 class="text-lg font-semibold text-gray-600 mb-2">Chưa có tài liệu nào</h3>
        <p class="text-sm text-gray-400">Danh mục này chưa có tài liệu. Quay lại sau nhé!</p>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if (isset($component)) { $__componentOriginal1869097a6231e2ce70c4554b764f4faa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1869097a6231e2ce70c4554b764f4faa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.document-card','data' => ['document' => $doc]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('document-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['document' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($doc)]); ?>
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

    
    <?php echo e($documents->links('components.pagination')); ?>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Development\Webhoclieu-laravel\resources\views/categories/show.blade.php ENDPATH**/ ?>