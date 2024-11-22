<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!-- Disable caching to prevent history navigation -->
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="0">
		<link rel="icon" type="image/x-icon" href="{{ asset('admin/src/favicon.png') }}" />
     
    	@include('admin.layouts.header')

	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

		<!-- begin:: Page -->

		<!-- begin:: Header Mobile -->
		<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
			<div class="kt-header-mobile__logo">
				<a href="{{ route('dashboard') }}">
					<img alt="Logo" src="{{ asset('assets/media/logos/logo.svg') }}" style="width:110px;" />
				</a>
			</div>
			<div class="kt-header-mobile__toolbar">
				<button class="kt-header-mobile__toggler" id="kt_aside_mobile_toggler"><span></span></button>
				<button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
			</div>
		</div>

		<!-- end:: Header Mobile -->

		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

				<!-- begin:: Aside -->

				@include('admin.layouts.sidebar')

				<!-- end:: Aside -->

				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

					<!-- begin:: Header -->
					<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">

						<!-- begin:: Header Menu -->

						<div class="" id="">
							
						</div>

						<!-- end:: Header Menu -->

						<!-- begin:: Header Topbar -->
						<div class="kt-header__topbar">

							<!--begin: User Bar -->
							<div class="kt-header__topbar-item kt-header__topbar-item--user">
								<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
									<div class="kt-header__topbar-user">
										<img class="" alt="Pic" src="{{ asset('admin/src/assets/img/placeholder-user.svg') }}" 
											style="width:40px;"
										/>
									</div>
								</div>
								<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
									<!--begin: Navigation -->
									<ul class="kt-nav">
										<li class="kt-nav__head">
											<div class="emoji me-2 kt-nav__item">
												<i class="flaticon-user" style="font-size:28px"></i>&nbsp;
											</div>
											<div class="media-body">
												@if (auth()->check() && auth()->user()->first_name)
													<h5>{{ ucfirst(auth()->user()->first_name) }}</h5>
												@else
													<h5>Keynotes</h5>
												@endif
												<span class="kt-nav-text">Keynotes</span>
											</div>
										</li>
										<li class="kt-nav__separator"></li>
										<li class="kt-nav__item">
											<a href="{{ url('admin/change/password/view') }}" class="kt-nav__link">
											<i class="la la-unlock" style="font-size:28px"></i>&nbsp;&nbsp;&nbsp;
												<span class="kt-nav__link-text">Change Password</span>
											</a>
										</li>
										<li class="kt-nav__item">
											<a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('frm-logout').submit();" class="kt-nav__link">
												<i class="la la-sign-out" style="font-size:28px"></i>&nbsp;&nbsp;&nbsp;
												<span class="kt-nav__link-text">Log Out</span>
											</a>
											<form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
												{{ csrf_field() }}
											</form>
										</li>
									</ul>

									<!--end: Navigation -->
								</div>
							</div>

							<!--end: User Bar -->
						</div>

						<!-- end:: Header Topbar -->
					</div>

					<!-- end:: Header -->

					<!-- begin main section: -->

					<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
						@yield('content')
					</div>
					
					<!-- end main section: -->


					<!-- begin:: Footer -->
					<div class="kt-footer  kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
						<div class="kt-container  kt-container--fluid ">
							<div class="kt-footer__copyright">
								2024&nbsp;&copy;&nbsp;<span class="kt-link">Key-Notes</span>
							</div>
						</div>
					</div>

					<!-- end:: Footer -->
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!-- begin::Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
			<i class="fa fa-arrow-up"></i>
		</div>

		<!-- end::Scrolltop -->

		<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
		@include('admin.layouts.footer')
		<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
		
		@yield('script')
	</body>

	<!-- end::Body -->
</html>