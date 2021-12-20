<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Promo;
use Illuminate\Validation\Rule;

class PromoController extends Controller
{
    //
    public function index() {
        $promo = Promo::all(); // mengambil semua data promo

        if (count($promo) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $promo
            ], 200);
        } // return data semua promo dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); // return message data promo kosong
    }

    // method untuk menampilkan 1 data promo (search)
    public function show($id) {
        $promo = Promo::find($id); // mencari data promo berdasarkan id

        if(!is_null($promo)) {
            return response([
                'message' => 'Retrieve Promo Success',
                'data' => $promo
            ], 200);
        } // return data promo yang ditemukan dalam bentuk json

        return response([
            'message' => 'Promo Not Found',
            'data' => null
        ], 404); // return message saat data promo tidak ditemukan
    }

    // method untuk menambah 1 data promo baru (create)
    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_promo' => 'required|max:60|unique:promo',
            'diskon' => 'required|promo_diskon',
        ]); // membuat rule validasi input

        if ($validate->fails()) 
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $promo = Promo::create($storeData);
        return response([
            'message' => 'Add Promo Success',
            'data' => $promo
        ], 200); // return data promo baru dalam bentuk json
    }

    // method untuk menghapus 1 data product (delete)
    public function destroy($id) {
        $promo = Promo::find($id); // mencari data product berdasarkan id

        if (is_null($promo)) {
            return response([
                'message' => 'Promo Not Found',
                'data' => null
            ], 404);
        } // return message saat data promo tidak ditemukan

        if ($promo->delete()) {
            return response([
                'message' => 'Delete Promo Success',
                'data' => $promo
            ], 200);
        } // return message saat berhasil menghapus data promo
        
        return response([
            'message' => 'Delete Promo Failed',
            'data' => null,
        ], 400); // return message saat gagal menghapus data promo
    }

    //method untuk mengubah 1 data promo (update)
    public function update(Request $request, $id) {
        $promo = Promo::find($id); // mencari data promo berdasarkan id
        if (is_null($promo)) {
            return response([
                'message' => 'Promo Not Found',
                'data' => null
            ], 404);
        } // return message saat data promo tidak ditemukan

        $updateData = $request->all(); // mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'nama_promo' => ['required', 'max:60', Rule::unique('promo')->ignore($promo)],
            'diskon' => 'required|promo_diskon',
        ]); // membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $promo->nama_promo = $updateData['nama_promo']; // edit nama_promo
        $promo->diskon = $updateData['diskon']; // edit diskon

        if ($promo->save()) {
            return response([
                'message' => 'Update Promo Success',
                'data' => $promo
            ], 200);
        } // return data promo baru dalam bentuk json

        return response([
            'message' => 'Update Promo Failed',
            'data' => null
        ], 400); // return message saat promo gagal di edit
    }
}
