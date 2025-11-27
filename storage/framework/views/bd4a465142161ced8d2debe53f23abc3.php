<?php $__env->startSection('content'); ?>
    <div class="container mx-auto mt-6 px-4">
        <?php if(Session::get('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo e(Session::get('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(Session::get('error')): ?>
            <div class="alert alert-danger"><?php echo e(Session::get('error')); ?></div>
        <?php endif; ?>

        <div class="flex justify-end space-x-2 mb-4">
            <a href="<?php echo e(route('admin.rooms.trash')); ?>"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                Data Sampah Kamar
            </a>
            <a href="#" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                Export (.xlsx)
            </a>
            <a href="<?php echo e(route('admin.rooms.create')); ?>"
                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded">
                Tambah Data
            </a>

            <a href="<?php echo e(url()->previous()); ?>"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
        <h5 class="mb-3">Data Kamar</h5>
        <table class="table table-bordered table-striped text-center w-75 mx-auto" id="tableRoom">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Kamar</th>
                    <th>Jumlah Kamar</th>
                    <th>Kapasitas</th>
                    <th>Harga</th>
                </tr>
            </thead>
        </table>
    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('script'); ?>
        <script>
            $(function() {
                $("#tableRoom").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "<?php echo e(route('admin.rooms.datatables')); ?>",
                    columns: [{
                            data: 'DT_RowIndex',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'kamar',
                            name: 'tipe_kamar'
                        },
                        {
                            data: 'jumlah',
                            name: 'jumlah_kamar'
                        },
                        {
                            data: 'kapasitas',
                            name: 'kapasitas'
                        },
                        {
                            data: 'harga',
                            name: 'harga'
                        },
                    ]
                })
            })
        </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\admin\room\index.blade.php ENDPATH**/ ?>