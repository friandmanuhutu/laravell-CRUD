<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Mahasiswa;


class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::all();
        return view('index',['mahasiswas' => $mahasiswas]);
    }


    public function create()
    {
        return view('create');
    }


    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nim'           => 'required|size:8|unique:mahasiswas',
            'nama'          => 'required|min:3|max:50',
            'jenis_kelamin' => 'required|in:P,L',
            'jurusan'       => 'required',
            'alamat'        => 'required',
        ]);


        Mahasiswa::create($validateData);


        return redirect()->route('mahasiswas.index')->with('pesan',"Penambahan data {$validateData['nama']} berhasil");
    }


    public function show(Mahasiswa $mahasiswa)
    {
        return view('show',['mahasiswa' => $mahasiswa]);
    }


    public function edit(Mahasiswa $mahasiswa)
    {
        return view('edit',['mahasiswa' => $mahasiswa]);
    }


    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        // dump($request->all());
        // dump($mahasiswa);


        $validateData = $request->validate([
            'nim'           => 'required|size:8|unique:mahasiswas,nim,'.$mahasiswa->id,
            'nama'          => 'required|min:3|max:50',
            'jenis_kelamin' => 'required|in:P,L',
            'jurusan'       => 'required',
            'alamat'        => 'required',
        ]);


        // Mahasiswa::where('id',$mahasiswa->id)->update($validateData);


        $mahasiswa->update($validateData);


        return redirect()->route('mahasiswas.show',['mahasiswa' => $mahasiswa->id])
        ->with('pesan',"Update data {$validateData['nama']} berhasil");
    }


    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswas.index')
        ->with('pesan',"Hapus data $mahasiswa->nama berhasil");
    }


}
