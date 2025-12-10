<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="<?php echo e(route('user.jenis_kamar')); ?>" class="text-blue-600 hover:text-blue-800">
                ← Kembali ke Jenis Kamar
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Room Image -->
            <div>
                <?php if($room->image): ?>
                    <img src="<?php echo e(asset('storage/' . $room->image)); ?>" alt="<?php echo e($room->name); ?>"
                        class="w-full h-96 object-cover rounded-lg">
                <?php else: ?>
                    <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500">No Image</span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Room Details -->
            <div>
                <h1 class="text-3xl font-bold mb-4"><?php echo e($room->name); ?></h1>

                <p class="text-gray-600 mb-6"><?php echo e($room->deskripsi ?? 'Kamar nyaman untuk menginap.'); ?></p>

                <div class="mb-6">
                    <div class="flex items-center mb-2">
                        <span class="text-gray-600 w-32">Kapasitas:</span>
                        <span class="font-semibold"><?php echo e($room->kapasitas); ?> orang</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <span class="text-gray-600 w-32">Stok:</span>
                        <span
                            class="font-semibold <?php echo e($room->jumlah_kamar ?? 0 > 0 ? 'text-green-600' : 'text-red-600'); ?>">
                            <?php echo e($room->jumlah_kamar); ?> kamar
                        </span>
                    </div>
                    <div class="flex items-center mb-6">
                        <span class="text-gray-600 w-32">Harga:</span>
                        <span class="text-2xl font-bold text-blue-700">
                            Rp <?php echo e(number_format($room->price ?? ($room->harga ?? 0), 0, ',', '.')); ?>/malam
                        </span>
                    </div>
                </div>

                <!-- Booking Button -->
                <div class="space-y-4">
                    <?php if(($room->jumlah_kamar ?? 0) > 0): ?>
                        <a href="<?php echo e(route('user.kamar.booking', $room->id)); ?>"
                            class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-center">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Booking Sekarang
                        </a>
                    <?php else: ?>
                        <button disabled
                            class="block w-full bg-gray-400 text-white font-bold py-3 px-4 rounded-lg text-center">
                            Kamar Habis
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\user\room\show.blade.php ENDPATH**/ ?>