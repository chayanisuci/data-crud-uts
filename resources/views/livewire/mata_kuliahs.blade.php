<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mata Kuliah</h2>
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

            
            <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Tambah Data</button>
            
            @if($isModal)
                @include('livewire.creatematkul')
            @endif

            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Nama Mata Kuliah</th>
                        <th class="px-4 py-2">SKS</th>
                        <th class="px-4 py-2">Semester</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mata_kuliahs as $row)
                        <tr>
                            <td class="border px-4 py-2">{{ $row->nama_mata_kuliah }}</td>
                            <td class="border px-4 py-2">{{ $row->sks }}</td>
                            <td class="border px-4 py-2">{{ $row->semester }}</td>
                            <td class="border px-4 py-2">
                                <button wire:click="edit({{ $row->id_mata_kuliah }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                                <button wire:click="delete({{ $row->id_mata_kuliah }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</button>
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
