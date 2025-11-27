@extends('template.app')

@section('content')
<div class="container mx-auto mt-6 px-4">

    @if (Session::get('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="flex justify-end space-x-2 mb-4">
        <a href="{{ route('admin.rooms.trash') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
            Data Sampah Kamar
        </a>
        <a href="#"
            class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
            Export (.xlsx)
        </a>
        <a href="{{ route('admin.rooms.create') }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded">
            Tambah Data
        </a>
        <a href="{{ url()->previous() }}"
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
            Kembali
        </a>
    </div>

    <h5 class="mb-3 text-xl font-semibold text-center">Data Kamar</h5>

    <table id="tableRoom"
        class="min-w-[70%] mx-auto border border-gray-300 rounded-lg shadow">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">#</th>
                <th class="p-2">Kamar</th>
                <th class="p-2">Jumlah Kamar</th>
                <th class="p-2">Kapasitas</th>
                <th class="p-2">Harga</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    $("#tableRoom").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.rooms.datatables') }}",
        columns: [
            { data: 'DT_RowIndex', searchable: false, orderable: false },
            { data: 'kamar', name: 'tipe_kamar' },
            { data: 'jumlah', name: 'jumlah_kamar' },
            { data: 'kapasitas', name: 'kapasitas' },
            { data: 'harga', name: 'harga' },
        ]
    });
});
</script>
@endpush
