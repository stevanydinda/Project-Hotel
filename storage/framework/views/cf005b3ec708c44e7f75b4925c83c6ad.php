<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6 text-center">
    <h1 class="text-2xl font-bold mb-4">QR Code Check-in</h1>

    <p class="text-gray-600 mb-6">
        Tunjukkan QR Code ini saat check-in di hotel.
    </p>

    <div class="inline-block p-4 bg-white shadow-lg rounded-xl">
        <?php echo $qrCode; ?>

    </div>

    <div class="mt-6">
        <a href="<?php echo e(route('user.my.bookings')); ?>" class="text-blue-600 hover:text-blue-800">
            ← Kembali ke Riwayat Booking
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\user\booking\qr.blade.php ENDPATH**/ ?>