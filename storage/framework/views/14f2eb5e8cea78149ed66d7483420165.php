<?php $__env->startSection('content'); ?>
    <div class="container mx-auto mt-6 px-4">

        <?php if(Session::get('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo e(Session::get('success')); ?>

            </div>
        <?php endif; ?>

        <div class="flex justify-end space-x-2 mb-4">
            <div class="flex space-x-2">
                <a href="<?php echo e(url()->previous()); ?>"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
        <h5 class="mb-3 text-xl font-semibold text-center">Riwayat Booking</h5>
        <table id="tableBooking" class="min-w-[70%] mx-auto border border-gray-300 rounded-lg shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">#</th
                    <th class="p-3">KodeBooking</th>
                    <th class="p-3">Kamar</th>
                    <th class="p-3">Check-in</th>
                    <th class="p-3">Check-out</th>
                    <th class="p-3">Jumlah Kamar</th>
                    <th class="p-3">Total Harga</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="p-3 text-center"><?php echo e($loop->iteration); ?></td>
                        <td class="p-3 text-center"><?php echo e($booking->p_lu_Pemesanan); ?></td>
                        <td class="p-3 text-center"><?php echo e($booking->room->nama_kamar); ?></td>
                        <td class="p-3 text-center"><?php echo e($booking->tgl_checkin); ?></td>
                        <td class="p-3 text-center"><?php echo e($booking->tgl_checkout); ?></td>
                        <td class="p-3 text-center"><?php echo e($booking->jnu_kamar_dipesan); ?></td>
                        <td class="p-3 text-center">Rp <?php echo e(number_format($booking->total_harga, 0, ',', '.')); ?></td>
                        <td class="p-3 text-center"><?php echo e($booking->status_pemesanan); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\user\booking\history.blade.php ENDPATH**/ ?>