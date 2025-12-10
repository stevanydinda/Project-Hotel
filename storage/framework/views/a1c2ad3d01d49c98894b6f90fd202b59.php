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

<?php $__env->startPush('scripts'); ?>
<script>
    const hargaPerMalam = <?php echo e($room->harga); ?>;
    const stokTersedia = <?php echo e($room->stok); ?>;
    const roomName = "<?php echo e($room->name); ?>";

    // Function untuk mengurangi jumlah kamar
    function decreaseRoom() {
        const input = document.getElementById('jumlahKamar');
        let currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            hitungTotal();
        }
    }

    // Function untuk menambah jumlah kamar
    function increaseRoom() {
        const input = document.getElementById('jumlahKamar');
        let currentValue = parseInt(input.value);
        if (currentValue < stokTersedia) {
            input.value = currentValue + 1;
            hitungTotal();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Stok Terbatas',
                text: `Maksimal ${stokTersedia} kamar tersedia untuk ${roomName}`,
                timer: 2000,
                showConfirmButton: false
            });
        }
    }

    // Function hitung total
    function hitungTotal() {
        const checkin = document.getElementById('checkin').value;
        const checkout = document.getElementById('checkout').value;
        const jumlahKamar = parseInt(document.getElementById('jumlahKamar').value) || 1;

        let nights = 1; // Default 1 malam

        if (checkin && checkout) {
            const start = new Date(checkin);
            const end = new Date(checkout);
            nights = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            nights = Math.max(1, nights); // Minimal 1 malam
        }

        const total = hargaPerMalam * nights * jumlahKamar;

        // Update UI
        document.getElementById('nightsCount').textContent = nights;
        document.getElementById('roomCount').textContent = jumlahKamar;
        document.getElementById('totalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');

        // Update stok info
        document.getElementById('stockAvailable').textContent = stokTersedia;
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial calculation
        hitungTotal();

        // Listen to input changes
        document.getElementById('checkin').addEventListener('change', function() {
            const checkinDate = new Date(this.value);
            const minCheckout = new Date(checkinDate);
            minCheckout.setDate(minCheckout.getDate() + 1);

            const checkoutInput = document.getElementById('checkout');
            checkoutInput.min = minCheckout.toISOString().split('T')[0];

            // Auto-set checkout if empty or invalid
            if (!checkoutInput.value || new Date(checkoutInput.value) <= checkinDate) {
                checkoutInput.value = minCheckout.toISOString().split('T')[0];
            }

            hitungTotal();
        });

        document.getElementById('checkout').addEventListener('change', hitungTotal);

        // Input jumlah kamar
        document.getElementById('jumlahKamar').addEventListener('input', function() {
            let value = parseInt(this.value);

            // Validasi
            if (value < 1) {
                this.value = 1;
            } else if (value > stokTersedia) {
                this.value = stokTersedia;
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Terbatas',
                    text: `Maksimal ${stokTersedia} kamar tersedia`,
                    timer: 1500,
                    showConfirmButton: false
                });
            }

            hitungTotal();
        });

        // Validasi form submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const checkin = document.getElementById('checkin').value;
            const checkout = document.getElementById('checkout').value;

            if (!checkin || !checkout) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Data Belum Lengkap',
                    text: 'Silahkan pilih tanggal check-in dan check-out',
                });
                return;
            }

            const checkinDate = new Date(checkin);
            const checkoutDate = new Date(checkout);

            if (checkoutDate <= checkinDate) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal Tidak Valid',
                    text: 'Tanggal check-out harus setelah tanggal check-in',
                });
                return;
            }

            // Tampilkan loading
            Swal.fire({
                title: 'Memproses Booking...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\user\booking\create.blade.php ENDPATH**/ ?>