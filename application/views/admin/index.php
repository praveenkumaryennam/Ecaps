<table border="1">
	<tr>
		<td colspan="2">Order value Edit</td>
	</tr>
	<form method="post" action="<?= base_url('adminedit/orders');?>">
		
	<tr>
		<td>Order Number</td>
		<td>
			<input type="text" name="order_number" />
		</td>
	</tr>

	<tr>
		<td>Column</td>
		<td>
			<select name="col">
				<option> --- </option>
				<option value="client_code">Doctor</option>
			</select>
		</td>
	</tr>

	<tr>
		<td>Value</td>
		<td>
			<input type="text" name="code" />
		</td>
	</tr>

	<tr>
		<td colspan="2">
			<input type="submit" name="submit" />
		</td>
	</tr>

	</form>
</table>