@extends('layouts/default')

@section('content')

<div class="row">
	<div class="col-md-12">
 		<!--<ol class="breadcrumb">
			<li><a href="{{ URL::to('dashboard') }}">Dashboard</a></li>
			<li><a href="javascript:;">Reports</a></li>
			<li class="active">Best Seller Product</li>
		</ol> -->
 
		<div class="page-header">
			<h1>
				<center>Customer's Dashboard</center> <center>{{ Widget::greeting() }}</center>
			</h1>
			<h2>Welcome to Pulsa Online App</h2>
			<p>Kami menjual bermacam-macam produk pulsa yang dapat anda beli secara online, mudah, cepat dan aman.</p>
			<ul>
				<li>Telkomsel (SIMPATI)</li>
				<li>Kartu AS</li>
				<li>Indosat</li>
				<li>XL</li>
				<li>3 (Tri)</li>
			</ul>

		</div>
		<!-- Silahkan Tambah Di Bawah Sini -->
		
	</div>
</div>

<!--
<div class="row">
	<div class="col-lg-12">
		{{ Widget::greeting() }}

		<div class="jumbotron">
			<h2>Getting Started</h2>
			<p>Avelca helps you create business application faster. You just need to focus on specific value-added features of your application and let Avelca handles the core functionality and generares required resources. You can still modify source code or configure settings. </p>

			<p><a href="{{ URL::to('admin/setting') }}" class="btn theme-color">Go to Setting <span class="glyphicon glyphicon glyphicon-chevron-right"></span></a></p>
		</div>
	</div>
	<!-- /.col-lg-12 
</div>
 /.row -->

@stop