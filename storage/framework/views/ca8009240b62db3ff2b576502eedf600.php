<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Hotel Aston'); ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php echo $__env->yieldPushContent('css'); ?>
</head>

<body class="bg-gray-50 scroll-smooth">

    
    <nav class="flex justify-between items-center px-8 py-4 bg-white shadow-sm fixed w-full top-0 left-0 z-50">
        <div class="text-xl font-bold text-yellow-800">Hotel Aston</div>

        <div class="space-x-4">
            <?php if(auth()->guard()->check()): ?>
            <?php if(Auth::user()->role !== 'admin'): ?>
            <?php if (! (Route::is('user.jenis_kamar'))): ?>
            <a href="#lokasi" class="hover:text-yellow-600">Lokasi</a>
            <a href="#eksplor" class="hover:text-yellow-600">Eksplor</a>
            <?php endif; ?>

            <a href="<?php echo e(route('user.jenis_kamar')); ?>"
                class="hover:text-yellow-600 <?php echo e(Route::is('user.jenis_kamar') ? 'text-yellow-700 font-semibold' : ''); ?>">Jenis
                Kamar</a>
            <?php endif; ?>

            <span class="text-green-700 font-semibold">Halo, <?php echo e(Auth::user()->name); ?></span>
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                    Logout
                </button>
            </form>
            <?php else: ?>
            <a href="#lokasi" class="hover:text-yellow-600">Lokasi</a>
            <a href="#eksplor" class="hover:text-yellow-600">Eksplor</a>
            <a href="<?php echo e(route('signup')); ?>" class="hover:text-yellow-600">SignUp</a>
            <a href="<?php echo e(route('login')); ?>" class="hover:text-yellow-600">Login</a>
            <?php endif; ?>
        </div>
    </nav>


    <main class="pt-24">

        <?php echo $__env->yieldContent('content'); ?>

        
        <?php if(auth()->guard()->check()): ?>
        <?php if(Auth::user()->role !== 'admin' && !Route::is('user.jenis_kamar')): ?>
        
        <section id="lokasi" class="py-16 bg-white flex flex-col items-center text-center">
            <div class="max-w-3xl">
                <h2 class="text-3xl font-semibold text-yellow-700 mb-4">Lokasi Kami</h2>
                <p class="text-gray-600 mb-6">
                    Hotel Aston terletak di pusat kota dengan akses mudah ke tempat wisata dan pusat perbelanjaan.
                </p>
            </div>

            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.855968706255!2d106.800974274991!3d-6.282684793710258!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f12f52d509cd%3A0x4292d80b76b2e146!2sASTON%20Bogor%20Hotel%20%26%20Resort!5e0!3m2!1sid!2sid!4v1731641561234!5m2!1sid!2sid"
                class="rounded-xl shadow-lg w-full max-w-3xl h-80" style="border:0;" allowfullscreen=""
                loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </section>

        
        <section id="eksplor" class="py-16 bg-gray-50 text-center">
            <h2 class="text-3xl font-semibold text-yellow-700 mb-4">Fasilitas Hotel Aston</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8">
                Temukan pengalaman menginap terbaik dengan fasilitas mewah, pemandangan indah, dan pelayanan ramah.
            </p>
            <div class="flex justify-center flex-wrap gap-6">
                <div class="bg-white p-4 rounded-2xl shadow-md w-64">
                    <img src="<?php echo e(asset('images/pool.jpeg')); ?>" alt="Kolam Renang" class="rounded-xl mb-3">
                    <h3 class="text-lg font-semibold">Kolam Renang</h3>
                    <p class="text-gray-500 text-sm">Nikmati suasana santai dengan pemandangan kota.</p>
                </div>
                <div class="bg-white p-4 rounded-2xl shadow-md w-64">
                    <img src="<?php echo e(asset('images/spa.jpeg')); ?>" alt="Spa & Wellness" class="rounded-xl mb-3">
                    <h3 class="text-lg font-semibold">Spa & Wellness</h3>
                    <p class="text-gray-500 text-sm">Relaksasi maksimal untuk tubuh dan pikiran Anda.</p>
                </div>
                <div class="bg-white p-4 rounded-2xl shadow-md w-64">
                    <img src="<?php echo e(asset('images/restaurant.jpeg')); ?>" alt="Restoran" class="rounded-xl mb-3">
                    <h3 class="text-lg font-semibold">Restoran</h3>
                    <p class="text-gray-500 text-sm">Nikmati hidangan istimewa dari chef profesional kami.</p>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php else: ?>
        
        <section id="lokasi" class="py-16 bg-white flex flex-col items-center text-center">
            <div class="max-w-3xl">
                <h2 class="text-3xl font-semibold text-yellow-700 mb-4">Lokasi Kami</h2>
                <p class="text-gray-600 mb-6">
                    Hotel Aston terletak di pusat kota dengan akses mudah ke tempat wisata dan pusat perbelanjaan.
                </p>
            </div>

            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.855968706255!2d106.800974274991!3d-6.282684793710258!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f12f52d509cd%3A0x4292d80b76b2e146!2sASTON%20Bogor%20Hotel%20%26%20Resort!5e0!3m2!1sid!2sid!4v1731641561234!5m2!1sid!2sid"
                class="rounded-xl shadow-lg w-full max-w-3xl h-80" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </section>

        <section id="eksplor" class="py-16 bg-gray-50 text-center">
            <h2 class="text-3xl font-semibold text-yellow-700 mb-4">Fasilitas Hotel Aston</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8">
                Temukan pengalaman menginap terbaik dengan fasilitas mewah, pemandangan indah, dan pelayanan ramah.
            </p>
            <div class="flex justify-center flex-wrap gap-6">
                <div class="bg-white p-4 rounded-2xl shadow-md w-64">
                    <img src="<?php echo e(asset('images/pool.jpeg')); ?>" alt="Kolam Renang" class="rounded-xl mb-3">
                    <h3 class="text-lg font-semibold">Kolam Renang</h3>
                    <p class="text-gray-500 text-sm">Nikmati suasana santai dengan pemandangan kota.</p>
                </div>
                <div class="bg-white p-4 rounded-2xl shadow-md w-64">
                    <img src="<?php echo e(asset('images/spa.jpeg')); ?>" alt="Spa & Wellness" class="rounded-xl mb-3">
                    <h3 class="text-lg font-semibold">Spa & Wellness</h3>
                    <p class="text-gray-500 text-sm">Relaksasi maksimal untuk tubuh dan pikiran Anda.</p>
                </div>
                <div class="bg-white p-4 rounded-2xl shadow-md w-64">
                    <img src="<?php echo e(asset('images/restaurant.jpeg')); ?>" alt="Restoran" class="rounded-xl mb-3">
                    <h3 class="text-lg font-semibold">Restoran</h3>
                    <p class="text-gray-500 text-sm">Nikmati hidangan istimewa dari chef profesional kami.</p>
                </div>
            </div>
        </section>
        <?php endif; ?>
    </main>


    
    <?php if(session('success')): ?>
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "<?php echo e(session('success')); ?>",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
    </script>
    <?php endif; ?>

    <?php if(session('logout')): ?>
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: "<?php echo e(session('logout')); ?>",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
    </script>
    <?php endif; ?> 
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.tailwindcss.js"></script>


    
    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html><?php /**PATH C:\Users\Hanin\Documents\Project-Hotel\resources\views/template/app.blade.php ENDPATH**/ ?>