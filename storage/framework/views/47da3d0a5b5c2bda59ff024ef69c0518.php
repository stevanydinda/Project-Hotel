<?php $__env->startSection('content'); ?>
    <div class="container mx-auto mt-6 px-4">

        <?php if(Session::get('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo e(Session::get('success')); ?>

            </div>
        <?php endif; ?>

        <div class="flex justify-end space-x-2 mb-4">
            <a href="<?php echo e(route('admin.users.trash')); ?>"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                Data Sampah User
            </a>
            <a href="<?php echo e(route('admin.users.export')); ?>"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                Export (.xlsx)
            </a>
            <a href="<?php echo e(route('admin.users.create')); ?>"
                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded">
                Tambah Data
            </a>

            
            <a href="<?php echo e(url()->previous()); ?>"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Kembali
            </a>
        </div>

        <h2 class="text-xl font-bold mb-4">Data Pengguna (Admin & User)</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 text-sm text-left text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Role</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border"><?php echo e($key + 1); ?></td>
                            <td class="px-4 py-2 border"><?php echo e($user->name); ?></td>
                            <td class="px-4 py-2 border"><?php echo e($user->email); ?></td>

                            <td class="px-4 py-2 border">
                                <?php if($user->role === 'admin'): ?>
                                    <span class="inline-block bg-yellow-500 text-white text-xs px-2 py-1 rounded">
                                        <?php echo e($user->role); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="inline-block bg-green-500 text-white text-xs px-2 py-1 rounded">
                                        <?php echo e($user->role); ?>

                                    </span>
                                <?php endif; ?>
                            </td>

                            <td class="px-4 py-2 border">
                                <div class="flex space-x-2">
                                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                        Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.users.delete', $user->id)); ?>" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\admin\user\index.blade.php ENDPATH**/ ?>