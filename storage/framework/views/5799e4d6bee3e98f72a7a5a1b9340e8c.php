<?php $__env->startSection('title', 'Beranda'); ?>

<?php $__env->startSection('content'); ?>
<section class="bg-cover bg-center h-screen" style="background-image: url('https://images.archipelagohotels.com/astoninternational/v2/Images/Bogor/Overview/overview_ab.jpg');">
    <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
        <div class="text-center text-white">
            <h1 class="text-5xl font-bold">Selamat Datang di Hotel Aston</h1>
            <p class="mt-4 text-lg">Nikmati kenyamanan, kemewahan, dan pelayanan terbaik kami</p>
            <a href="#about" class="mt-6 inline-block px-6 py-3 bg-yellow-500 text-black font-semibold rounded-lg hover:bg-yellow-400">Jelajahi</a>
        </div>
</section>

<section id="about" class="py-16 px-8 bg-white text-center">
    <h2 class="text-3xl font-bold mb-4">Tentang Kami</h2>
    <p class="max-w-2xl mx-auto text-gray-600">Aston Bogor Hotel and Resort dengan pemandangan indah Gunung Salak, menawarkan beragam fasilitas dan pelayanan untuk memenuhi kebutuhan perjalanan bisnis dan liburan. Hanya berjarak 30 menit dari Stasiun Kereta Api Bogor dan 50 menit berkendara dari Jakarta melalui Jalan Toll Jagorawi, Hotel Aston Bogor bertempat di lokasi strategis di Pusat Pengembangan Bogor Nirwana Residence Area. Hotel kami menawarkan pengalaman menginap yang luar biasa dengan fasilitas modern, lokasi strategis, dan layanan terbaik untuk memastikan kenyamanan Anda.
    </p>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\hotel-project\resources\views\home.blade.php ENDPATH**/ ?>