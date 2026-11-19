@extends('layouts.frontend')

@section('title', 'Đặt hàng')

@section('content')
<main class="content-wrapper">
	<div class="container py-5">
		<h1 class="h3 mb-4">Thông tin đặt hàng</h1>

		@if ($errors->any())
			<div class="alert alert-danger">
				<ul class="mb-0">
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<div class="row">
			<!-- Form giao hàng -->
			<div class="col-lg-7">
				<form method="POST" action="{{ route('user.dathang') }}" class="needs-validation" novalidate>
					@csrf

					<div class="mb-4">
						<label for="dienthoaigiaohang" class="form-label">Điện thoại giao hàng</label>
						<input type="tel" class="form-control form-control-lg @error('dienthoaigiaohang') is-invalid @enderror"
							   id="dienthoaigiaohang" name="dienthoaigiaohang"
							   value="{{ old('dienthoaigiaohang') }}" required />
						@error('dienthoaigiaohang')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-4">
						<label for="diachigiaohang" class="form-label">Địa chỉ giao hàng</label>
						<input type="text" class="form-control form-control-lg @error('diachigiaohang') is-invalid @enderror"
							   id="diachigiaohang" name="diachigiaohang"
							   value="{{ old('diachigiaohang') }}" required />
						@error('diachigiaohang')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<!-- Nút submit ẩn, được kích hoạt bởi label bên dưới -->
					<button type="submit" id="checkout-form-submit" class="d-none"></button>

					<label for="checkout-form-submit" class="btn btn-lg btn-primary rounded-pill w-100 mb-0">
						Thanh toán {{ Cart::total(0, ',', '.') ?? 0 }}đ
					</label>
				</form>
			</div>

			<!-- Tóm tắt đơn hàng -->
			<aside class="col-lg-5 mt-4 mt-lg-0">
				<div class="bg-body-tertiary rounded-5 p-4">
					<h2 class="h5 mb-4">Đơn hàng của bạn</h2>
					<ul class="list-unstyled fs-sm mb-0">
						@foreach(Cart::content() as $value)
							<li class="d-flex justify-content-between mb-3">
								<span class="text-truncate pe-3">{{ $value->name }} <span class="text-body-tertiary">x {{ $value->qty }}</span></span>
								<span class="text-dark-emphasis fw-medium">{{ number_format($value->price * $value->qty, 0, ',', '.') }}<small>đ</small></span>
							</li>
						@endforeach
					</ul>
					<div class="border-top pt-3 mt-3 d-flex justify-content-between">
						<span class="fw-medium">Tổng cộng:</span>
						<span class="h6 mb-0">{{ Cart::total(0, ',', '.') ?? 0 }}<small>đ</small></span>
					</div>
				</div>
			</aside>
		</div>
	</div>
</main>
@endsection
