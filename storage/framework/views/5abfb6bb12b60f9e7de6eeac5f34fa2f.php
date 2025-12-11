<?php $__env->startSection('content'); ?>
    <div class="container mt-4">

        <h2 class="text-xl font-bold mb-4">Trash Booking</h2>

        <table class="table-auto w-full border">
            <thead class="bg-gray-300">
                <tr>
                    <th class="p-2 border">Kode Booking</th>
                    <th class="p-2 border">User</th>
                    <th class="p-2 border">Kamar</th>
                    <th class="p-2 border">Jumlah</th>
                    <th class="p-2 border">Tanggal Dihapus</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="border p-2"><?php echo e($booking->p_lu_Pemesanan); ?></td>
                        <td class="border p-2"><?php echo e($booking->user->name ?? '-'); ?></td>
                        <td class="border p-2"><?php echo e($booking->rooms->tipe_kamar ?? '-'); ?></td>
                        <td class="border p-2"><?php echo e($booking->jnu_kamar_dipesan); ?></td>
                        <td class="border p-2"><?php echo e($booking->deleted_at); ?></td>

                        <td class="border p-2">
                            <div class="flex space-x-2">

                                
                                <form action="<?php echo e(route('admin.bookings.restore', $booking->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button class="bg-green-500 text-white px-2 py-1 rounded">
                                        Restore
                                    </button>
                                </form>

                                
                                <form action="<?php echo e(route('admin.bookings.deletePermanent', $booking->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="bg-red-600 text-white px-3 py-1 rounded">Hapus Permanen</button>
                                </form>

                            </div>
                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data di Trash</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\admin\booking\trash.blade.php ENDPATH**/ ?>