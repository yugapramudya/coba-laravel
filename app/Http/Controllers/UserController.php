<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)

    {

        $data['objek'] = \App\User::latest()->paginate(10);

        return view('user_index', $data);
    }

    public function tambah()

    {

        $data['objek'] = new \App\User();

        $data['action'] = 'UserController@simpan';

        $data['method'] = 'POST';

        $data['nama_tombol'] = 'SIMPAN';

        return view('user_form', $data);
    }

    public function simpan(Request $request)

    {

        $request->validate([

            'name' => 'required|min:2',

            'email' => 'required|email|unique:users,email',

            'password' => 'same:password_confirmation'

        ]);

        $objek = new \App\User();

        $objek->name = $request->name;

        $objek->email = $request->email;

        $objek->password = bcrypt($request->password);

        $objek->save();

        //\App\User::create($request->except('password_confirmation'));

        return back()->with('pesan', 'data sudah disimpan');
    }
}
