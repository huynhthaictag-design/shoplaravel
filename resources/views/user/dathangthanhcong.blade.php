@extends('layouts.frontend')

@section('title', 'Đặt hàng thành công')

@section('content')
<main class="content-wrapper">
	<div class="container py-5 text-center">
		<i class="ci-check-circle display-3 text-success mb-4 d-block"></i>
		<h1 class="h3 mb-3">Cảm ơn bạn đã đặt hàng!</h1>
		<p class="text-body-secondary mb-4">
			Đơn hàng của bạn đã được ghi nhận. Chúng tôi sẽ liên hệ xác nhận và giao hàng trong thời gian sớm nhất.
		</p>
		<div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
			<a class="btn btn-lg btn-primary rounded-pill" href="{{ route('frontend.home') }}">Về trang chủ</a>
			<a class="btn btn-lg btn-outline-secondary rounded-pill" href="{{ route('frontend.sanpham') }}">Tiếp tục mua sắm</a>
		</div>
	</div>
</main>
@endsection
