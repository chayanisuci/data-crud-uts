<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Mata_Kuliah;

class Mata_Kuliahs extends Component
{
    public $mata_kuliahs, $nama_mata_kuliah, $sks, $semester, $id_mata_kuliah;
    public $isModal;

  	//FUNGSI INI UNTUK ME-LOAD VIEW YANG AKAN MENJADI TAMPILAN HALAMAN MAHASISWA
    public function render()
    {
        $this->mata_kuliahs = Mata_Kuliah::orderBy('created_at', 'DESC')->get(); //MEMBUAT QUERY UNTUK MENGAMBIL DATA
        return view('livewire.mata_kuliahs'); //LOAD VIEW MAHASISWA.BLADE.PHP YG ADA DI DALAM FOLDER /RESOURSCES/VIEWS/LIVEWIRE
    }

    //FUNGSI INI AKAN DIPANGGIL KETIKA TOMBOL TAMBAH ANGGOTA DITEKAN
    public function create()
    {
        //KEMUDIAN DI DALAMNYA KITA MENJALANKAN FUNGSI UNTUK MENGOSONGKAN FIELD
        $this->resetFields();
        //DAN MEMBUKA MODAL
        $this->openModal();
    }

    //FUNGSI INI UNTUK MENUTUP MODAL DIMANA VARIABLE ISMODAL KITA SET JADI FALSE
    public function closeModal()
    {
        $this->isModal = false;
    }

    //FUNGSI INI DIGUNAKAN UNTUK MEMBUKA MODAL
    public function openModal()
    {
        $this->isModal = true;
    }

    //FUNGSI INI UNTUK ME-RESET FIELD/KOLOM, SESUAIKAN FIELD APA SAJA YANG KAMU MILIKI
    public function resetFields()
    {
        $this->nama_mata_kuliah = '';
        $this->sks = '';
        $this->semester = '';
        $this->id_mata_kuliah = '';
    }

    //METHOD STORE AKAN MENG-HANDLE FUNGSI UNTUK MENYIMPAN / UPDATE DATA
    public function store()
    {
        //MEMBUAT VALIDASI
        $this->validate([
            'nama_mata_kuliah' => 'required|string',
            'sks' => 'required|string',
            'semester' => 'required|string',
        ]);

        //QUERY UNTUK MENYIMPAN / MEMPERBAHARUI DATA MENGGUNAKAN UPDATEORCREATE
        //DIMANA ID MENJADI UNIQUE ID, JIKA IDNYA TERSEDIA, MAKA UPDATE DATANYA
        //JIKA TIDAK, MAKA TAMBAHKAN DATA BARU
        Mata_Kuliah::updateOrCreate(['id_mata_kuliah' => $this->id_mata_kuliah], [
            'nama_mata_kuliah' => $this->nama_mata_kuliah,
            'sks' => $this->sks,
            'semester' => $this->semester,
        ]);

        //BUAT FLASH SESSION UNTUK MENAMPILKAN ALERT NOTIFIKASI
        session()->flash('message', $this->id_mata_kuliah ? $this->nama_mata_kuliah . ' Diperbaharui': $this->nama_mata_kuliah . ' Ditambahkan');
        $this->closeModal(); //TUTUP MODAL
        $this->resetFields(); //DAN BERSIHKAN FIELD
    }

    //FUNGSI INI UNTUK MENGAMBIL DATA DARI DATABASE BERDASARKAN ID MEMBER
    public function edit($id_mata_kuliah)
    {
        $mata_kuliah = Mata_Kuliah::find($id_mata_kuliah); //BUAT QUERY UTK PENGAMBILAN DATA
        //LALU ASSIGN KE DALAM MASING-MASING PROPERTI DATANYA
        $this->id_mata_kuliah = $id_mata_kuliah;
        $this->nama_mata_kuliah = $mata_kuliah->nama_mata_kuliah;
        $this->sks = $mata_kuliah->sks;
        $this->semester = $mata_kuliah->semester;
      
        $this->openModal(); //LALU BUKA MODAL
    }

    //FUNGSI INI UNTUK MENGHAPUS DATA
    public function delete($id_mata_kuliah)
    {
        $mata_kuliah = Mata_Kuliah::find($id_mata_kuliah); //BUAT QUERY UNTUK MENGAMBIL DATA BERDASARKAN ID
        $mata_kuliah->delete(); //LALU HAPUS DATA
        session()->flash('message', $mata_kuliah->nama_mata_kuliah . ' Dihapus'); //DAN BUAT FLASH MESSAGE UNTUK NOTIFIKASI
    }
}
