@extends('layouts/default')

@section('content')

<table class="table">
			<thead>
				<tr>
					<th>Sales Order ID</th>
					<th>Phone</th>
					<th>Product Name</th>
				</tr>

<?php
$con=mysqli_connect("127.0.0.1","Raymond","qwerty","pulsaonline");
$id = $_POST['tempId'];

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT `sales_order_items`.`sales_order_id`, `sales_order_items`.`phone`, `products`.`name` FROM `sales_order_items` INNER JOIN `products` ON `sales_order_items`.`product_id` = `products`.`id` where sales_order_id=$id; ");

				while($row = mysqli_fetch_array($result)) 
				{
					echo "<tr>";
					echo "<td>" . $row['sales_order_id'] . "</td>";
					echo "<td>" . $row['phone'] . "</td>";
					echo "<td>" . $row['name'] . "</td>";
					echo "</tr>";
				}

?>
@stop