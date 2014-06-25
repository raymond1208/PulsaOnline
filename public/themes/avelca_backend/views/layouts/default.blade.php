<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>
		@if( ! empty($Model) )
		{{ get_class($Model) }} {{ $title }} - 
		@endif
		{{ Setting::meta_data('general', 'name')->value }} - {{ Setting::meta_data('general', 'tag_line')->value }}
	</title>

	<link rel="shortcut icon" type="image/x-icon" href="{{ Theme::asset('images/favicon.ico') }}">

	<!-- Core CSS - Include with every page -->
	{{ HTML::style(Theme::asset('css/bootstrap.css')) }}
	{{ HTML::style(Theme::asset('font-awesome/css/font-awesome.css')) }}
	
	<!-- Page-Level Plugin CSS - Tables -->
	{{ HTML::style(Theme::asset('css/plugins/dataTables/dataTables.bootstrap.css')) }}

	<!-- Datatable -->
	{{ HTML::style(Theme::asset('css/datatables_bootstrap3/datatables.css')) }}

	<!-- Colorpicker -->
	{{ HTML::style(Theme::asset('css/colorpicker/bootstrap-colorpicker.css')) }}

	<!-- Color Picker -->
	{{ HTML::style(Theme::asset('css/jquery.simplecolorpicker.css')) }}
	{{ HTML::style(Theme::asset('css/jquery.simplecolorpicker-fontawesome.css')) }}

	<!-- DateTime -->
	{{ HTML::style(Theme::asset('css/bootstrap-datetimepicker.min.css')) }}

	<!-- Bootstrap Select -->
	{{ HTML::style(Theme::asset('css/bootstrap-select/bootstrap-select.min.css')) }}

	<!-- SB Admin CSS - Include with every page -->
	{{ HTML::style(Theme::asset('css/style.css')) }}
	{{ HTML::style(Theme::asset('css/theme.css')) }}
	
	
	
	<!-- Color Theme -->
	<?php $theme_color = Setting::meta_data('general', 'theme_color')->value; ?>
	<style type="text/css">
	.theme-color {
		background-color: {{ $theme_color }};
		color: #ffffff;
	}
	a, a:hover {
		color: {{ $theme_color }};
	}
	.navbar, .navbar-top-links li a:hover, .navbar-top-links li a:focus, .nav .open>a:focus {
		background-color: {{ $theme_color }};
	}

	table.table thead {
		background-color: {{ $theme_color }};
		color: #ffffff;
	}
	ul.pagination>li.active a {
		background-color: {{ $theme_color }};
	}
	</style>

	<!-- Core Scripts - Include with every page -->
	{{ HTML::script(Theme::asset('js/jquery-1.10.2.js')) }}
	{{ HTML::script(Theme::asset('js/bootstrap.min.js')) }}
	{{ HTML::script(Theme::asset('js/plugins/metisMenu/jquery.metisMenu.js')) }}

	<!-- Datepicker -->
	{{ HTML::script(Theme::asset('js/jquery-ui/jquery-ui.min.js')) }}
	{{ HTML::style(Theme::asset('css/jquery-ui/overcast/jquery-ui.css')) }}

	<!-- DataTable -->
	{{ HTML::script(Theme::asset('js/datatables/jquery.dataTables.min.js')) }}  
	{{ HTML::script(Theme::asset('js/datatables_bootstrap3/datatables.js')) }}
	{{ HTML::script(Theme::asset('js/jquery.dataTables.columnFilter.js')) }}

	{{ HTML::style(Theme::asset('css/dataTables.tableTools.min.css')) }}
	{{ HTML::script(Theme::asset('js/dataTables.tableTools.min.js')) }}
</head>

<body>

	<div id="wrapper">

		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<ul class="nav navbar-top-links navbar-left">
					<li><a href="javascript:;" id="toggle_sidebar" hide="N" ><i class="glyphicon glyphicon-align-justify"></i></a></li>
				</ul>
				<a class="navbar-brand" href="{{ URL::to('dashboard') }}">{{ Setting::meta_data('general', 'name')->value }}</a>
			</div>
			<!-- /.navbar-header -->

			<ul class="nav navbar-top-links navbar-right">

	

				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<?php $user = Sentry::getUser(); ?>
						<i class="fa fa-user fa-fw"></i> {{ $user->first_name.' ('.$user->email.')' }} <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="{{ URL::to('account') }}"><i class="fa fa-user fa-fw"></i> My Account</a>
						</li>
						<li class="divider"></li>
						<li><a href="{{ URL::to('signout') }}"><i class="fa fa-sign-out fa-fw"></i> Sign Out</a>
						</li>
					</ul>
					<!-- /.dropdown-user -->
				</li>
				<!-- /.dropdown -->
			</ul>
			<!-- /.navbar-top-links -->

		</nav>
		<!-- /.navbar-static-top -->

		<nav class="navbar-default navbar-static-side" role="navigation">
			<div class="sidebar-collapse">
				@include('partial.sidemenu')
			</div>
			<!-- /.sidebar-collapse -->
		</nav>
		<!-- /.navbar-static-side -->

		<div id="page-wrapper">

			{{ Widget::get('form-validation') }}

			@yield('content')

			<hr>

			<footer>
				<p class="text-center">{{ date('Y') }} &copy; {{ Setting::meta_data('general', 'organization')->value }} - Powered by {{ HTML::link('http://www.avelca.com', 'Avelca', array('target', '_blank')) }}</p>
			</footer>

		</div>
		<!-- /#page-wrapper -->

	</div>
	<!-- /#wrapper -->

	<!-- Page-Level Plugin Scripts - Tables -->
	{{ HTML::script(Theme::asset('js/plugins/dataTables/jquery.dataTables.js')) }}
	{{ HTML::script(Theme::asset('js/plugins/dataTables/dataTables.bootstrap.js')) }}

	<!-- CKEDITOR -->
	{{ HTML::script(Theme::asset('js/ckeditor/ckeditor.js')) }}
	{{ HTML::script(Theme::asset('js/ckeditor/adapters/jquery.js')) }}

	<!-- Bootstrap Select -->
	{{ HTML::script(Theme::asset('js/bootstrap-select/bootstrap-select.min.js')) }}

	<!-- Color Picker -->
	{{ HTML::script(Theme::asset('js/jquery.simplecolorpicker.js')) }}

	<!-- Colorpicker -->
	{{ HTML::script(Theme::asset('js/colorpicker/bootstrap-colorpicker.min.js')) }}

	<!-- DateTime -->
	{{ HTML::script(Theme::asset('js/moment.min.js')) }}
	{{ HTML::script(Theme::asset('js/bootstrap-datetimepicker.min.js')) }}

	<!-- SB Admin Scripts - Include with every page -->
	{{ HTML::script(Theme::asset('js/script.js')) }}


</body>

</html>
