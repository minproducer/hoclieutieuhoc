

<?php $__env->startSection('title', 'Tìm kiếm tài liệu' . ($q ? " — {$q}" : '') . ' - HocLieuTieuHoc'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    
    <div class="mb-6">
        <form action="<?php echo e(route('search')); ?>" method="GET" class="flex gap-2">
            <div class="flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="q" value="<?php echo e($q); ?>"
                       placeholder="Tìm tài liệu, đề thi, bài giảng..."
                       class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 bg-white text-gray-800">
                <input type="hidden" name="sort" value="<?php echo e($sort); ?>">
            </div>
            <button type="submit"
                    class="bg-primary-500 hover:bg-primary-600 text-white font-semibold px-6 py-3 rounded-xl transition-colors">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span class="hidden sm:inline ml-1">Tìm kiếm</span>
            </button>
        </form>
    </div>

    <div class="flex flex-col md:flex-row gap-6">

        
        <aside class="w-full md:w-64 flex-shrink-0">
            <form action="<?php echo e(route('search')); ?>" method="GET" id="filter-form">
                <input type="hidden" name="q" value="<?php echo e($q); ?>">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-6">

                    
                    <div>
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">Sắp xếp theo</h3>
                        <div class="space-y-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['newest' => 'Mới nhất', 'popular' => 'Xem nhiều nhất', 'downloads' => 'Tải nhiều nhất']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sortVal => $sortLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="sort" value="<?php echo e($sortVal); ?>"
                                       <?php echo e($sort === $sortVal ? 'checked' : ''); ?>

                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700"><?php echo e($sortLabel); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div>
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">
                            <i class="fa-solid fa-layer-group text-primary-400 mr-1"></i>Khối lớp
                        </h3>
                        <div class="space-y-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="grade_cat" value=""
                                       <?php echo e($gradeCatSlug === '' ? 'checked' : ''); ?>

                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">Tất cả</span>
                            </label>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $topCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="grade_cat" value="<?php echo e($topCat->slug); ?>"
                                       <?php echo e($gradeCatSlug === $topCat->slug ? 'checked' : ''); ?>

                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700 flex-1"><?php echo e($topCat->name); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gradeCatSlug !== '' && $availableSubjects->isNotEmpty()): ?>
                    <div>
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">
                            <i class="fa-solid fa-book text-primary-400 mr-1"></i>Môn học
                        </h3>
                        <input type="hidden" name="grade_cat" value="<?php echo e($gradeCatSlug); ?>">
                        <div class="space-y-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="mon" value=""
                                       <?php echo e($mon === '' ? 'checked' : ''); ?>

                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">Tất cả môn</span>
                            </label>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $availableSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="mon" value="<?php echo e($subj); ?>"
                                       <?php echo e($mon === $subj ? 'checked' : ''); ?>

                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700"><?php echo e($subj); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gradeCatSlug !== '' && $availableDocTypes->isNotEmpty()): ?>
                    <div>
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">
                            <i class="fa-solid fa-palette text-primary-400 mr-1"></i>Hoạt động
                        </h3>
                        <input type="hidden" name="grade_cat" value="<?php echo e($gradeCatSlug); ?>">
                        <div class="space-y-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="mon" value=""
                                       <?php echo e($mon === '' ? 'checked' : ''); ?>

                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">Tất cả</span>
                            </label>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $availableDocTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="mon" value="<?php echo e($dt); ?>"
                                       <?php echo e($mon === $dt ? 'checked' : ''); ?>

                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700"><?php echo e($dt); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mon !== '' && $availableDangBai->isNotEmpty()): ?>
                    <div>
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">
                            <i class="fa-solid fa-pen-to-square text-primary-400 mr-1"></i>Dạng bài
                        </h3>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gradeCatSlug !== ''): ?><input type="hidden" name="grade_cat" value="<?php echo e($gradeCatSlug); ?>"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <input type="hidden" name="mon" value="<?php echo e($mon); ?>">
                        <div class="space-y-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="dang" value=""
                                       <?php echo e($dang === '' ? 'checked' : ''); ?>

                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">Tất cả dạng</span>
                            </label>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $availableDangBai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dangVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="dang" value="<?php echo e($dangVal); ?>"
                                       <?php echo e($dang === $dangVal ? 'checked' : ''); ?>

                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700"><?php echo e($dangVal); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div>
                        <h3 class="font-semibold text-gray-700 text-sm mb-3">
                            <i class="fa-solid fa-file text-primary-400 mr-1"></i>Loại tệp
                        </h3>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gradeCatSlug !== '' && $availableSubjects->isEmpty() && $availableDocTypes->isEmpty()): ?>
                            <input type="hidden" name="grade_cat" value="<?php echo e($gradeCatSlug); ?>">
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mon !== '' && $availableDangBai->isEmpty()): ?><input type="hidden" name="mon" value="<?php echo e($mon); ?>"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dang !== ''): ?><input type="hidden" name="dang" value="<?php echo e($dang); ?>"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="type" value=""
                                       <?php echo e($type === '' ? 'checked' : ''); ?>

                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700">Tất cả</span>
                            </label>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['pdf' => 'PDF', 'docx' => 'Word', 'pptx' => 'PowerPoint', 'xlsx' => 'Excel', 'zip' => 'ZIP']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeVal => $typeLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="type" value="<?php echo e($typeVal); ?>"
                                       <?php echo e($type === $typeVal ? 'checked' : ''); ?>

                                       class="text-primary-500"
                                       onchange="document.getElementById('filter-form').submit()">
                                <span class="text-sm text-gray-700"><?php echo e($typeLabel); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($q || $gradeCatSlug || $mon || $dang || $type): ?>
                    <a href="<?php echo e(route('search')); ?>"
                       class="block text-center text-sm text-accent-500 hover:text-accent-600 font-medium">
                        <i class="fa-solid fa-xmark mr-1"></i>Xoá bộ lọc
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </form>

            
            <?php echo $__env->make('components.ad-slot', ['key' => 'ad_slot_sidebar'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </aside>

        
        <div class="flex-1 min-w-0">

            
            <?php echo $__env->make('components.ad-slot', ['key' => 'ad_slot_in_content'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-gray-500">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($q): ?>
                    Kết quả cho <strong class="text-gray-800">"<?php echo e($q); ?>"</strong> —
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <strong class="text-gray-800"><?php echo e(number_format($results->total())); ?></strong> tài liệu
                </p>
                <span class="text-sm text-gray-400">
                    Trang <?php echo e($results->currentPage()); ?> / <?php echo e($results->lastPage()); ?>

                </span>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($results->isEmpty()): ?>
            <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
                <i class="fa-solid fa-face-frown text-6xl text-gray-200 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Không tìm thấy tài liệu</h3>
                <p class="text-sm text-gray-400 mb-6">Thử từ khoá khác hoặc xoá bộ lọc</p>
                <a href="<?php echo e(route('search')); ?>"
                   class="inline-flex items-center gap-2 bg-primary-500 text-white text-sm font-medium px-5 py-2.5 rounded-xl hover:bg-primary-600 transition-colors">
                    <i class="fa-solid fa-rotate-left"></i>Xem tất cả tài liệu
                </a>
            </div>
            <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

            
            <?php echo e($results->links('components.pagination')); ?>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Development\Webhoclieu-laravel\resources\views/search/index.blade.php ENDPATH**/ ?>