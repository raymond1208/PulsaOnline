<!-- Auto Detect Model -->
{{-- App\Modules\Avelca\Controllers\AvelcaController::mainNavigation() --}}
<!-- End Auto Detect Model -->

@if($user->hasAccess('bank') || $user->hasAccess('product') || $user->hasAccess('status'))
<li>
				<a href="#"><i class="glyphicon glyphicon-th-large"></i> Master<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
						
						<li>
						<a href="{{ URL::to('admin/bank') }}">Bank</a>
						</li>
						
						<li>
						<a href="{{ URL::to('admin/product') }}">Product</a>
						</li>
						
						<li>
						<a href="{{ URL::to('admin/status') }}">Status</a>
						</li>
						
				</ul>
</li>		
@endif
		<li>
			<a href="#"><i class="glyphicon glyphicon-list-alt"></i> Transaction<span class="fa arrow"></span></a>
			<ul class="nav nav-second-level collapse">
				
						<li>
						<a href="{{ URL::to('admin/sales-order') }}">Sales Order</a>
						</li>
									</ul>
		</li>

@if($user->hasAccess('report'))
		<li> 
			<a href="#"><i class="glyphicon glyphicon-stats"></i> Report<span class="fa arrow"></span></a> 
			<ul class="nav nav-second-level collapse" style="height: auto;"> 
			<li> <a href="{{ URL::to('admin/report') }}">Best Seller</a></li> 
			</ul> 
		</li>
@endif
@if($user->hasAccess('module'))
		<li> 
			<a href="#"><i class="glyphicon glyphicon-flash"></i> Modules<span class="fa arrow"></span></a> 
			<ul class="nav nav-second-level collapse"> 
			<li> <a href="{{ URL::to('admin/module') }}">Manage</a></li>  
			</ul> 
		</li>   
@endif
@if($user->hasAccess('user') || $user->hasAccess('group') || $user->hasAccess('setting'))
		<li> 
			<a href="#"><i class="fa fa-cog fa-fw"></i> Administration<span class="fa arrow"></span></a> 
			<ul class="nav nav-second-level collapse">  
				<li> <a href="#">Access Control <span class="fa arrow"></span></a> 
					<ul class="nav nav-third-level collapse">  
						<li> <a href="{{ URL::to('admin/user') }}">User</a> </li>   
						<li> <a href="{{ URL::to('admin/group') }}">Group</a> </li> 
					</ul> 
				</li>   
				<li> <a href="{{ URL::to('admin/setting') }}">Setting</a> </li>  
			</ul> 
		</li>  
@endif
