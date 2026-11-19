<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\LoaiSanPham;
use App\Models\HangSanXuat;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Imports\SanPhamImport;
use App\Exports\SanPhamExport;
use Maatwebsite\Excel\Facades\Excel;

class SanPhamController extends Controller
{
    public function getDanhSach()
	{
		$sanpham = SanPham::paginate(10);
		return view('admin.sanpham.danhsach', compact('sanpham'));
	}
	
	public function getThem()
	{
		$loaisanpham = LoaiSanPham::all();
		$hangsanxuat = HangSanXuat::all();
		return view('admin.sanpham.them', compact('loaisanpham', 'hangsanxuat'));
	}
	
	public function postThem(Request $request)
	{
		// Kiểm tra Form
		$request->validate([
			'loaisanpham_id' => ['required'],
			'hangsanxuat_id' => ['required'],
			'tensanpham' => ['required', 'string', 'max:255', 'unique:sanpham'],
			'soluong' => ['required', 'numeric'],
			'dongia' => ['required', 'numeric'],
			'hinhanh' => ['nullable', 'image', 'max:2048'],
		]);
		
		$path = null;
		
		if($request->hasFile('hinhanh'))
		{
			// Xác định thư mục
			$loaisanpham = LoaiSanPham::find($request->loaisanpham_id);
			$directory = $loaisanpham->tenloai_slug;
			
			// Tên tập tin lưu dưới dạng tên sản phẩm không dấu (slug)
			$ext = $request->file('hinhanh')->extension();
			$name = Str::slug($request->tensanpham, '-');
			$filename = $name . '.' . $ext;
			
			$path = $request->file('hinhanh')->storeAs($directory, $filename);
		}
		
		$orm = new SanPham();
		$orm->loaisanpham_id = $request->loaisanpham_id;
		$orm->hangsanxuat_id = $request->hangsanxuat_id;
		$orm->tensanpham = $request->tensanpham;
		$orm->tensanpham_slug = Str::slug($request->tensanpham, '-');
		$orm->soluong = $request->soluong;
		$orm->dongia = $request->dongia;
		$orm->hinhanh = $path;
		$orm->motasanpham = $request->motasanpham;
		$orm->save();
		
		return redirect()->route('admin.sanpham');
	}
	
	public function getSua($id)
	{
		$sanpham = SanPham::find($id);
		$loaisanpham = LoaiSanPham::all();
		$hangsanxuat = HangSanXuat::all();
		return view('admin.sanpham.sua', compact('sanpham', 'loaisanpham', 'hangsanxuat'));
	}
	
	public function postSua(Request $request, $id)
	{
		// Kiểm tra Form
		$request->validate([
			'loaisanpham_id' => ['required'],
			'hangsanxuat_id' => ['required'],
			'tensanpham' => ['required', 'string', 'max:255', 'unique:sanpham,tensanpham,' . $id],
			'soluong' => ['required', 'numeric'],
			'dongia' => ['required', 'numeric'],
			// 'hinhanh' => ['nullable', 'image', 'max:2048'],
		]);
		
		$orm = SanPham::find($id);
		$orm->loaisanpham_id = $request->loaisanpham_id;
		$orm->hangsanxuat_id = $request->hangsanxuat_id;
		$orm->tensanpham = $request->tensanpham;
		$orm->tensanpham_slug = Str::slug($request->tensanpham, '-');
		$orm->soluong = $request->soluong;
		$orm->dongia = $request->dongia;
		if($request->hasFile('hinhanh')) $orm->hinhanh = $request->hinhanh;
		$orm->motasanpham = $request->motasanpham;
		$orm->save();
		
		return redirect()->route('admin.sanpham');
	}
	
	public function getXoa($id)
	{
		$orm = SanPham::find($id);
		$orm->delete();
		
		return redirect()->route('admin.sanpham');
	}
	
	// Nhập từ Excel
	public function postNhap(Request $request)
	{
		$request->validate([
			'file_excel' => ['required', 'file', 'mimes:xlsx,xls', 'max:2048'],
		]);
		
		$import = new SanPhamImport();
		Excel::import($import, $request->file('file_excel'));
		return redirect()->route('admin.sanpham'); 
	}
	
	// Xuất ra Excel
	public function getXuat()
	{
		$filename = 'san-pham-' . time() . '.xlsx';
		return Excel::download(new SanPhamExport(), $filename);
	}
}
