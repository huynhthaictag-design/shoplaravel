@extends('layouts.frontend')

@section('title', 'Giỏ hàng')

@section('content')
<main class="content-wrapper">
	<div class="container py-5 mt-n2 mt-sm-0">
		<h1 class="h3 mb-4">Giỏ hàng</h1>

		<div class="row">
			<!-- Danh sách sản phẩm -->
			<div class="col-lg-8">
				<div class="table-responsive">
					<table class="table align-middle">
						<thead>
							<tr>
								<th scope="col">Sản phẩm</th>
								<th scope="col" class="text-end">Đơn giá</th>
								<th scope="col" class="text-center">Số lượng</th>
								<th scope="col" class="text-end">Thành tiền</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							@foreach(Cart::content() as $value)
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div class="ratio bg-body-tertiary rounded overflow-hidden flex-shrink-0" style="width:96px; --cz-aspect-ratio:calc(80 / 96 * 100%)">
												<img src="{{ asset('storage/app/private/' . $value->options->image) }}" alt="{{ $value->name }}" />
											</div>
											<div class="ps-3 min-w-0">
												<span class="d-block fs-sm fw-medium">{{ $value->name }}</span>
											</div>
										</div>
									</td>
									<td class="text-end">
										{{ number_format($value->price, 0, ',', '.') }}<small>đ</small>
									</td>
									<td>
										<div class="d-flex align-items-center justify-content-center gap-2">
											<a href="{{ route('frontend.giohang.giam', ['row_id' => $value->rowId]) }}" class="btn btn-icon btn-sm btn-secondary">
												<i class="ci-minus fs-sm"></i>
											</a>
											<span class="fw-medium px-2">{{ $value->qty }}</span>
											<a href="{{ route('frontend.giohang.tang', ['row_id' => $value->rowId]) }}" class="btn btn-icon btn-sm btn-secondary">
												<i class="ci-plus fs-sm"></i>
											</a>
										</div>
									</td>
									<td class="text-end fw-semibold">
										{{ number_format($value->price * $value->qty, 0, ',', '.') }}<small>đ</small>
									</td>
									<td class="text-end">
										<a href="{{ route('frontend.giohang.xoa', ['row_id' => $value->rowId]) }}" class="btn btn-icon btn-sm btn-outline-secondary border-0" data-bs-toggle="tooltip" data-bs-title="Xóa">
											<i class="ci-trash fs-base"></i>
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<a class="btn btn-outline-secondary rounded-pill mt-2" href="{{ route('frontend.sanpham') }}">
					<i class="ci-chevron-left fs-base me-1"></i> Tiếp tục mua sắm
				</a>
			</div>

			<!-- Tóm tắt đơn hàng -->
			<aside class="col-lg-4 mt-4 mt-lg-0">
				<div class="bg-body-tertiary rounded-5 p-4">
					<h2 class="h5 mb-4">Tóm tắt đơn hàng</h2>
					<ul class="list-unstyled fs-sm gap-3 mb-0">
						<li class="d-flex justify-content-between mb-3">
							Tổng tiền hàng:
							<span class="text-dark-emphasis fw-medium">{{ Cart::priceTotal(0, ',', '.') }}<small>đ</small></span>
						</li>
						<li class="d-flex justify-content-between mb-3">
							Giảm giá:
							<span class="text-dark-emphasis fw-medium">{{ Cart::discount(0, ',', '.') }}<small>đ</small></span>
						</li>
						<li class="d-flex justify-content-between mb-0">
							Thuế VAT:
							<span class="text-dark-emphasis fw-medium">{{ Cart::tax(0, ',', '.') }}<small>đ</small></span>
						</li>
					</ul>
					<div class="border-top pt-4 mt-4">
						<div class="d-flex justify-content-between mb-4">
							<span class="fw-medium">Tổng ước tính:</span>
							<span class="h5 mb-0">{{ Cart::total(0, ',', '.') }}<small>đ</small></span>
						</div>
						<a class="btn btn-lg btn-primary w-100 rounded-pill" href="{{ route('user.dathang') }}">
							Tiến hành thanh toán <i class="ci-chevron-right fs-lg ms-1"></i>
						</a>
					</div>
				</div>
			</aside>
		</div>
	</div>
</main>
@endsection
