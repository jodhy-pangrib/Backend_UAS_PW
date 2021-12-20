<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pegawai;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    //
    public function index() {
        $pegawai = Pegawai::all(); // mengambil semua data pegawai

        if (count($pegawai) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pegawai
            ], 200);
        } // return data semua pegawai dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); // return message data pegawai kosong
    }

    // method untuk menampilkan 1 data pegawai (search)
    public function show($id) {
        $pegawai = Pegawai::find($id); // mencari data pegawai berdasarkan id

        if(!is_null($pegawai)) {
            return response([
                'message' => 'Retrieve Pegawai Success',
                'data' => $pegawai
            ], 200);
        } // return data pegawai yang ditemukan dalam bentuk json

        return response([
            'message' => 'Pegawai Not Found',
            'data' => null
        ], 404); // return message saat data pegawai tidak ditemukan
    }

    // method untuk menambah 1 data pegawai baru (create)
    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:pegawai',
            'telepon' => 'required|numeric|digits_between:10,13|no_indo',
            'lulusan' => 'required'
        ]); // membuat rule validasi input

        if ($validate->fails()) 
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $pegawai = Pegawai::create($storeData);
        return response([
            'message' => 'Add Pegawai Success',
            'data' => $pegawai
        ], 200); // return data pegawai baru dalam bentuk json
    }

    // method untuk menghapus 1 data product (delete)
    public function destroy($id) {
        $pegawai = Pegawai::find($id); // mencari data product berdasarkan id

        if (is_null($pegawai)) {
            return response([
                'message' => 'Pegawai Not Found',
                'data' => null
            ], 404);
        } // return message saat data pegawai tidak ditemukan

        if ($pegawai->delete()) {
            return response([
                'message' => 'Delete Pegawai Success',
                'data' => $pegawai
            ], 200);
        } // return message saat berhasil menghapus data pegawai
        
        return response([
            'message' => 'Delete Pegawai Failed',
            'data' => null,
        ], 400); // return message saat gagal menghapus data pegawai
    }

    //method untuk mengubah 1 data pegawai (update)
    public function update(Request $request, $id) {
        $pegawai = Pegawai::find($id); // mencari data pegawai berdasarkan id
        if (is_null($pegawai)) {
            return response([
                'message' => 'Pegawai Not Found',
                'data' => null
            ], 404);
        } // return message saat data pegawai tidak ditemukan

        $updateData = $request->all(); // mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'nama' => 'required|max:60',
            'email' => ['email:rfc,dns', 'required', Rule::unique('users')->ignore($pegawai)],
            'telepon' => 'required|numeric|digits_between:10,13|no_indo',
            'lulusan' => 'required'
        ]); // membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $pegawai->nama = $updateData['nama']; // edit nama
        $pegawai->email = $updateData['email']; // edit diskon
        $pegawai->telepon = $updateData['telepon'];
        $pegawai->lulusan = $updateData['lulusan'];

        if ($pegawai->save()) {
            return response([
                'message' => 'Update Pegawai Success',
                'data' => $pegawai
            ], 200);
        } // return data pegawai baru dalam bentuk json

        return response([
            'message' => 'Update Pegawai Failed',
            'data' => null
        ], 400); // return message saat pegawai gagal di edit
    }
}
