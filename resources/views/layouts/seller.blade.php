<?php

    $general = App\Models\General::find(1)->first();

 ?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>Squishy Duck</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<link rel="icon" type="image/png" sizes="32x32" href="{{asset('storage/upload/logo')}}/{{$general->fav_icon}}" />

<!-- CSS
================================================== -->
<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{asset('content')}}/css/style.css">
<link rel="stylesheet" href="{{asset('content')}}/css/colors/blue.css">
@stack('css')
</head>
<body class="gray">

<!-- Wrapper -->
<div id="wrapper" id="app">

<!-- Header Container
================================================== -->
<header id="header-container" class="fullwidth dashboard-header not-sticky">

	<!-- Header -->
	<div id="header">
		<div class="container">

			<!-- Left Side Content -->
			<div class="left-side">

				<!-- Logo -->
				<div id="logo">
					<a href="{{url('/')}}"><img src="{{asset('content')}}/images/ff.png" alt=""></a>
				</div>

                <nav id="navigation">
                    <ul id="responsive">
                        <li><a href="{{ route('seller.market') }}" class="{{ Request::is('seller/market*') ? 'text-success' : '' }}">Market</a></li>
                        <li><a href="{{ route('seller.viewServices') }}" class="{{ Request::is('seller/services*') ? 'text-success' : '' }}">Service</a></li>
                        <li><a href="{{ route('seller.listing') }}" class="{{ Request::is('seller/listing*') ? 'text-success' : '' }}">Rentals</a></li>
                    </ul>
                </nav>
				<div class="clearfix"></div>
				<!-- Main Navigation / End -->

			</div>
			<!-- Left Side Content / End -->


			<!-- Right Side Content / End -->
			<div class="right-side">


				<!-- User Menu -->
				<div class="header-widget">

					<!-- Messages -->
					<div class="header-notifications user-menu">
						<div class="header-notifications-trigger">
							<a href="#"><div class="user-avatar status-online"><img src="{{asset('storage/upload/profile')}}/{{ Auth::guard('seller')->user()->profile  }}" alt=""></div></a>
						</div>

						<!-- Dropdown -->
						 <div class="header-notifications-dropdown">

                            <!-- User Status -->
                            <div class="user-status">

                                @isset(Auth::guard('seller')->user()->name)
                                <!-- User Name / Avatar -->
                                <div class="user-details">
                                    <div class="user-avatar status-online"><img src="{{asset('storage/upload/profile')}}/{{ Auth::guard('seller')->user()->profile  }}" alt=""></div>
                                    <div class="user-name">
                                  {{ Auth::guard('seller')->user()->name  }}
                                         <span>Freelancer</span>
                                    </div>
                                </div>
                                  @endisset

                        </div>


                        <ul class="user-menu-small-nav">
                            <li><a href="{{url('/seller/dashboard')}}"><i class="icon-material-outline-dashboard"></i> Dashboard</a></li>

                            <li><a href="{{url('/buyer-job-post')}}"><i class="icon-material-outline-dashboard"></i> Buyer Request</a></li>

                            <li><a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
                        </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                        </div>
					</div>

				</div>
				<!-- User Menu / End -->

				<!-- Mobile Navigation Button -->
				<span class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</span>

			</div>
			<!-- Right Side Content / End -->

		</div>
	</div>
	<!-- Header / End -->

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->

