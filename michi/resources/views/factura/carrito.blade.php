<tbody id="cart">
@forelse($items as $row)
<tr id="products">
  	<td>{{ $row->attributes->codigo }}</td>
  	<td>{{ $row->name }}</td>
  	<td>${{ number_format($row->price, 2) }}</td>
  	<td>{{ $row->quantity }}</td>
  	<td>{{ $row->attributes->categoria }}</td>
  	<td>${{ number_format($row->getPriceSum(), 2) }}</td>
  	<td align="center"><a href="javascript:;" class="btn btn-danger btn-sm borrar" data="{{ $row->id }}"><i class="fas fa-trash-alt"></i></a></td>
</tr>
@empty
<tr id="products">
	<td colspan="7" align="center"><p>No hay productos disponible</p></td>
</tr>
@endforelse
<?php 
  $subtotal = \Cart::getTotal();
  $iva = $subtotal * 0.13;
  $total = $subtotal + $iva;
 ?>
<tr id="products" style="border-style: none;">
    <td colspan="6" align="right"><b>Subtotal:</b></td>
    <td>${{ number_format($subtotal, 2) }}</td>
</tr>
<tr id="products" class="table-borderless" style="border-style: none;">
    <td colspan="6" align="right"><b>IVA:</b></td>
    <td>${{ number_format($iva, 2) }}</td>
</tr>
<tr id="products">
    <td colspan="6" align="right"><b>Total:</b></td>
    <td>${{ number_format($total, 2) }}</td>
</tr>
</tbody>