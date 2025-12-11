<?php $__env->startSection('content'); ?>
    <div class="w-full max-w-2xl mx-auto my-10 px-4">

        
        <nav class="text-sm mb-6">
            <ol class="list-reset flex text-gray-600 space-x-2">
                <li>
                    <a href="#" class="hover:underline text-yellow-600">Pengguna</a>
                </li>
                <li>/</li>
                <li>
                    <a href="#" class="hover:underline text-yellow-600">Data</a>
                </li>
                <li>/</li>
                <li class="text-gray-500">Tambah</li>
            </ol>
        </nav>

        
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-center text-xl font-semibold mb-6 text-gray-800">Tambah Data Kamar</h2>

            <form method="POST" action="<?php echo e(route('admin.rooms.store')); ?>" enctype="multipart/form-data">

                <?php echo csrf_field(); ?>
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kamar</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none">
                </div>

                
                <div class="mb-4">
                    <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                    <input type="number" id="kapasitas" name="kapasitas"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="jumlah_kamar" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Kamar</label>
                    <input type="number" id="jumlah_kamar" name="jumlah_kamar"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>

                
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" id="deskripsi" name="deskripsi"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>

                
                <div class="mb-4">
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <input type="number" id="harga" step="0.01" min="0" name="harga"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>

                
                <div class="mb-4">
                    <label for="tipe_kamar" class="block text-sm font-medium text-gray-700 mb-1">Tipe Kamar</label>
                    <input type="text" id="tipe_kamar" name="tipe_kamar"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>

                
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                    <input type="file" id="image" name="image" class="w-full">
                </div>

                
                <div class="flex justify-between items-center">
                    <a href="<?php echo e(route('admin.rooms.index')); ?>"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-md transition">
                        ← Kembali
                    </a>

                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-md transition">
                        Tambah Data
                    </button>
                </div>

            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\admin\room\create.blade.php ENDPATH**/ ?>