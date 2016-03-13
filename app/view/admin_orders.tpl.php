<?php if(isset($_SESSION['message'])):?>
	<div class="error"><?=$_SESSION['message'];?></div>
<?php endif;?>
<?php if(!empty($orders)):?>
	<table border=1>
		<tr>
			<th>Номер заказа</th>
			<th>Сумма</th>
			<th>Статус</th>
			<th>Дата</th>
		</tr>
			<?php foreach($orders as $order):?>
				<tr>
					<td><a href="/admin/orders?order=<?=$order->id;?>"><?=$order->id;?></a></td>
					<td><?=$order->total_sum;?> руб</td>
					<td><?=$order->status;?></td>
					<td><?=$order->date;?></td>
				</tr>
			<?php endforeach;?>
	</table>
<?php endif;?>