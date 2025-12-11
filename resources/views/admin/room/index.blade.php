@extends('template.app')

@section('content')
    <div class="container mx-auto mt-6 px-4">

        @if (Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ Session::get('success') }}
            </div>
        @endif
          @if (Session::get('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ Session::get('error') }}
            </div>
        @endif

        <div class="flex justify-end space-x-2 mb-4">
            <a href="{{ route('admin.rooms.create') }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded">
                Tambah Data
            </a>
             <a href="{{ route('admin.rooms.trash') }}"
                class="bg-blue-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                Sampah
            </a>
            <a href="{{ route('admin.dashboard')}}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Kembali
            </a>

        </div>

        <h5 class="mb-3 text-xl font-semibold text-center">Data Kamar</h5>

        <table id="tableRoom" class="min-w-[70%] mx-auto border border-gray-300 rounded-lg shadow text-center">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2">#</th>
                    <th class="p-2">Gambar</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Kapasitas</th>
                    <th class="p-2">Jumlah Kamar</th>
                    <th class="p-2">Deskripsi</th>
                    <th class="p-2">Harga</th>
                    <th class="p-2">Tipe Kamar</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $("#tableRoom").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.rooms.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'gambar',
                        name: 'image',
                        searchable: false,
                        orderable: false
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'kapasitas',
                        name: 'kapasitas'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah_kamar'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'kamar',
                        name: 'tipe_kamar'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false
                    }
                ]
            });
        });
    </script>
@endpush
