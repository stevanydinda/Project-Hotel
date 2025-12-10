<?php $__env->startSection('content'); ?>
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white">
                <h1 class="text-2xl font-bold">Booking Kamar</h1>
                <p class="text-blue-100"><?php echo e($room->name); ?></p>
            </div>

            <div class="p-6">
                <form action="<?php echo e(route('user.kamar.booking.store', $room->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Tanggal Check-in</label>
                        <input type="date" name="tgl_checkin" id="checkin" min="<?php echo e(date('Y-m-d')); ?>"
                            class="w-full px-3 py-2 border rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Tanggal Check-out</label>
                        <input type="date" name="tgl_checkout" id="checkout" min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>"
                            class="w-full px-3 py-2 border rounded-lg" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 mb-2">Jumlah Kamar</label>
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="decreaseRoom()"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 w-10 h-10 rounded-lg flex items-center justify-center">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" name="jnu_kamar_dipesan" id="jumlahKamar" min="1" max="<?php echo e($room->stok); ?>"
                                class="w-full px-3 py-2 border rounded-lg text-center" value="1" required>
                            <button type="button" onclick="increaseRoom()"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 w-10 h-10 rounded-lg flex items-center justify-center">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Stok tersedia: <span id="stockAvailable"><?php echo e($room->stok); ?></span> kamar</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="font-bold text-gray-800 mb-2">Perkiraan Biaya</h3>
                        <div class="flex justify-between mb-1">
                            <span>Harga per malam:</span>
                            <span class="font-semibold" id="pricePerNight">Rp <?php echo e(number_format($room->harga, 0, ',', '.')); ?></span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Jumlah malam:</span>
                            <span id="nightsCount">1</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Jumlah kamar:</span>
                            <span id="roomCount">1</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between font-bold">
                            <span>Total:</span>
                            <span id="totalPrice">Rp <?php echo e(number_format($room->harga, 0, ',', '.')); ?></span>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                        <i class="fas fa-calendar-check mr-2"></i> Konfirmasi Booking
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
const harga = <?php echo e($room->harga); ?>;
const stok = <?php echo e($room->jumlah_kamar); ?>;

function updateTotal() {
    const ci = new Date(checkin.value), co = new Date(checkout.value);
    const nights = ci && co && co > ci ? (co - ci) / 86400000 : 1;
    const jumlah = Math.min(Math.max(+jumlahKamar.value || 1, 1), stok);
    jumlahKamar.value = jumlah;

    totalPrice.textContent = 'Rp ' + (harga * jumlah * nights).toLocaleString('id-ID');
    nightsCount.textContent = nights;
    roomCount.textContent = jumlah;
}

function adjustRoom(d) {
    jumlahKamar.value = Math.min(Math.max(+jumlahKamar.value + d, 1), stok);
    updateTotal();
}

document.addEventListener('input', e => {
    if (['checkin', 'checkout', 'jumlahKamar'].includes(e.target.id)) updateTotal();
});

checkin.addEventListener('change', () => {
    const d = new Date(checkin.value);
    d.setDate(d.getDate() + 1);
    checkout.min = d.toISOString().split('T')[0];
    if (!checkout.value || new Date(checkout.value) <= new Date(checkin.value))
        checkout.value = checkout.min;
    updateTotal();
});

document.addEventListener('DOMContentLoaded', updateTotal);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views/user/booking/create.blade.php ENDPATH**/ ?>