<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TinhTrang;

class TinhTrangController extends Controller
{
    public function getDanhSach()
	{
		$tinhtrang = TinhTrang::all();
		return view('admin.tinhtrang.danhsach', compact('tinhtrang'));
	}
	
	public function getThem()
	{
		return view('admin.tinhtrang.them');
	}
	
	public function postThem(Request $request)
	{
		// Kiểm tra Form
		$request->validate([
			'tinhtrang' => ['required', 'string', 'max:255', 'unique:tinhtrang'],
		]);
		
		$orm = new TinhTrang();
		$orm->tinhtrang = $request->tinhtrang;
		$orm->save();
		
		return redirect()->route('admin.tinhtrang');
	}
	
	public function getSua($id)
	{
		$tinhtrang = TinhTrang::find($id);
		return view('admin.tinhtrang.sua', compact('tinhtrang'));
	}
	
	public function postSua(Request $request, $id)
	{
		// Kiểm tra Form
		$request->validate([
			'tinhtrang' => ['required', 'string', 'max:255', 'unique:tinhtrang,tinhtrang,' . $id],
		]);
		
		$orm = TinhTrang::find($id);
		$orm->tinhtrang = $request->tinhtrang;
		$orm->save();
		
		return redirect()->route('admin.tinhtrang');
	}
	
	public function getXoa($id)
	{
		$orm = TinhTrang::find($id);
		$orm->delete();
		
		return redirect()->route('admin.tinhtrang');
	}
}
