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
		<?php
			$con=mysqli_connect("127.0.0.1","Raymond","qwerty","pulsaonline");

			// Check connection
			if (mysqli_connect_errno()) {
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
		?>
			<h1>
				Best Seller Product
				<small>{{ date('Y-m-d') }}</small>
			</h1>

		</div>
			<h2>Daftar produk dengan jumlah penjualan terbanyak:</h2><br>
			<table class="table table-bordered">
			<thead>
				<tr>
					<th>Name</th>
					<th>Jumlah Penjualan</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$result = mysqli_query($con,"SELECT  NAME, COUNT(`sales_order_items`.`id`) AS 'Jumlah_Penjualan' FROM `sales_order_items` INNER JOIN `products` ON `products`.`id`=`sales_order_items`.`product_id` GROUP BY `product_id` ORDER BY `Jumlah_Penjualan` DESC;");
				
				while($row = mysqli_fetch_array($result)) 
				{
					echo "<tr>";
					echo "<td>" . $row['NAME'] . "</td>";
					echo "<td>" . $row['Jumlah_Penjualan'] . "</td>";
					echo "</tr>";
				}
			?>
			</tbody>
			</table>
	</div>
</div>

@stop