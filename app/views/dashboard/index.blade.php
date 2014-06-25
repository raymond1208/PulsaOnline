@extends('layouts/default')

@section('content')

<link type "text/css" rel "stylesheet" href "twitter/css/bootstrap.css"/>


<?php
$con=mysqli_connect("127.0.0.1","Raymond","qwerty","pulsaonline");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
<div class="row">
	<div class="col-md-12">
 
		<ol class="breadcrumb">
			<li><a href="{{ URL::to('dashboard') }}">Dashboard</a></li>
			<li><a href="javascript:;">Reports</a></li>
			<li class="active">Best Seller Product</li>
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
					
					<th>Is_Paid</th>
					<th>Show Data</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$result = mysqli_query($con,"SELECT id, code, sales_date, is_paid FROM sales_orders where deleted_at IS NULL");
				
				while($row = mysqli_fetch_array($result)) 
				{
					echo "<tr>";
					echo "<td>" . $row['code'] . "</td>";
					echo "<td>" . $row['sales_date'] . "</td>";
					echo "<td>" . $row['is_paid'] . "</td>";
					echo "<td>
							<form action='".URL::to('themes/avelca_backend/detail.blade.php')."' method='POST'>
								<input type='hidden' name='tempId' value='".$row["id"]."'/>
								<input class='btn' type='submit' name='submit-btn' value='View Transaction' />
							</form>
							</td>";
					echo "</tr>";
				}
				?>
			
			
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