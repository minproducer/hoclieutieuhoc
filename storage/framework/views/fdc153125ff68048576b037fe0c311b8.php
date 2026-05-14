

<?php $__env->startSection('title', '404 — Không tìm thấy trang'); ?>
<?php $__env->startSection('code', '404'); ?>
<?php $__env->startSection('heading', 'Trang này đi đâu mất rồi!'); ?>
<?php $__env->startSection('message', 'Hổ con tìm mãi không thấy trang bạn yêu cầu. Có thể đường dẫn bị sai hoặc trang đã bị xoá rồi 🐯'); ?>

<?php $__env->startSection('tiger-eyes'); ?>
    
    <g class="tiger-eye"><circle cx="60" cy="65" r="9" fill="#1a1a1a"/><circle cx="57" cy="62" r="3" fill="white"/></g>
    <g class="tiger-eye" style="animation-delay:.5s"><circle cx="96" cy="65" r="9" fill="#1a1a1a"/><circle cx="93" cy="62" r="3" fill="white"/></g>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('tiger-mouth'); ?>
    
    <path d="M73 90 Q80 85 87 90" stroke="#BF360C" stroke-width="2" fill="none" stroke-linecap="round"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('tiger-extra'); ?>
    
    <ellipse cx="108" cy="48" rx="5" ry="7" fill="#93c5fd" opacity="0.9"/>
    <path d="M108 41 Q112 46 108 55 Q104 46 108 41" fill="#93c5fd" opacity="0.9"/>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Development\Webhoclieu-laravel\resources\views/errors/404.blade.php ENDPATH**/ ?>