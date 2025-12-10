<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">

    
    <nav class="mb-6 text-sm font-medium text-gray-700">
        <a href="<?php echo e(route('home')); ?>" class="text-blue-600 hover:text-blue-800">Home</a>
        <span class="mx-2">/</span>
        <span class="text-gray-500">Riwayat Booking</span>
    </nav>

    <h1 class="text-2xl font-bold mb-6">Riwayat Booking Saya</h1>

    <?php if($bookings->isEmpty()): ?>
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
            <i class="fas fa-calendar-times text-yellow-500 text-4xl mb-4"></i>
            <p class="text-gray-700">Anda belum memiliki booking</p>
            <a href="<?php echo e(route('user.jenis_kamar')); ?>" class="text-blue-600 hover:text-blue-800 font-semibold">
                <i class="fas fa-bed mr-2"></i>Booking kamar sekarang
            </a>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto bg-white rounded-xl shadow">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kamar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check-in</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check-out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $nights = \Carbon\Carbon::parse($booking->tgl_checkin)->diffInDays($booking->tgl_checkout);
                            $statusColors = [
                                'Pending' => 'bg-yellow-100 text-yellow-800',
                                'Pending Payment' => 'bg-blue-100 text-blue-800',
                                'Dikonfirmasi' => 'bg-green-100 text-green-800',
                                'Diterima' => 'bg-green-100 text-green-800',
                                'Selesai' => 'bg-indigo-100 text-indigo-800',
                                'Batal' => 'bg-red-100 text-red-800'
                            ];
                            $colorClass = $statusColors[$booking->status_pemesanan] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <tr>
                            <td class="px-6 py-4"><?php echo e($booking->p_lu_Pemesanan); ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <?php if($booking->rooms->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $booking->rooms->image)); ?>" class="w-10 h-10 object-cover rounded mr-3">
                                    <?php endif; ?>
                                    <span><?php echo e($booking->rooms->name); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4"><?php echo e(date('d M Y', strtotime($booking->tgl_checkin))); ?></td>
                            <td class="px-6 py-4"><?php echo e(date('d M Y', strtotime($booking->tgl_checkout))); ?></td>
                            <td class="px-6 py-4 font-semibold">Rp <?php echo e(number_format($booking->total_harga,0,',','.')); ?></td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold <?php echo e($colorClass); ?>">
                                    <?php echo e($booking->status_pemesanan); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    
                                    <?php if($booking->status_pemesanan == 'Pending'): ?>
                                        <a href="<?php echo e(route('user.booking.summary', $booking->id)); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">Bayar</a>
                                        <form action="<?php echo e(route('user.booking.cancel', $booking->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" onclick="return confirm('Batalkan booking?')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Batal</button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if(in_array(strtolower($booking->status_pemesanan), ['diterima'])): ?>
                                        <a href="<?php echo e(route('user.booking.qr', $booking->id)); ?>"
                                           class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                           Lihat QR
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6"><?php echo e($bookings->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\user\booking\index.blade.php ENDPATH**/ ?>