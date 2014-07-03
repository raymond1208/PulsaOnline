<?php


$con=mysqli_connect("127.0.0.1","Raymond","qwerty","pulsaonline");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$old_transaction;

$akses = mysqli_query($con,"SELECT COUNT(CODE) as totalCode FROM sales_orders");

echo $akses->fetch_object()->totalCode;

$current_transaction = $akses->fetch_object()->totalCode;

echo "current : ".$current_transaction;

//echo $current_transaction->fetch_object()->totalCode;

if(empty($old_transaction))
{
	$old_transaction=0;
}

if ($akses->fetch_object()->totalCode > $old_transaction)
{
	echo "Kirim Email. Transaksi baru ";
	$beda = $akses-$old_transaction;
	
	echo "akses :".$akses;
	echo "beda :".$beda;
	echo "old :".$old_transaction;
}
else
{
	echo "Tidak ada penambahan";
}




//mail("xaveriuz1208@gmail.com","Test","Hello Test","From: webmaster@jualpulsa.hol.es");

?>