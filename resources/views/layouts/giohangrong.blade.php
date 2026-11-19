@extends('layouts.frontend')

@section('title', 'Giỏ hàng trống')

@section('content')
<main class="content-wrapper">
	<div class="container py-5 text-center">
		<i class="ci-shopping-cart display-3 text-body-tertiary mb-4 d-block"></i>
		<h1 class="h3 mb-3">Giỏ hàng của bạn hiện đang trống!</h1>
		<p class="text-body-secondary mb-4">Hãy chọn thêm sản phẩm để bắt đầu mua sắm.</p>
		<a class="btn btn-lg btn-primary rounded-pill" href="{{ route('frontend.home') }}">
			<i class="ci-chevron-left fs-lg me-1"></i> Quay về trang chủ
		</a>
	</div>
</main>
@endsection
