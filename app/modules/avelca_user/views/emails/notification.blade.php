@extends('layouts/email')

@section('content')
<h1>Hi Administrator,</h1>

<p>There is new transaction created. The transaction is as follow:</p>


<p>Transaction Code: {{ $code }}</p>
<p>Date : {{ $date }}</p>
<p>Created at : {{ date('d F Y') }}</p>
<p>Paid? :{{ $is_paid }}</p>

<p>Please kindly review the transaction by clicking this link.</p>

<h3><a href="{{ URL::to('admin/sales-order/').'?code='.$code }}">{{ $code }}</a></h3>

<p>Best Regards</p>
@stop