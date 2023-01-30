<?php

namespace App\Imports;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class LabaImport implements ToModel, WithValidation, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '0' => 'required|unique:users,nik',
            '1' => 'required',
            '2' => 'required|unique:users,username',
            '3' => 'required|unique:users,email',
            '4' => 'required',
            '5' => 'required',
            '6' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '0.required' => 'NIK is required.',
            '0.unique' => 'NIK has already been taken.',
            '1.required' => 'Nama is required.',
            '2.required' => 'Username is required.',
            '2.unique' => 'Username has already been taken.',
            '3.required' => 'Email Pelanggan is required.',
            '3.unique' => 'Email has already been taken.',
            '4.required' => 'Phone is required.',
            '5.required' => 'ID Jabatan is required.',
            '6.required' => 'Password is required.',
        ];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'nik'           => $row[0],
            'nama_user'     => $row[1],
            'username'      => $row[2],
            'email'         => $row[3],
            'phone'         => $row[4],
            'jabatan_id'    => Jabatan::where('jabatan', $row[5])->value('id'),
            'password'      => Hash::make($row[6])
        ]);
    }
}
