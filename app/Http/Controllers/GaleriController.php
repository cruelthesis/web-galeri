<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Http\Requests\StoreGaleriRequest;
use App\Http\Requests\UpdateGaleriRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->id;

        $galeri = Galeri::where('user_id', $user)->get();
        return view('home', compact('galeri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;

        // $data = $request->validate([
        //     'foto' => 'required'
        // ]);

        // mencegah kemiripan nama file supaya tampil
        $gambar = $user.date('YmdHis').$request->file('foto')->getClientOriginalName(); 
        $request->foto->move(public_path('img'), $gambar);

        Galeri::create([
            'foto' => $gambar,
            'deskripsi' => $request->deskripsi,
            'judul' => $request->judul,
            'tanggal' => now(),
            'user_id' => $user

        ]);

        return redirect('/home');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        Galeri::where('id', '=', $id)->delete();

        return redirect('/home');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // dd($request->input('judul'));
        // $user = Auth::user()->id;

        // if($request->hasFile('foto')){
        //     $gambar = $user->id.'-'.date('YmdHis').$request->file('foto')->getClientOriginalName();
        //     $request->foto->move(public_path('img'), $gambar);
        //     $galeri->judul = $request->judul;
        //     $galeri->deskripsi = $request->deskripsi;
        //     $galeri->foto = $gambar;
        //     $galeri->tanggal = now();
        //     $galeri->user_id = $user;
        //     $galeri->save();
        // } else{
        //     $galeri->judul = $request->judul;
        //     $galeri->deskripsi = $request->deskripsi; 
        //     $galeri->foto = $galeri->foto;
        //     $galeri->tanggal = now();
        //     $galeri->user_id = $user;
        //     $galeri->save();
        // }


        $file = $request->foto;

        if(isset($file)){
            $namafile = date('YmdHis')."-".$request->foto->getClientOriginalExtension();

            $request->foto->move(public_path('img'),$namafile);

            $data = [
                'foto' => $namafile,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi
            ];

            Galeri::where('id', $id)->update($data);
        } else{
            $data = [
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi
            ];

            // dd($data);

            Galeri::where('id', $id)->update($data);
        }

        return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        //
    }
}
