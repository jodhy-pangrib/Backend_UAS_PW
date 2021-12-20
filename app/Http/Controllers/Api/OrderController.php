<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;

class OrderController extends Controller
{
    //
    public function index() {
        $order = Order::with('promo')->get(); // mengambil semua data order
        
        if (count($order) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $order
            ], 200);
        } // return data semua order dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); // return message data order kosong
    }

    // method untuk menampilkan 1 data order (search)
    public function show($id) {
        $order = Order::with('promo')->findOrFail($id); // mencari data order berdasarkan id

        if(!is_null($order)) {
            return response([
                'message' => 'Retrieve Order Success',
                'data' => $order
            ], 200);
        } // return data order yang ditemukan dalam bentuk json

        return response([
            'message' => 'Order Not Found',
            'data' => null
        ], 404); // return message saat data order tidak ditemukan
    }

    // method untuk menambah 1 data order baru (create)
    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama' => 'required|max:60',
            'email' => 'required|email:rfc,dns',
            'telepon' => 'required|numeric|digits_between:10,13|no_indo',
            'jenis_paket' => 'required',
            'harga_paket' => 'required|numeric',
            'promo_id' => 'required|numeric'
        ]); // membuat rule validasi input

        if ($validate->fails()) 
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $order = Order::create($storeData);
        return response([
            'message' => 'Add Order Success',
            'data' => $order
        ], 200); // return data order baru dalam bentuk json
    }

    // method untuk menghapus 1 data product (delete)
    public function destroy($id) {
        $order = Order::find($id); // mencari data product berdasarkan id

        if (is_null($order)) {
            return response([
                'message' => 'Order Not Found',
                'data' => null
            ], 404);
        } // return message saat data order tidak ditemukan

        if ($order->delete()) {
            return response([
                'message' => 'Delete Order Success',
                'data' => $order
            ], 200);
        } // return message saat berhasil menghapus data order
        
        return response([
            'message' => 'Delete Order Failed',
            'data' => null,
        ], 400); // return message saat gagal menghapus data order
    }

    //method untuk mengubah 1 data order (update)
    public function update(Request $request, $id) {
        $order = Order::find($id); // mencari data order berdasarkan id
        if (is_null($order)) {
            return response([
                'message' => 'Order Not Found',
                'data' => null
            ], 404);
        } // return message saat data order tidak ditemukan

        $updateData = $request->all(); // mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'nama' => 'required|max:60',
            'email' => 'required|email:rfc,dns',
            'telepon' => 'required|numeric|digits_between:10,13|no_indo',
            'jenis_paket' => 'required',
            'harga_paket' => 'required|numeric',
            'promo_id' => 'required|numeric'
        ]); // membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $order->nama = $updateData['nama']; // edit nama
        $order->email = $updateData['email']; // edit diskon
        $order->telepon = $updateData['telepon'];
        $order->jenis_paket = $updateData['jenis_paket'];
        $order->harga_paket = $updateData['harga_paket'];
        $order->promo_id = $updateData['promo_id'];

        if ($order->save()) {
            return response([
                'message' => 'Update Order Success',
                'data' => $order
            ], 200);
        } // return data order baru dalam bentuk json

        return response([
            'message' => 'Update Order Failed',
            'data' => null
        ], 400); // return message saat order gagal di edit
    }
}
