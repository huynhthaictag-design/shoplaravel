<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HangSanXuat;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Imports\HangSanXuatImport;
use App\Exports\HangSanXuatExport;
use Maatwebsite\Excel\Facades\Excel;

class HangSanXuatController extends Controller
{
    public function getDanhSach()
	{
		$hangsanxuat = HangSanXuat::all();
		return view('admin.hangsanxuat.danhsach', compact('hangsanxuat'));
	}
	
	public function getThem()
	{
		return view('admin.hangsanxuat.them');
	}
	
	public function postThem(Request $request)
	{
		// Kiểm tra Form
		$request->validate([
			'tenhang' => ['required', 'string', 'max:255', 'unique:hangsanxuat'],
			'hinhanh' => ['nullable', 'image', 'max:1024'],
		]);
		
		$path = '';
		
		// Nếu có chọn tập tin thì upload
		if($request->hasFile('hinhanh'))
		{
			// Tên tập tin lưu dưới dạng tên hãng sản xuất không dấu (slug)
			$ext = $request->file('hinhanh')->extension();
			$name = Str::slug($request->tenhang, '-');
			$filename = $name . '.' . $ext;
			
			// Upload file vào thư mục 'storage/app/private/hang-san-xuat'
			$path = $request->file('hinhanh')->storeAs('hang-san-xuat', $filename);
		}
		
		$orm = new HangSanXuat();
		$orm->tenhang = $request->tenhang;
		$orm->tenhang_slug = Str::slug($request->tenhang, '-');
		$orm->hinhanh = $path;
		$orm->save();
		
		return redirect()->route('admin.hangsanxuat');
	}
	
	public function getSua($id)
	{
		$hangsanxuat = HangSanXuat::find($id);
		return view('admin.hangsanxuat.sua', compact('hangsanxuat'));
	}
	
	public function postSua(Request $request, $id)
	{
		// Kiểm tra Form
		$request->validate([
			'tenhang' => ['required', 'string', 'max:255', 'unique:hangsanxuat,tenhang,' . $id],
			'hinhanh' => ['nullable', 'image', 'max:1024'],
		]);
		
		$orm = HangSanXuat::find($id);
		
		$path = null;
		
		// Nếu có chọn tập tin thì upload
		if($request->hasFile('hinhanh'))
		{
			// Xóa ảnh cũ
			if($orm->hinhanh) Storage::delete($orm->hinhanh);
			
			// Tên tập tin lưu dưới dạng tên hãng sản xuất không dấu (slug)
			$ext = $request->file('hinhanh')->extension();
			$name = Str::slug($request->tenhang, '-');
			$filename = $name . '.' . $ext;
			
			// Upload file vào thư mục 'storage/app/private/hang-san-xuat'
			$path = $request->file('hinhanh')->storeAs('hang-san-xuat', $filename);
		}
		
		$orm->tenhang = $request->tenhang;
		$orm->tenhang_slug = Str::slug($request->tenhang, '-');
		$orm->hinhanh = $path ?? $orm->hinhanh ?? null;
		$orm->save();
		
		return redirect()->route('admin.hangsanxuat');
	}
	
	public function getXoa($id)
	{
		$orm = HangSanXuat::find($id);
		
		if($orm->hinhanh) Storage::delete($orm->hinhanh);
		
		$orm->delete();
		
		return redirect()->route('admin.hangsanxuat');
	}
	
	// Nhập từ Excel
	public function postNhap(Request $request)
	{
		$request->validate([
			'file_excel' => ['required', 'file', 'mimes:xlsx,xls', 'max:2048'],
		]);
		
		$import = new HangSanXuatImport();
		Excel::import($import, $request->file('file_excel'));
		return redirect()->route('admin.hangsanxuat'); 
	}
	
	// Xuất ra Excel
	public function getXuat()
	{
		$filename = 'hang-san-xuat-' . time() . '.xlsx';
		return Excel::download(new HangSanXuatExport(), $filename);
	}
}
