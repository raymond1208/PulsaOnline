<br>
<table border=2 class="table">
	<tr>
		<td colspan="4"><b>Transaksi: </b></td>
		<td>Rp {{ number_format($jumlah = SalesOrderItem::where('sales_order_id', '=', $record->id)->sum('price'),2,",",".") }}</td>
	</tr>
</table>


