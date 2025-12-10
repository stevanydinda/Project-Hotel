<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-green-800 p-6 text-white">
            <h1 class="text-2xl font-bold text-center">PEMBAYARAN BOOKING</h1>
            <p class="text-center text-green-100 mt-2">Scan QR Code untuk menyelesaikan pembayaran</p>
        </div>

        <div class="p-6 text-center">
            <div class="mb-6">
                <div class="inline-block bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-bold mb-4">
                    Kode Booking: <?php echo e($booking->p_lu_Pemesanan); ?>

                </div>
                <p class="text-gray-600 mb-2">Total yang harus dibayar:</p>
                <p class="text-3xl font-bold text-green-600">
                    Rp <?php echo e(number_format($booking->room->harga * $booking->jnu_kamar_dipesan * \Carbon\Carbon::parse($booking->tgl_checkin)->diffInDays($booking->tgl_checkout), 0, ',', '.')); ?>

                </p>
            </div>

            <div class="border-4 border-dashed border-gray-200 rounded-2xl p-6 mb-4">
                <img src="<?php echo e($qrUrl); ?>" alt="QR Code Pembayaran" class="w-64 h-64 mx-auto" id="qrImage">
            </div>

            <button onclick="downloadQR()"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg">
                Download QR Code
            </button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function downloadQR() {
    const link = document.createElement('a');
    link.href = "<?php echo e($qrUrl); ?>";
    link.download = 'booking-qr-<?php echo e($booking->p_lu_Pemesanan); ?>.png';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\user\booking\payment.blade.php ENDPATH**/ ?>