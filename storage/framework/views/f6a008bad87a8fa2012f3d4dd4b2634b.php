<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['document']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['document']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $fileTypeLabels = [
        'pdf'   => 'PDF',
        'docx'  => 'DOCX',
        'pptx'  => 'PPTX',
        'xlsx'  => 'XLSX',
        'zip'   => 'ZIP',
        'image' => 'Ảnh',
    ];
    $fileTypeIcons = [
        'pdf'   => 'fa-file-pdf',
        'docx'  => 'fa-file-word',
        'pptx'  => 'fa-file-powerpoint',
        'xlsx'  => 'fa-file-excel',
        'zip'   => 'fa-file-zipper',
        'image' => 'fa-file-image',
    ];
    $gradeLevelGroup = null;
    if ($document->grade_level !== null && $document->grade_level !== '') {
        if ($document->grade_level == 0) $gradeLevelGroup = 'Tiền Tiểu học';
        elseif ($document->grade_level <= 5) $gradeLevelGroup = 'Lớp ' . $document->grade_level;
    }
?>

<a href="<?php echo e(route('document.show', $document->slug)); ?>"
   class="group bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col overflow-hidden">

    
    <div class="relative h-36 bg-gradient-to-br from-primary-50 to-blue-50 flex items-center justify-center">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->thumbnail_display_url): ?>
            <img src="<?php echo e($document->thumbnail_display_url); ?>" alt="<?php echo e($document->title); ?>"
                 loading="lazy" decoding="async"
                 class="w-full h-full object-cover">
        <?php else: ?>
            <i class="fa-solid <?php echo e($fileTypeIcons[$document->file_type] ?? 'fa-file'); ?> text-5xl text-primary-200 group-hover:text-primary-300 transition-colors"></i>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <span class="absolute top-2 right-2 badge-<?php echo e($document->file_type); ?> text-xs font-bold px-2 py-0.5 rounded-full uppercase">
            <?php echo e($fileTypeLabels[$document->file_type] ?? strtoupper($document->file_type)); ?>

        </span>
    </div>

    
    <div class="flex flex-col flex-1 p-4">
        
        <h3 class="font-semibold text-gray-800 text-sm leading-snug line-clamp-2 group-hover:text-primary-600 transition-colors mb-2">
            <?php echo e($document->title); ?>

        </h3>

        
        <div class="flex flex-wrap gap-1 mb-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->category): ?>
            <span class="inline-flex items-center gap-1 text-xs bg-primary-50 text-primary-700 px-2 py-0.5 rounded-full">
                <i class="fa-solid fa-folder text-primary-400 text-[10px]"></i>
                <?php echo e($document->category->name); ?>

            </span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gradeLevelGroup): ?>
            <span class="inline-flex items-center gap-1 text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">
                <?php echo e($gradeLevelGroup); ?>

            </span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="mt-auto flex items-center justify-between text-xs text-gray-400">
            <span class="flex items-center gap-1">
                <i class="fa-solid fa-eye"></i>
                <?php echo e(number_format($document->view_count)); ?>

            </span>
            <span class="flex items-center gap-1">
                <i class="fa-solid fa-download"></i>
                <?php echo e(number_format($document->download_count)); ?>

            </span>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->file_size_kb): ?>
            <span><?php echo e($document->file_size_formatted); ?></span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</a>
<?php /**PATH D:\Development\Webhoclieu-laravel\resources\views/components/document-card.blade.php ENDPATH**/ ?>