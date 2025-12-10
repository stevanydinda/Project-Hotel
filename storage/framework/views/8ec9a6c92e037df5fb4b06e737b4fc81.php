<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2>Detail Booking</h2>

        <div class="card">
            <div class="card-body">

                <p><strong>Kode Booking:</strong> <?php echo e($booking->kode_pemesanan); ?></p>
                <p><strong>Nama Kamar:</strong> <?php echo e($booking->room->nama_kamar); ?></p>
                <p><strong>Check-in:</strong> <?php echo e($booking->tgl_checkin); ?></p>
                <p><strong>Check-out:</strong> <?php echo e($booking->tgl_checkout); ?></p>
                <p><strong>Jumlah Kamar:</strong> <?php echo e($booking->jumlah_kamar_dipesan); ?></p>

                <p><strong>Status:</strong>
                    <span
                        class="badge
                    <?php if($booking->status_pemesanan == 'Pending'): ?> bg-warning
                    <?php elseif($booking->status_pemesanan == 'Diterima'): ?> bg-success
                    <?php else: ?> bg-danger <?php endif; ?>">
                        <?php echo e($booking->status_pemesanan); ?>

                    </span>
                </p>

                <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn btn-secondary mt-3">Kembali</a>


                <a href="<?php echo e(route('admin.bookings.edit', $booking->id)); ?>" class="btn btn-primary mt-3">Update Booking</a>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\admin\booking\detail.blade.php ENDPATH**/ ?>