@extends('template.app')

@section('content')


<div class="flex justify-end pr-6">
    <a href="/"
        class="inline-block mb-6 px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow-md
               hover:bg-yellow-600 hover:shadow-lg transition-all duration-300">
        ← Kembali
    </a>
</div>

<h2 class="text-3xl font-bold text-center mb-10 text-yellow-600">
    Jenis Kamar di Hotel Aston
</h2>

<div class="flex flex-wrap justify-center gap-8">

    <!-- KAMAR 1 -->
    <div class="bg-white shadow-lg shadow-yellow-200 rounded-xl p-4 w-64 text-center border border-yellow-300 hover:shadow-yellow-400 hover:scale-105 transition-all duration-300">
        <h3 class="text-lg font-semibold mb-2 text-yellow-700">Superior Room</h3>
        <img
            src="/images/superior.jpeg"
            alt="Gambar Superior"
            class="w-full h-40 object-cover rounded-md mb-3"
        >
        <div class="border-t border-yellow-300 my-3"></div>
        <p class="text-sm">Kapasitas: 2 orang</p>
        <p class="text-sm font-semibold text-yellow-700">Harga: Rp 500.000</p>
    </div>

    <!-- KAMAR 2 -->
    <div class="bg-white shadow-lg shadow-yellow-200 rounded-xl p-4 w-64 text-center border border-yellow-300 hover:shadow-yellow-400 hover:scale-105 transition-all duration-300">
        <h3 class="text-lg font-semibold mb-2 text-yellow-700">Deluxe Room</h3>
        <img
            src="/images/deluxe.jpeg"
            alt="Gambar Deluxe"
            class="w-full h-40 object-cover rounded-md mb-3"
        >
        <div class="border-t border-yellow-300 my-3"></div>
        <p class="text-sm">Kapasitas: 2 orang</p>
        <p class="text-sm font-semibold text-yellow-700">Harga: Rp 650.000</p>
    </div>

    <!-- KAMAR 3 -->
    <div class="bg-white shadow-lg shadow-yellow-200 rounded-xl p-4 w-64 text-center border border-yellow-300 hover:shadow-yellow-400 hover:scale-105 transition-all duration-300">
        <h3 class="text-lg font-semibold mb-2 text-yellow-700">Suite Room</h3>
        <img
            src="/images/suite.jpeg"
            alt="Gambar Suite"
            class="w-full h-40 object-cover rounded-md mb-3"
        >
        <div class="border-t border-yellow-300 my-3"></div>
        <p class="text-sm">Kapasitas: 5 orang</p>
        <p class="text-sm font-semibold text-yellow-700">Harga: Rp 900.000</p>
    </div>

</div>

@endsection
