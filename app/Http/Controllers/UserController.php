<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $page = 'admin.user.';
    protected $index = 'admin.user.index';

    public function index(Request $request)
    {
        $tokogudang = TokoGudang::all();
        $models = User::all();
        return view($this->index, compact('models', 'tokogudang'));
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'username'                  => 'required|string|max:255|unique:users',
                'password'                  => 'required_with:password_confirmation|same:password_confirmation',
                'password_confirmation'     => 'required'

            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'username'                  => 'Username',
                'password'                  => 'Password',
                'password_confirmation'     => 'Password Confirmation'
            ]
        );

        $model = new User();
        $model->username = $request->username;
        $model->level = $request->level;
        $model->password = Hash::make($request->password);
        $model->save();

        return redirect()->back()->with('info', 'Berhasil menambah data');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
            [
                'username'                  => 'required|string|max:255|unique:users,username,'.$request->id,
                'password'                  => 'same:password_confirmation',

            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'username'                  => 'Username',
                'password'                  => 'Password',
                'password_confirmation'     => 'Password Confirmation'
            ]
        );

        $model = User::findOrFail($id);
        $model->username = $request->username;
        $model->level = $request->level;
        if($request->password != null){
            $model->password = Hash::make($request->password);
        }
        $model->save();

        return redirect()->route('user')->with('info', 'Berhasil mengubah data');
    }

    public function deactivate($id)
    {
        $model = User::findOrFail($id);
        $model->status = 0;
        $model->save();
        return redirect()->route('user')->with('info', 'Berhasil menonactifkan user');
    }

    public function activate($id)
    {
        $model = User::findOrFail($id);
        $model->status = 1;
        $model->save();
        return redirect()->route('user')->with('info', 'Berhasil mengaktifkan user');
    }
}
