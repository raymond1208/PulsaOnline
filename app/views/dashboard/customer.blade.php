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
			{{ Widget::greeting() }}
			<h3>Announcement :</h3>
			<marquee><h2>{{Setting::meta_data('announcement','message')->value}}</h2></marquee>
			<div class="jumbotron">
				<h2>Welcome to Pulsa Online App</h2>
				<p>Kami menjual bermacam-macam produk pulsa yang dapat anda beli secara online, mudah, cepat dan aman.</p>
				<table cellspacing="30" class="table">
					<tbody>
						<tr>
							<td><img src="Simpati.jpg" alt="Telkomsel Simpati" height="150" width="150"></td>
							<td><img src="As.jpg" alt="Telkomsel Kartu AS" height="150" width="150"></td>
							<td><img src="Indosat.jpg" alt="Indosat" height="150" width="150"></td>
							<td><img src="tri.jpg" alt="Three" height="150" width="150"></td>
							<td><img src="XL.jpg" alt="XL" height="150" width="150"></td>
						</tr>
						<tr>
							<td><center>Simpati<center></td>
							<td><center>Kartu As<center></td>
							<td><center>Indosat<center></td>
							<td><center>Three<center></td>
							<td><center>XL<center></td>
						</tr>
					</tbody>
				</table>
				
				<br><br><h3>Tunggu apa lagi? <a href="{{ URL::to('admin/sales-order') }}">Pesan Sekarang..!</a></h3>
			</div>
		</div>
		<!-- Silahkan Tambah Di Bawah Sini -->
		
	</div>
</div>

<!--
<div class="row">
	<div class="col-lg-12">
		{{ Widget::greeting() }}

		
			<h2>Getting Started</h2>
			<p>Avelca helps you create business application faster. You just need to focus on specific value-added features of your application and let Avelca handles the core functionality and generares required resources. You can still modify source code or configure settings. </p>

			<p><a href="{{ URL::to('admin/setting') }}" class="btn theme-color">Go to Setting <span class="glyphicon glyphicon glyphicon-chevron-right"></span></a></p>
		</div>
	</div>
	<!-- /.col-lg-12 
</div>
 /.row -->

@stop