<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-gray-100 py-20">
        <div class="max-w-6xl mx-auto px-6">
            <h1 class="text-4xl font-bold text-yellow-700 mb-6">Dashboard Admin</h1>

            
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                    Selamat datang, <?php echo e(Auth::user()->name); ?> 👋
                </h2>
                <p class="text-gray-600">Anda login sebagai <strong><?php echo e(Auth::user()->role); ?></strong>.</p>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-yellow-100 p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-2">Manajemen User</h3>
                    <p class="text-gray-700">Kelola akun pengguna aplikasi hotel.</p>
                    <a href="<?php echo e(route('admin.users.index')); ?>"
                        class="inline-block mt-3 text-yellow-700 font-semibold hover:underline">Lihat Data →</a>
                </div>

                <div class="bg-yellow-100 p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-2">Manajemen Kamar</h3>
                    <p class="text-gray-700">Tambahkan kamar hotel.</p>
                    <a href="<?php echo e(route('admin.rooms.index')); ?>"
                        class="inline-block mt-3 text-yellow-700 font-semibold hover:underline">Kelola Kamar →</a>
                </div>

                <div class="bg-yellow-100 p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-2">Laporan Reservasi</h3>
                    <p class="text-gray-700">Lihat data transaksi dan pemesanan terbaru.</p>
                    <a href="<?php echo e(route('admin.bookings.index')); ?>"
                        class="inline-block mt-3 text-yellow-700 font-semibold hover:underline">Lihat Laporan →</a>
                </div>
            </div>
        </div>
        <div class="mt-12 text-center">
            <h5 class="text-xl font-semibold text-yellow-800">Grafik Pembelian Kamar</h5>
        </div>
        <div class ="bg-white p-6 rounded-lg shadow mt-6 w-3/4 mx-auto">
            <canvas id="chartBar"></canvas>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
    $(function() {
        $.ajax({
            url: "<?php echo e(route('admin.chart')); ?>",
            method: 'GET',
            success: function(response){
                let labels = response.labels;
                let data = response.data; // diterima
                let data_rejected = response.data_rejected; // ditolak

                const ctx = document.getElementById('chartBar').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Diterima',
                                data: data,
                                backgroundColor: 'rgba(255, 206, 86, 0.7)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Ditolak',
                                data: data_rejected,
                                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            },
            error: function(err){
                alert('Gagal mengambil data untuk grafik');
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>