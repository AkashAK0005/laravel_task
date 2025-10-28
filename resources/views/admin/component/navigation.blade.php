	<nav class="pcoded-navbar menupos-fixed menu-light brand-blue ">
	    <div class="navbar-wrapper ">
	        <div class="navbar-brand header-logo">
	            <a href="index.html" class="b-brand">
	                <h3 style="color: #fff;">Task</h3>
	            </a>
	            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
	        </div>
	        <div class="navbar-content scroll-div">
	            <ul class="nav pcoded-inner-navbar">
				    <li class="nav-item">
	                    <a href="{{ route('dashboard') }}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
	                </li>
					<li class="nav-item">
	                    <a href="{{ route('user.index') }}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Users</span></a>
	                </li>
	            </ul>
	        </div>
	    </div>
	</nav>