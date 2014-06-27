@extends('layouts/default')

@section('content')

<link type "text/css" rel "stylesheet" href "twitter/css/bootstrap.css"/>


<div class="row">
	<div class="col-md-12">
 
		<ol class="breadcrumb">
		   <li><a href="{{ URL::to('dashboard') }}">Dashboard</a></li>
		   <li><a href="javascript:;" class="active">Administrator</a></li>
		 </ol>
 
		<div class="page-header">
			<h1>
				Administrator Dashboard
				<small>{{ date('Y-m-d') }}</small>
			</h1>
		</div>
 
		
		<!-- Silahkan Tambah Di Bawah Sini -->
		<h3>Transaction Report</h3>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>SO Code</th>
					<th>Transaction Date</th>
					
					<th>Is Paid</th>
				</tr>
			</thead>
			<tbody>
			{{ $sales_orders }}
			
			@if( count($sales_orders) > 0) 
				@foreach($sales_orders as $sales_order)
					<tr>
						<td><a href="{{ URL::to('admin/sales-order/').'?code='.$sales_order->code }}">{{ $sales_order->code }}</a></td>
						<td>{{ $sales_order->sales_date }}</td>
						<td>{{ $sales_order->is_paid }}</td>
					</tr>
				@endforeach
			@endif
			
			</tbody>
		</table>
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