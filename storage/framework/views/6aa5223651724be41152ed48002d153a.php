<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6 max-w-2xl">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <!-- Header -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-700 p-6 text-white">
            <h1 class="text-2xl font-bold">Update Booking</h1>
            <p class="text-yellow-100 text-sm">Kode: <?php echo e($booking->p_lu_Pemesanan); ?></p>
        </div>

        <div class="p-6">
            <form action="<?php echo e(route('user.booking.update', $booking->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Check-in -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Tanggal Check-in</label>
                    <input type="date"
                           name="tgl_checkin"
                           class="w-full px-3 py-2 border rounded-lg"
                           value="<?php echo e($booking->tgl_checkin); ?>"
                           required>
                </div>

                <!-- Check-out -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Tanggal Check-out</label>
                    <input type="date"
                           name="tgl_checkout"
                           class="w-full px-3 py-2 border rounded-lg"
                           value="<?php echo e($booking->tgl_checkout); ?>"
                           required>
                </div>

                <!-- Jumlah kamar -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Jumlah Kamar</label>
                    <input type="number"
                           name="jnu_kamar_dipesan"
                           min="1"
                           max="<?php echo e($booking->room->stok); ?>"
                           class="w-full px-3 py-2 border rounded-lg"
                           value="<?php echo e($booking->jnu_kamar_dipesan); ?>"
                           required>
                    <p class="text-sm text-gray-500">
                        Stok tersedia: <?php echo e($booking->room->stok); ?> kamar
                    </p>
                </div>

                <!-- Status Pemesanan -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Status</label>
                    <select name="status_pemesanan"
                            class="w-full px-3 py-2 border rounded-lg">
                        <option value="Pending" <?php echo e($booking->status_pemesanan == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="Pending Payment" <?php echo e($booking->status_pemesanan == 'Pending Payment' ? 'selected' : ''); ?>>Pending Payment</option>
                        <option value="Dikonfirmasi" <?php echo e($booking->status_pemesanan == 'Dikonfirmasi' ? 'selected' : ''); ?>>Dikonfirmasi</option>
                        <option value="Selesai" <?php echo e($booking->status_pemesanan == 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                        <option value="Batal" <?php echo e($booking->status_pemesanan == 'Batal' ? 'selected' : ''); ?>>Batal</option>
                    </select>
                </div>

                <!-- Total Harga (readonly) -->
                <div class="mb-6">
                    <label class="block text-gray-700 mb-1">Total Harga</label>
                    <input type="text"
                           class="w-full px-3 py-2 border rounded-lg bg-gray-100"
                           value="Rp <?php echo e(number_format($booking->total_harga, 0, ',', '.')); ?>"
                           readonly>
                    <p class="text-xs text-gray-500 mt-1">
                        Total harga akan dihitung ulang otomatis oleh sistem.
                    </p>
                </div>

                <!-- Tombol -->
                <button type="submit"
                        class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>

                <a href="<?php echo e(route('user.bookings')); ?>"
                   class="block text-center mt-4 text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\user\booking\edit.blade.php ENDPATH**/ ?>