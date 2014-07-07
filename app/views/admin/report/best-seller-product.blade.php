@extends('layouts/default')
		
@section('content')

<div class="row">
	<div class="col-md-12">
		
		<ol class="breadcrumb">
			<li><a href="{{ URL::to('dashboard') }}">Dashboard</a></li>
			<li><a href="javascript:;">Reports</a></li>
			<li class="active">Best Seller Product</li>
		</ol>

		<div class="page-header">
			<h1>
				Best Seller Product for {{ date('F Y') }}
			</h1>

		</div>
				<div class = "container">
				 <!-- Awal Form -->
				 {{ Form::open(array('url' => 'admin/report/', 'method' => 'POST')) }}
				  
				  <div class="input-group datepicker col-lg-2" data-date-format="YYYY-MM-DD" style = "float: left; margin-left: -15px;" >
						{{ Form::text('start_date', Input::get('start_date') ? Input::get('start_date') : date('Y-m-').'1', array('class' => 'form-control', 'id' => 'from')) }}
						
							<span class="input-group-addon">
				   <span class="glyphicon-calendar glyphicon"></span></span>
						</div>
				  
				  <div class="input-group datepicker col-lg-2" data-date-format="YYYY-MM-DD" style = "float: left; margin-left: 50px;">
							{{ Form::text('end_date', Input::get('end_date') ? Input::get('end_date') : date('Y-m-').'31', array('class' => 'form-control', 'id' => 'to')) }}
							<span class="input-group-addon">
				   <span class="glyphicon-calendar glyphicon"></span></span>
				  </div>
				  
				  <span style = "float: left; margin-left: 39px;">
				   {{ Form::submit('Filter Date', array('class'=>'btn','id'=>'new_button', 'style' => 'color: white; background-color: '.Setting::meta_data('general', 'theme_color')->value )); }}  
				  </span>
				  {{ Form::close() }}
				  <!-- Akhir Form -->
				 </div>
				 <br><br>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Product Name</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>

							@foreach($bestsellers as $bestseller)
								<tr>
									<td>{{ $bestseller->name }}</td>
									<td>{{ $bestseller->jumlah_kode }}</td>
									
								</tr>
							@endforeach

					</tbody>
				</table>
				 
	</div>
</div>

@stop