<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Mahasiswa;

class Mahasiswas extends Component
{
    public $mahasiswas, $nama, $nim, $kelas, $alamat, $id_mahasiswa;
    public $isModal;

  	//FUNGSI INI UNTUK ME-LOAD VIEW YANG AKAN MENJADI TAMPILAN HALAMAN MAHASISWA
    public function render()
    {
        $this->mahasiswas = Mahasiswa::orderBy('created_at', 'DESC')->get(); //MEMBUAT QUERY UNTUK MENGAMBIL DATA
        return view('livewire.mahasiswas'); //LOAD VIEW MAHASISWA.BLADE.PHP YG ADA DI DALAM FOLDER /RESOURSCES/VIEWS/LIVEWIRE
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
        $this->nama = '';
        $this->nim = '';
        $this->kelas = '';
        $this->alamat = '';
        $this->id_mahasiswa = '';
    }

    //METHOD STORE AKAN MENG-HANDLE FUNGSI UNTUK MENYIMPAN / UPDATE DATA
    public function store()
    {
        //MEMBUAT VALIDASI
        $this->validate([
            'nama' => 'required|string',
            'nim' => 'required|string',
            'kelas' => 'required|string',
            'alamat' => 'required|string',
        ]);

        //QUERY UNTUK MENYIMPAN / MEMPERBAHARUI DATA MENGGUNAKAN UPDATEORCREATE
        //DIMANA ID MENJADI UNIQUE ID, JIKA IDNYA TERSEDIA, MAKA UPDATE DATANYA
        //JIKA TIDAK, MAKA TAMBAHKAN DATA BARU
        Mahasiswa::updateOrCreate(['id_mahasiswa' => $this->id_mahasiswa], [
            'nama' => $this->nama,
            'nim' => $this->nim,
            'kelas' => $this->kelas,
            'alamat' => $this->alamat,
        ]);

        //BUAT FLASH SESSION UNTUK MENAMPILKAN ALERT NOTIFIKASI
        session()->flash('message', $this->id_mahasiswa ? $this->nama . ' Diperbaharui': $this->nama . ' Ditambahkan');
        $this->closeModal(); //TUTUP MODAL
        $this->resetFields(); //DAN BERSIHKAN FIELD
    }

    //FUNGSI INI UNTUK MENGAMBIL DATA DARI DATABASE BERDASARKAN ID MAHASISWA
    public function edit($id_mahasiswa)
    {
        $mahasiswa = Mahasiswa::find($id_mahasiswa); //BUAT QUERY UTK PENGAMBILAN DATA
        //LALU ASSIGN KE DALAM MASING-MASING PROPERTI DATANYA
        $this->id_mahasiswa = $id_mahasiswa;
        $this->nama = $mahasiswa->nama;
        $this->nim = $mahasiswa->nim;
        $this->kelas = $mahasiswa->kelas;
        $this->alamat = $mahasiswa->alamat;

        $this->openModal(); //LALU BUKA MODAL
    }

    //FUNGSI INI UNTUK MENGHAPUS DATA
    public function delete($id_mahasiswa)
    {
        $mahasiswa = Mahasiswa::find($id_mahasiswa); //BUAT QUERY UNTUK MENGAMBIL DATA BERDASARKAN ID
        $mahasiswa->delete(); //LALU HAPUS DATA
        session()->flash('message', $mahasiswa->nama . ' Dihapus'); //DAN BUAT FLASH MESSAGE UNTUK NOTIFIKASI
    }
}
