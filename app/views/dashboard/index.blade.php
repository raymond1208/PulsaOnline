@extends('layouts/default')

@section('content')

<div class="row">
	<div class="col-md-12">
 
		<ol class="breadcrumb">
		   <li><a href="{{ URL::to('dashboard') }}">Dashboard</a></li>
		   <li><a href="javascript:;" class="active">Administrator</a></li>
		 </ol>
 
		<div class="page-header">
			<h1>
				Administrator Dashboard
				<small>{{ date('d-F-Y') }}</small>
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
		
			@if( count($sales_orders) > 0) 
				@foreach($sales_orders as $sales_order)
					<tr>
						<td><a href="{{ URL::to('admin/sales-order/').'?code='.$sales_order->code }}">{{ $sales_order->code }}</a></td>
						<td>{{ date('d-F-Y',strtotime(str_replace('-','/', $sales_order->sales_date))) }}</td>
						<td>{{ $sales_order->is_paid }}</td>
					</tr>
				@endforeach
			@endif
			
			</tbody>
		</table>
	</div>
</div>
@stop