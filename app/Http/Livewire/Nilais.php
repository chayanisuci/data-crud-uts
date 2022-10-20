<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Nilai;

class Nilais extends Component
{
    public $nilais, $id_mata_kuliah, $id_mahasiswa, $nilai;
    public $isModal;

  	//FUNGSI INI UNTUK ME-LOAD VIEW YANG AKAN MENJADI TAMPILAN HALAMAN MAHASISWA
    public function render()
    {
        $this->nilais = Nilai::orderBy('created_at', 'DESC')->get(); //MEMBUAT QUERY UNTUK MENGAMBIL DATA
        return view('livewire.nilais'); //LOAD VIEW MAHASISWA.BLADE.PHP YG ADA DI DALAM FOLDER /RESOURSCES/VIEWS/LIVEWIRE
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

        $this->id_mata_kuliah = '';
        $this->id_mahasiswa = '';
        $this->id_nilai = '';
    }

    // public function nilai() 
    // {  
    //     $posts = Nilai::all();
    //     return view('nilas.nilai')->with(compact('nilais'));
    // }

    //METHOD STORE AKAN MENG-HANDLE FUNGSI UNTUK MENYIMPAN / UPDATE DATA
    public function store()
    {
        //MEMBUAT VALIDASI
        $this->validate([
            'id_mata_kuliah' => 'required|string',
            'id_mahasiswa' => 'required|string',
            'nilai' => 'required|string',
        ]);

        //QUERY UNTUK MENYIMPAN / MEMPERBAHARUI DATA MENGGUNAKAN UPDATEORCREATE
        //DIMANA ID MENJADI UNIQUE ID, JIKA IDNYA TERSEDIA, MAKA UPDATE DATANYA
        //JIKA TIDAK, MAKA TAMBAHKAN DATA BARU
        Nilai::updateOrCreate(['id_nilai' => $this->id_nilai], [
            'id_mata_kuliah' => $this->id_mata_kuliah,
            'id_mahasiswa' => $this->id_mahasiswa,
            'nilai' => $this->nilai,
        ]);

        //BUAT FLASH SESSION UNTUK MENAMPILKAN ALERT NOTIFIKASI
        session()->flash('message', $this->id_nilai ? $this->id_mahasiswa . ' Diperbaharui': $this->id_mahasiswa . ' Ditambahkan');
        $this->closeModal(); //TUTUP MODAL
        $this->resetFields(); //DAN BERSIHKAN FIELD
    }

    //FUNGSI INI UNTUK MENGAMBIL DATA DARI DATABASE BERDASARKAN ID MEMBER
    public function edit($id_nilai)
    {
        $nilai = Nilai::find($id_nilai); //BUAT QUERY UTK PENGAMBILAN DATA
        //LALU ASSIGN KE DALAM MASING-MASING PROPERTI DATANYA
        $this->id_nilai = $id_nilai;
        $this->id_mata_kuliah = $nilai->id_mata_kuliah;
        $this->id_mahasiswa = $nilai->id_mahasiswa;
        $this->nilai = $nilai->nilai;

        $this->openModal(); //LALU BUKA MODAL
    }

    //FUNGSI INI UNTUK MENGHAPUS DATA
    public function delete($id_nilai)
    {
        $nilai = Nilai::find($id_nilai); //BUAT QUERY UNTUK MENGAMBIL DATA BERDASARKAN ID
        $nilai->delete(); //LALU HAPUS DATA
        session()->flash('message', $nilai->id_mahasiswa . ' Dihapus'); //DAN BUAT FLASH MESSAGE UNTUK NOTIFIKASI
    }
}
