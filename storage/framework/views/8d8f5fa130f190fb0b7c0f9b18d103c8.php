<?php
    $adCode = \App\Models\Setting::get($key ?? '', '');
?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($adCode): ?>
<div class="ad-slot-wrapper max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 text-center">
    <?php echo $adCode; ?>

</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH D:\Development\Webhoclieu-laravel\resources\views/components/ad-slot.blade.php ENDPATH**/ ?>