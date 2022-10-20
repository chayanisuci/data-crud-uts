<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nilai Mahasiswa</h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif


            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Id Mata Kuliah</th>
                        <th class="px-4 py-2">Id Mahasiswa</th>
                        <th class="px-4 py-2">Nilai Mahasiswa</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilais as $row)
                        <tr>
                            <td class="border px-4 py-2">{{ $row->id_mata_kuliah }}</td>
                            <td class="border px-4 py-2">{{ $row->id_mahasiswa }}</td>
                            <td class="border px-4 py-2">{{ $row->nilai }}</td>
                            <td class="border px-4 py-2">
                                <button wire:click="delete({{ $row->id_nilai }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="border px-4 py-2 text-center" colspan="5">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>