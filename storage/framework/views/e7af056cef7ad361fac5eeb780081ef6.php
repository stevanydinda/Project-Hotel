<?php $__env->startSection('content'); ?>
    <div class="container mx-auto mt-6 px-4">

        <?php if(Session::get('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo e(Session::get('success')); ?>

            </div>
        <?php endif; ?>

        <div class="flex justify-end space-x-2 mb-4">
            <div class="flex space-x-2">
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                    Kembali
                </a>
                <a href="<?php echo e(route('admin.bookings.trash')); ?>"
                    class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                    Sampah
                </a>
            </div>
        </div>
        <h5 class="mb-3 text-xl font-semibold text-center">Data Booking</h5>

        <table id="tableBooking" class="min-w-[70%] mx-auto border border-gray-300 rounded-lg shadow text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">KodeBooking</th>
                    <th class="p-3">Nama User</th>
                    <th class="p-3">Kamar</th>
                    <th class="p-3">Check-in</th>
                    <th class="p-3">Check-out</th>
                    <th class="p-3">Jumlah Kamar</th>
                    <th class="p-3">Total Harga</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">

            </tbody>
        </table>
    </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(function() {
            const table = $("#tableBooking").DataTable({
                processing: true,
                serverSide: true,
                ajax: "<?php echo e(route('admin.bookings.datatables')); ?>",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'kode_booking',
                        name: 'kode_booking'
                    },

                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },

                    {
                        data: 'nama_kamar',
                        name: 'nama_kamar'
                    },

                    {
                        data: 'checkin',
                        name: 'tgl_checkin'
                    },

                    {
                        data: 'checkout',
                        name: 'tgl_checkout'
                    },

                    {
                        data: 'jumlah_kamar',
                        name: 'jumlah_kamar'
                    },

                    {
                        data: 'total_harga',
                        name: 'total_harga'
                    },

                    {
                        data: 'status',
                        name: 'status_pemesanan'
                    },

                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],

            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\admin\booking\index.blade.php ENDPATH**/ ?>