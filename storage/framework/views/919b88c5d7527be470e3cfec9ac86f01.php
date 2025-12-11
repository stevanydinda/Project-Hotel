<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">

    
    <nav class="mb-8 text-sm font-medium text-gray-700">
        <a href="<?php echo e(route('home')); ?>" class="text-blue-600 hover:text-blue-800">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-500">Riwayat Booking</span>
    </nav>

    
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Riwayat Booking Saya</h1>

    
    <?php if($bookings->isEmpty()): ?>
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-10 text-center shadow-sm">
            <i class="fas fa-calendar-times text-yellow-500 text-5xl mb-4"></i>
            <p class="text-gray-700 text-lg mb-3">Anda belum memiliki booking.</p>
            <a href="<?php echo e(route('user.jenis_kamar')); ?>"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg transition">
                <i class="fas fa-bed"></i> Booking Kamar Sekarang
            </a>
        </div>
    <?php else: ?>
        
        <div class="overflow-x-auto bg-white rounded-2xl shadow-md border border-gray-100">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Kode</th>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Kamar</th>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Check-in</th>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Check-out</th>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Total</th>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Status</th>
                        <th class="px-6 py-3 text-left font-semibold uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $statusColors = [
                                'Pending' => 'bg-yellow-100 text-yellow-800',
                                'Diterima' => 'bg-green-100 text-green-800',
                                'Ditolak' => 'bg-red-100 text-red-800',
                                'Dibatalkan' => 'bg-red-100 text-red-800'
                            ];
                            $colorClass = $statusColors[$booking->status_pemesanan] ?? 'bg-gray-100 text-gray-800';
                        ?>

                        <tr class="hover:bg-gray-50 transition">
                            
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                <?php echo e($booking->p_lu_Pemesanan); ?>

                            </td>

                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="<?php echo e(asset('storage/' . $booking->image)); ?>"
                                         class="w-12 h-12 object-cover rounded-lg shadow-sm border border-gray-200">
                                    <span class="font-medium text-gray-800"><?php echo e($booking->nama_kamar); ?></span>
                                </div>
                            </td>

                            
                            <td class="px-6 py-4"><?php echo e(date('d M Y', strtotime($booking->tgl_checkin))); ?></td>
                            <td class="px-6 py-4"><?php echo e(date('d M Y', strtotime($booking->tgl_checkout))); ?></td>

                            
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                Rp <?php echo e(number_format($booking->total_harga, 0, ',', '.')); ?>

                            </td>

                            
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold <?php echo e($colorClass); ?>">
                                    <?php echo e($booking->status_pemesanan); ?>

                                </span>
                            </td>

                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    
                                    <?php if($booking->status_pemesanan == 'Pending'): ?>
                                        <a href="<?php echo e(route('user.booking.summary', $booking->id)); ?>"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-xs font-medium transition">
                                           Bayar
                                        </a>
                                        <form action="<?php echo e(route('user.booking.cancel', $booking->id)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit"
                                                    onclick="return confirm('Batalkan booking ini?')"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-xs font-medium transition">
                                                Batal
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    
                                    <?php if(strtolower($booking->status_pemesanan) == 'diterima'): ?>
                                        <a href="<?php echo e(route('user.booking.qr', $booking->id)); ?>"
                                           class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md text-xs font-medium transition">
                                           <i class="fas fa-qrcode mr-1"></i> Lihat QR
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-center">
            <?php echo e($bookings->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views/user/booking/index.blade.php ENDPATH**/ ?>