<!-- Dashboard Container -->
<div class="dashboard-container">
	@if ( !Request::is('seller/market*') && !Request::is('chat/*') && !Request::is('seller/create-schedule*') && !Request::is('seller/create-service*') && !Request::is('seller/services*') && !Request::is('seller/listing*'))
	<!-- Dashboard Sidebar
	================================================== -->
	<div class="dashboard-sidebar">
		<div class="dashboard-sidebar-inner" data-simplebar>
			<div class="dashboard-nav-container">

				<!-- Responsive Navigation Trigger -->
				<a href="#" class="dashboard-responsive-nav-trigger">
					<span class="hamburger hamburger--collapse" >
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</span>
					<span class="trigger-title">Dashboard Navigation</span>
				</a>

				<!-- Navigation -->
				<div class="dashboard-nav">
					<div class="dashboard-nav-inner">
						<ul>
							<li><a href="{{url('/seller/dashboard')}}" class="{{ Request::is('seller/dashboard*') ? 'text-primary' : '' }}"><i class="icon-material-outline-dashboard {{ Request::is('seller/dashboard*') ? 'text-primary' : '' }}"></i> Dashboard</a></li>
                        </ul>
						<ul data-submenu-title="Schedule">
							<li><a href="{{ route('seller.viewSchedule') }}" class="{{ Request::is('seller/view-schedule*') ? 'text-primary' : '' }}">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="{{ Request::is('seller/view-schedule*') ? 'text-primary' : '' }} bi bi-calendar mr-2"
								    viewBox="0 0 16 16">
								    <path
								        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
								</svg>View Schedule</a></li>
						</ul>
						<ul data-submenu-title="Requests">
							<li><a href="{{ route('seller.incomingRequests') }}" class="{{ Request::is('seller/incoming-requests*') ? 'text-primary' : '' }}"><i class="icon-material-outline-assignment {{ Request::is('seller/incoming-requests*') ? 'text-primary' : '' }}"></i> Incoming Requests</a></li>
						</ul>
						<ul data-submenu-title="Organize and Manage Services">
							<li><a href="{{ route('seller.service') }}" class="{{ Request::is('seller/service*') ? 'text-primary' : '' }}"><i class="icon-material-outline-assignment {{ Request::is('seller/service*') ? 'text-primary' : '' }}"></i> Services</a></li>
							<li><a href="{{ route('seller.serviceHistory') }}" class="{{ Request::is('seller/history*') ? 'text-primary' : '' }}">
								<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-up-right pt-1 mr-2" width="18" height="18" viewBox="0 0 18 13">
								    <path fill-rule="evenodd"
								        d="M14 2.5a.5.5 0 0 0-.5-.5h-6a.5.5 0 0 0 0 1h4.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V8.5a.5.5 0 0 0 1 0v-6z" />
								</svg> Service History</a></li>
						</ul>
						<ul data-submenu-title="Account">
							<li><a href="{{url('/seller/setting')}}"><i class="icon-material-outline-settings"></i> Settings</a></li>
							<li><a href="#"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
						</ul>
						<ul data-submenu-title="Other">
							<li><a href="#">
								<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-flag pt-1 mr-2"
								    viewBox="0 0 18 13">
								    <path
								        d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21.294 21.294 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21.317 21.317 0 0 0 14 7.655V1.222z" />
								</svg>Report Incident</a></li>
						</ul>
					</div>
				</div>
				<!-- Navigation / End -->

			</div>
		</div>
	</div>
	<!-- Dashboard Sidebar / End -->
	@endif


 @yield('content')
</div>
<!-- Dashboard Container / End -->

</div>
<!-- Wrapper / End -->

<!-- Scripts
================================================== -->
<script src="{{asset('content')}}/js/jquery-3.3.1.min.js"></script>
<script src="{{asset('content')}}/js/jquery-migrate-3.0.0.min.js"></script>
<script src="{{asset('content')}}/js/mmenu.min.js"></script>
<script src="{{asset('content')}}/js/tippy.all.min.js"></script>
<script src="{{asset('content')}}/js/simplebar.min.js"></script>
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('bootstrap/js/bootstrap-tagsinput.js')}}"></script>
<script src="{{asset('content')}}/js/bootstrap-slider.min.js"></script>
<script src="{{asset('content')}}/js/bootstrap-select.min.js"></script>
<script src="{{asset('content')}}/js/snackbar.js"></script>
<script src="{{asset('content')}}/js/clipboard.min.js"></script>
<script src="{{asset('content')}}/js/counterup.min.js"></script>
<script src="{{asset('content')}}/js/magnific-popup.min.js"></script>
<script src="{{asset('content')}}/js/slick.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{asset('content')}}/js/custom.js"></script>
<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<script>
// Snackbar for user status switcher
$('#snackbar-user-status label').click(function() {
	Snackbar.show({
		text: 'Your status has been changed!',
		pos: 'bottom-center',
		showAction: false,
		actionText: "Dismiss",
		duration: 3000,
		textColor: '#fff',
		backgroundColor: '#383838'
	});
});
</script>
@stack('js')
</body>
</html>
