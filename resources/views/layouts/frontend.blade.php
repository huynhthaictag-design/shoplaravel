<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light" data-pwa="true">
<head>
	<meta charset="utf-8" />

	<!-- Viewport -->
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<!-- Title -->
	<title>@yield('title', 'Trang chủ') - {{ config('app.name', 'Laravel') }}</title>

	<!-- Favicon / App icons -->
	<link rel="icon" type="image/png" href="{{ asset('public/assets/img/app-icons/icon-32x32.png') }}" sizes="32x32" />
	<link rel="apple-touch-icon" href="{{ asset('public/assets/img/app-icons/icon-180x180.png') }}" />

	<!-- Theme switcher (color modes) -->
	<script src="{{ asset('public/assets/js/theme-switcher.js') }}"></script>

	<!-- Preloaded local web font (Inter) -->
	<link rel="preload" href="{{ asset('public/assets/fonts/inter-variable-latin.woff2') }}" as="font" type="font/woff2" crossorigin />

	<!-- Font icons -->
	<link rel="preload" href="{{ asset('public/assets/icons/cartzilla-icons.woff2') }}" as="font" type="font/woff2" crossorigin />
	<link rel="stylesheet" href="{{ asset('public/assets/icons/cartzilla-icons.min.css') }}" />

	<!-- Vendor styles -->
	<link rel="stylesheet" href="{{ asset('public/assets/vendor/swiper/swiper-bundle.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/assets/vendor/simplebar/simplebar.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/assets/vendor/choices.js/choices.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/assets/vendor/nouislider/nouislider.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/assets/vendor/drift-zoom/drift-basic.min.css') }}" />

	<!-- Bootstrap + Theme styles -->
	<link rel="preload" href="{{ asset('public/assets/css/theme.min.css') }}" as="style" />
	<link rel="stylesheet" href="{{ asset('public/assets/css/theme.min.css') }}" id="theme-styles" />
	@yield('css')
</head>

