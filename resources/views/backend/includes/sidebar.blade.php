<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					@php
						$favIcon = \App\Models\Settings::shop_fav();
					@endphp
					@if(!is_null($favIcon))
						<img src="{{ asset('uploads/fav_logo/' . $favIcon->fav_icon) }}" class="logo-icon" alt="logo icon">
					@endif
				</div>
				<div>
					<h4 class="logo-text">
						@php
							$site_title = \App\Models\Settings::site_title();
						@endphp
						{{ (!is_null($site_title->site_title)) ? $site_title->site_title : 'Shop' }}
					</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>

			<!--navigation-->
			<ul class="metismenu" id="menu">
				<li>
					<a href="{{route('adminDashboard')}}">
						<div class="parent-icon">
							<i class="bx bx-home-circle"></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>				

				<li class="menu-label">User Management</li>
				<!-- all admin -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon">
							<i>
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check text-primary"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
							</i>
						</div>
						<div class="menu-title">All Admin</div>
					</a>
					<ul>
						<li>
							 <a href="{{ route('manage-admin') }}"><i class="bx bx-right-arrow-alt"></i>Manage All Admin</a>
						</li>
					</ul>
				</li>

				<!-- all user -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon">
							<i>
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users text-primary"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
							</i>
						</div>
						<div class="menu-title">All User</div>
					</a>
					<ul>
						<li>
							 <a href="{{ route('manage-user') }}"><i class="bx bx-right-arrow-alt"></i>Manage All User</a>
						</li>
						<li>
							<a href="{{ route('manage-message') }}"><i class="bx bx-right-arrow-alt"></i>User Message</a>
					   </li>
					</ul>
				</li>

				<li class="menu-label">Product Management</li>
				<!-- Brand Item -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-medal"></i>
						</div>
						<div class="menu-title">Brand</div>
					</a>
					<ul>
						<li>
							 <a href="{{ route('create-brand') }}"><i class="bx bx-right-arrow-alt"></i>Add New Brand</a>
						</li>
						<li>
							 <a href="{{ route('manage-brand') }}"><i class="bx bx-right-arrow-alt"></i>Manage Brands</a>
						</li>
					</ul>
				</li>

				<!-- Category Item -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Category</div>
					</a>
					<ul>
						<li>
							 <a href="{{ route('create-category') }}"><i class="bx bx-right-arrow-alt"></i>Add Parent Category</a>
						</li>
						<li>
							 <a href="{{ route('manage-category') }}"><i class="bx bx-right-arrow-alt"></i>All Parent Categories</a>
						</li>
						<li>
							 <a href="{{ route('create-subCategory') }}"><i class="bx bx-right-arrow-alt"></i>Add Sub Category</a>
						</li>
						<li>
							 <a href="{{ route('manage-subCategory') }}"><i class="bx bx-right-arrow-alt"></i>All Sub Categories</a>
						</li>
					</ul>
				</li>

				<!-- Product Item -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-gift"></i>
						</div>
						<div class="menu-title">Product</div>
					</a>
					<ul>
						<li>
							 <a href="{{ route('create-product') }}"><i class="bx bx-right-arrow-alt"></i>Add New Product</a>
						</li>
						<li>
							 <a href="{{ route('manage-product') }}"><i class="bx bx-right-arrow-alt"></i>Manage Product</a>
						</li>
						<li>
							<a href="{{ route('featured-product') }}"><i class="bx bx-right-arrow-alt"></i>Featured Product</a>
					   </li>
					   <li>
							<a href="{{ route('review-manage') }}"><i class="bx bx-right-arrow-alt"></i>Product Reviews</a>
				   		</li>
						   <li>
							<a href="{{ route('variation-product') }}"><i class="bx bx-right-arrow-alt"></i>Product Variation</a>
				   		</li>
					</ul>
				</li>
				
				<li class="menu-label">Order Management</li>
				<!-- Order Item -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="lni lni-cart-full"></i>
						</div>
						<div class="menu-title">Order</div>
					</a>
					<ul>
						<li>
							 <a href="{{ route('manage-order') }}"><i class="bx bx-right-arrow-alt"></i>Manage Orders</a>
						</li>
					</ul>
				</li>

				<!-- Wishlist Item -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-heart"></i>
						</div>
						<div class="menu-title">Wishlist</div>
					</a>
					<ul>
						<li>
							 <a href="{{ route('wishlistList') }}"><i class="bx bx-right-arrow-alt"></i>Wishlists List</a>
						</li>
					</ul>
				</li>

				<li class="menu-label">Marketing Tools</li>
				<!-- Coupon code -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="lni lni-offer"></i>
						</div>
						<div class="menu-title">Coupon</div>
					</a>
					<ul>
						<li>
							 <a href="{{ route('create-cupons') }}"><i class="bx bx-right-arrow-alt"></i>Add New Coupon</a>
						</li>
						<li>
							 <a href="{{ route('manage-cupons') }}"><i class="bx bx-right-arrow-alt"></i>Manage Coupons</a>
						</li>
					</ul>
				</li>

				<!-- Advertisement code -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="lni lni-bullhorn" style="font-size: 21px;"></i>
						</div>
						<div class="menu-title">Advertisement</div>
					</a>
					<ul>
						<li>
							 <a href="app-emailbox.html"><i class="bx bx-right-arrow-alt"></i>Add New Advertisement</a>
						</li>
						<li>
							 <a href="app-emailbox.html"><i class="bx bx-right-arrow-alt"></i>Manage Advertisement</a>
						</li>
					</ul>
				</li>

				<!-- Customer List -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="lni lni-customer"></i>
						</div>
						<div class="menu-title">Customers</div>
					</a>
					<ul>
						<li>
							 <a href="{{ route('manage-customer') }}"><i class="bx bx-right-arrow-alt"></i>Manage Customers</a>
						</li>
					</ul>
				</li>

				<li class="menu-label">Shipping Management</li>
				<!-- Country List -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-world"></i>
						</div>
						<div class="menu-title">Country</div>
					</a>
					<ul>
						<li>
							 <a href="{{ route('create-country') }}"><i class="bx bx-right-arrow-alt"></i>Add New Country</a>
						</li>
						<li>
							 <a href="{{ route('manage-country') }}"><i class="bx bx-right-arrow-alt"></i>Manage All Country</a>
						</li>
					</ul>
				</li>

				<!-- State List -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-map-alt"></i>
						</div>
						<div class="menu-title">State</div>
					</a>
					<ul>
						<li>
							 <a href="{{ route('create-state') }}"><i class="bx bx-right-arrow-alt"></i>Add New State</a>
						</li>
						<li>
							 <a href="{{ route('manage-state') }}"><i class="bx bx-right-arrow-alt"></i>Manage State</a>
						</li>
					</ul>
				</li>

				<!-- District List -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-location-plus"></i>
						</div>
						<div class="menu-title">District</div>
					</a>
					<ul>
						<li>
							 <a href="{{ route('create-district') }}"><i class="bx bx-right-arrow-alt"></i>Add New District</a>
						</li>
						<li>
							 <a href="{{ route('manage-district') }}"><i class="bx bx-right-arrow-alt"></i>Manage District</a>
						</li>
					</ul>
				</li>


				<li class="menu-label">Platform Settings</li>
				<!-- Settings List -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-cog"></i>
						</div>
						<div class="menu-title">Settings</div>
					</a>
					<ul>
						<li>
							 <a href="{{ route('manage-genarelSettings') }}"><i class="bx bx-right-arrow-alt"></i>General Settings</a>
						</li>
						<li>
							 <a href="{{ route('manage-currency') }}"><i class="bx bx-right-arrow-alt"></i>Currency Settings</a>
						</li>
						<li>
							<a href="{{ route('shipping-manage') }}"><i class="bx bx-right-arrow-alt"></i>Shipping Method</a>
					   </li>
					</ul>
				</li>

				<li class="menu-label">Reports</li>
				<!-- Reports List -->
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fadeIn animated bx bx-file"></i>
						</div>
						<div class="menu-title">Reports</div>
					</a>
					<ul>
						<li>
							 <a href="{{route('selling-reports')}}"><i class="bx bx-right-arrow-alt"></i>Selling Reports</a>
						</li>
						<li>
							 <a href="app-emailbox.html"><i class="bx bx-right-arrow-alt"></i>Product Reports</a>
						</li>
					</ul>
				</li>
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->