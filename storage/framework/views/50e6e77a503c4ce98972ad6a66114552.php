<?php $__env->startSection('content'); ?>
    <div class="w-full max-w-2xl mx-auto my-10 px-4">


        
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-center text-xl font-semibold mb-6 text-gray-800">Edit Data Kamar</h2>

            <form method="POST" action="<?php echo e(route('admin.rooms.update', $room->id)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kamar</label>
                    <input type="text" id="name" name="name"
                        value="<?php echo e(old('name', $room->name)); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="mb-4">
                    <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                    <input type="number" id="kapasitas" name="kapasitas"
                        value="<?php echo e(old('kapasitas', $room->kapasitas)); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>

                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Kamar</label>

                    
                    <?php if($room->image): ?>
                        <img src="<?php echo e(asset('storage/rooms/' . $room->image)); ?>"
                             class="w-32 h-32 object-cover rounded mb-2 border">
                    <?php endif; ?>

                    <input type="file" name="image"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <p class="text-gray-500 text-sm mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                </div>

                
                <div class="flex justify-between items-center mt-6">
                    <a href="<?php echo e(route('admin.rooms.index')); ?>"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-md transition">
                        ← Kembali
                    </a>

                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-md transition">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\admin\room\edit.blade.php ENDPATH**/ ?>