<!-- Body -->
<body>
	<!-- Shopping cart offcanvas -->
	<div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="shoppingCart" tabindex="-1" style="width:500px">
		<!-- Header -->
		<div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
			<div class="d-flex align-items-center justify-content-between w-100">
				<h4 class="offcanvas-title" id="shoppingCartLabel">Giỏ hàng ({{ Cart::count() ?? 0 }})</h4>
				<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
			</div>
		</div>

		@if(Cart::count() > 0)
			<!-- Items -->
			<div class="offcanvas-body d-flex flex-column gap-4 pt-2">
				@foreach(Cart::content() as $value)
					<!-- Item -->
					<div class="d-flex align-items-center">
						<a class="flex-sm-shrink-0" href="#" style="width:142px">
							<div class="ratio bg-body-tertiary rounded overflow-hidden" style="--cz-aspect-ratio:calc(110 / 142 * 100%)">
								<img src="{{ asset('storage/app/private/' . $value->options->image) }}" alt="{{ $value->name }}" />
							</div>
						</a>
						<div class="w-100 min-w-0 ps-3">
							<h5 class="d-flex animate-underline mb-2">
								<a class="d-block fs-sm fw-medium text-truncate animate-target" href="#">{{ $value->name }}</a>
							</h5>
							<div class="d-flex align-items-center justify-content-between gap-1">
								<div class="h6 mt-1 mb-0">
									{{ number_format($value->price, 0, ',', '.') }}<small>đ</small>
									<span class="text-body-tertiary fs-sm fw-normal">x {{ $value->qty }}</span>
								</div>
								<a href="{{ route('frontend.giohang.xoa', ['row_id' => $value->rowId]) }}"
								   class="btn btn-icon btn-sm flex-shrink-0 fs-sm"
								   data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" data-bs-title="Xóa">
									<i class="ci-trash fs-base"></i>
								</a>
							</div>
						</div>
					</div>
				@endforeach
			</div>

			<!-- Footer -->
			<div class="offcanvas-header flex-column align-items-start">
				<div class="d-flex align-items-center justify-content-between w-100 mb-3 mb-md-4">
					<span class="text-light-emphasis">Tổng tiền:</span>
					<span class="h6 mb-0">{{ Cart::priceTotal(0, ',', '.') }}<small>đ</small></span>
				</div>
				<a class="btn btn-lg btn-dark w-100 rounded-pill" href="{{ route('frontend.giohang') }}">Giỏ hàng</a>
			</div>
		@else
			<div class="offcanvas-body d-flex flex-column align-items-center justify-content-center text-center gap-3">
				<i class="ci-shopping-cart display-4 text-body-tertiary"></i>
				<p class="mb-0">Giỏ hàng của bạn hiện đang trống!</p>
			</div>
		@endif
	</div>

	<!-- Navigation bar (Page header) -->
	<header class="navbar navbar-expand-lg navbar-dark bg-dark d-block z-fixed p-0" data-sticky-navbar='{"offset": 500}'>
		<div class="container d-block py-1 py-lg-3" data-bs-theme="dark">
			<div class="navbar-stuck-hide pt-1"></div>
			<div class="row flex-nowrap align-items-center g-0">
				<div class="col col-lg-3 d-flex align-items-center">
					<!-- Mobile offcanvas menu toggler (Hamburger) -->
					<button type="button" class="navbar-toggler me-4 me-lg-0" data-bs-toggle="offcanvas" data-bs-target="#navbarNav">
						<span class="navbar-toggler-icon"></span>
					</button>
					<!-- Navbar brand (Logo) -->
					<a href="{{ route('frontend.home') }}" class="navbar-brand me-0">
						<span class="d-none d-sm-flex flex-shrink-0 text-primary me-2">
							<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"><path d="M36 18.01c0 8.097-5.355 14.949-12.705 17.2a18.12 18.12 0 0 1-5.315.79C9.622 36 2.608 30.313.573 22.611.257 21.407.059 20.162 0 18.879v-1.758c.02-.395.059-.79.099-1.185.099-.908.277-1.817.514-2.686C2.687 5.628 9.682 0 18 0c5.572 0 10.551 2.528 13.871 6.517 1.502 1.797 2.648 3.91 3.359 6.201.494 1.659.771 3.436.771 5.292z" fill="currentColor" /><g fill="#fff"><path d="M17.466 21.624c-.514 0-.988-.316-1.146-.829-.198-.632.138-1.303.771-1.501l7.666-2.469-1.205-8.254-13.317 4.621a1.19 1.19 0 0 1-1.521-.75 1.19 1.19 0 0 1 .751-1.521l13.89-4.818c.553-.197 1.166-.138 1.64.158a1.82 1.82 0 0 1 .85 1.284l1.344 9.183c.138.987-.494 1.994-1.482 2.33l-7.864 2.528-.375.04zm7.31.138c-.178-.632-.85-1.007-1.482-.81l-5.177 1.58c-2.331.79-3.28.02-3.418-.099l-6.56-8.412a4.25 4.25 0 0 0-4.406-1.758l-3.122.987c-.237.889-.415 1.777-.514 2.686l4.228-1.363a1.84 1.84 0 0 1 1.857.81l6.659 8.551c.751.948 2.015 1.323 3.359 1.323.909 0 1.857-.178 2.687-.474l5.078-1.54c.632-.178 1.008-.829.81-1.481z" /><use href="#czlogo" /><use href="#czlogo" x="8.516" y="-2.172" /></g><defs><path id="czlogo" d="M18.689 28.654a1.94 1.94 0 0 1-1.936 1.935 1.94 1.94 0 0 1-1.936-1.935 1.94 1.94 0 0 1 1.936-1.935 1.94 1.94 0 0 1 1.936 1.935z" /></defs></svg>
						</span>
						{{ config('app.name', 'Laravel') }}
					</a>
				</div>
				<div class="col col-lg-9 d-flex align-items-center justify-content-end">
					<!-- Search visible on screens > 991px wide (lg breakpoint) -->
					<div class="position-relative flex-fill d-none d-lg-block pe-4 pe-xl-5">
						<i class="ci-search position-absolute top-50 translate-middle-y d-flex fs-lg text-white ms-3"></i>
						<input type="search" class="form-control form-control-lg form-icon-start border-white rounded-pill" placeholder="Tìm kiếm sản phẩm..." />
					</div>

					<!-- Button group -->
					<div class="d-flex align-items-center">
						<!-- Navbar stuck nav toggler -->
						<button type="button" class="navbar-toggler d-none navbar-stuck-show me-3" data-bs-toggle="collapse" data-bs-target="#stuckNav">
							<span class="navbar-toggler-icon"></span>
						</button>

						<!-- Theme switcher (light/dark/auto) -->
						<div class="dropdown">
							<button type="button" class="theme-switcher btn btn-icon btn-lg btn-outline-secondary fs-lg border-0 rounded-circle animate-scale" data-bs-toggle="dropdown">
								<span class="theme-icon-active d-flex animate-target">
									<i class="ci-sun"></i>
								</span>
							</button>
							<ul class="dropdown-menu" style="--cz-dropdown-min-width:9rem">
								<li>
									<button type="button" class="dropdown-item active" data-bs-theme-value="light">
										<span class="theme-icon d-flex fs-base me-2"><i class="ci-sun"></i></span>
										<span class="theme-label">Sáng</span>
										<i class="item-active-indicator ci-check ms-auto"></i>
									</button>
								</li>
								<li>
									<button type="button" class="dropdown-item" data-bs-theme-value="dark">
										<span class="theme-icon d-flex fs-base me-2"><i class="ci-moon"></i></span>
										<span class="theme-label">Tối</span>
										<i class="item-active-indicator ci-check ms-auto"></i>
									</button>
								</li>
								<li>
									<button type="button" class="dropdown-item" data-bs-theme-value="auto">
										<span class="theme-icon d-flex fs-base me-2"><i class="ci-auto"></i></span>
										<span class="theme-label">Tự động</span>
										<i class="item-active-indicator ci-check ms-auto"></i>
									</button>
								</li>
							</ul>
						</div>

						<!-- Search toggle button visible on screens < 992px wide (lg breakpoint) -->
						<button type="button" class="btn btn-icon btn-lg fs-xl btn-outline-secondary border-0 rounded-circle animate-shake d-lg-none" data-bs-toggle="collapse" data-bs-target="#searchBar">
							<i class="ci-search animate-target"></i>
						</button>

						<!-- Account button -->
						@guest
							<a class="btn btn-icon btn-lg fs-lg btn-outline-secondary border-0 rounded-circle animate-shake d-none d-md-inline-flex" href="{{ route('user.dangnhap') }}">
								<i class="ci-user animate-target"></i>
								<span class="visually-hidden">Tài khoản</span>
							</a>
						@else
							<a class="btn btn-icon btn-lg fs-lg btn-outline-secondary border-0 rounded-circle animate-shake d-none d-md-inline-flex" href="{{ route('user.home') }}">
								<i class="ci-user animate-target"></i>
								<span class="visually-hidden">{{ Auth::user()->name }}</span>
							</a>
						@endguest

						<!-- Cart button -->
						<button type="button" class="btn btn-icon btn-lg fs-xl btn-outline-secondary position-relative border-0 rounded-circle animate-scale" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart">
							<span class="position-absolute top-0 start-100 badge fs-xs text-bg-primary rounded-pill mt-1 ms-n4 z-2" style="--cz-badge-padding-y:.25em; --cz-badge-padding-x:.42em">{{ Cart::count() ?? 0 }}</span>
							<i class="ci-shopping-bag animate-target me-1"></i>
						</button>
					</div>
				</div>
			</div>
			<div class="navbar-stuck-hide pb-1"></div>
		</div>

		<!-- Search visible on screens < 992px wide (lg breakpoint) -->
		<div class="collapse position-absolute top-100 z-2 w-100 bg-dark d-lg-none" id="searchBar">
			<div class="container position-relative my-3" data-bs-theme="dark">
				<i class="ci-search position-absolute top-50 translate-middle-y d-flex fs-lg text-white ms-3"></i>
				<input type="search" class="form-control form-icon-start border-white rounded-pill" placeholder="Tìm kiếm sản phẩm..." data-autofocus="collapse" />
			</div>
		</div>

		<!-- Main navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
		<div class="collapse navbar-stuck-hide" id="stuckNav">
			<nav class="offcanvas offcanvas-start" id="navbarNav" tabindex="-1">
				<div class="offcanvas-header py-3">
					<h5 class="offcanvas-title" id="navbarNavLabel">{{ config('app.name', 'Laravel') }}</h5>
					<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
				</div>
				<div class="offcanvas-body py-3 py-lg-0">
					<div class="container px-0 px-lg-3">
						<div class="row">
							<!-- Navbar nav -->
							<div class="col-lg-9 d-lg-flex pt-3 pt-lg-0 ps-lg-0">
								<ul class="navbar-nav position-relative">
									<li class="nav-item me-lg-n1 me-xl-0">
										<a class="nav-link fs-sm active" href="{{ route('frontend.home') }}">Trang chủ</a>
									</li>
									<li class="nav-item me-lg-n1 me-xl-0">
										<a class="nav-link fs-sm" href="{{ route('frontend.sanpham') }}">Sản phẩm</a>
									</li>
									<li class="nav-item me-lg-n1 me-xl-0">
										<a class="nav-link fs-sm" href="{{ route('frontend.baiviet') }}">Tin tức</a>
									</li>
									<li class="nav-item me-lg-n1 me-xl-0">
										<a class="nav-link fs-sm" href="{{ route('frontend.tuyendung') }}">Tuyển dụng</a>
									</li>
									<li class="nav-item me-lg-n1 me-xl-0">
										<a class="nav-link fs-sm" href="{{ route('frontend.lienhe') }}">Liên hệ</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="offcanvas-header border-top px-0 py-3 mt-3 d-md-none">
					<div class="w-100">
						@guest
							<a class="btn btn-lg btn-secondary w-100" href="{{ route('user.dangnhap') }}">
								<i class="ci-user fs-lg ms-n1 me-2"></i> Đăng nhập
							</a>
						@else
							<a class="btn btn-lg btn-secondary w-100" href="{{ route('user.home') }}">
								<i class="ci-user fs-lg ms-n1 me-2"></i> {{ Auth::user()->name }}
							</a>
						@endguest
					</div>
				</div>
			</nav>
		</div>
	</header>

	<!-- Page content -->
	@yield('content')

	<!-- Page footer -->
	<footer class="footer position-relative bg-dark border-top">
		<span class="position-absolute top-0 start-0 w-100 h-100 bg-body d-none d-block-dark"></span>
		<div class="container position-relative z-1 pt-sm-2 pt-md-3 pt-lg-4" data-bs-theme="dark">
			<!-- Copyright -->
			<div class="d-md-flex align-items-center border-top py-4">
				<p class="text-body-secondary fs-xs text-center text-md-start mb-0">
					Bản quyền &copy; {{ date('Y') }} bởi <span class="animate-underline"><a class="animate-target text-dark-emphasis fw-medium text-decoration-none" href="{{ route('frontend.home') }}">{{ config('app.name', 'Laravel') }}</a></span>.
				</p>
			</div>
		</div>
	</footer>

	<!-- Floating buttons -->
	@yield('floating-button')

	<!-- Vendor scripts -->
	<script src="{{ asset('public/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
	<script src="{{ asset('public/assets/vendor/simplebar/simplebar.min.js') }}"></script>
	<script src="{{ asset('public/assets/vendor/choices.js/choices.min.js') }}"></script>
	<script src="{{ asset('public/assets/vendor/nouislider/nouislider.min.js') }}"></script>
	<script src="{{ asset('public/assets/vendor/drift-zoom/Drift.min.js') }}"></script>

	<!-- Bootstrap + Theme scripts -->
	<script src="{{ asset('public/assets/js/theme.min.js') }}"></script>
	@yield('javascript')
</body>
</html>