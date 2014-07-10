<center><h2>Total transaksi:
{{ $jumlah = SalesOrderItem::where('sales_order_id', '=', $record->id)->sum('price'); }}
</h2></center>