<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonHang;

class DonHangController extends Controller
{
    public function getDanhSach()
	{
		$donhang = DonHang::orderBy('created_at', 'desc')->get();
		return view('admin.donhang.danhsach', compact('donhang'));
	}
	
	public function getThem()
	{
		
	}
	
	public function postThem(Request $request)
	{
		
	}
	
	public function getSua($id)
	{
		$donhang = DonHang::find($id);
		$tinhtrang = TinhTrang::all();
		return view('admin.donhang.sua', compact('donhang', 'tinhtrang'));
	}
	
	public function postSua(Request $request, $id)
	{
		// Kiểm tra Form
		$request->validate([
			'tinhtrang_id' => ['required'],
			'dienthoaigiaohang' => ['required', 'string', 'max:20'],
			'diachigiaohang' => ['required', 'string', 'max:255'],
		]);
		
		$orm = DonHang::find($id);
		$orm->tinhtrang_id = $request->tinhtrang_id;
		$orm->dienthoaigiaohang = $request->dienthoaigiaohang;
		$orm->diachigiaohang = $request->diachigiaohang;
		$orm->save();
		
		return redirect()->route('admin.donhang');
	}
	
	public function getXoa($id)
	{
		// Xóa đơn hàng chi tiết
		DonHang_ChiTiet::where('donhang_id', $id)->delete();
		
		$orm = DonHang::find($id);
		$orm->delete();
		
		return redirect()->route('admin.donhang');
	}
}
