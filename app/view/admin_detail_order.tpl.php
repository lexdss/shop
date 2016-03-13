<?php if(isset($_SESSION['message'])):?>
	<?=$_SESSION['message'];?>
<?php endif;?>
	<p>Данные заказа: <br>
	ID заказа: <?=$order->id;?><br>
	Статус: <?=$order->status;?><br>
	Способ доставки: <?=$order->delivery;?><br>
	Способ оплаты: <?=$order->pay;?><br>
	Дата: <?=$order->date;?></p>

	<span>Заказано:</span>
	<table border="1">
		<tr>
			<th>Название товара</th>
			<th>Цена</th>
			<th>Количество</th>
		</tr>
		<?php if(!empty($product)):?>
			<?php foreach($product as $product):?>
				<tr>
					<td><a href="/cat/<?=$product->category;?>/<?=$product->id;?>"><?=$product->name;?></a></td>
					<td><?=$product->price;?></td>
					<td><?=$product->count;?></td>
				</tr>
			<?php endforeach;?>
		<?php endif;?>
	</table>
	<span>Сумма оплаты: <?=$order->total_sum;?></span>

<p>Данные пользователя:<br>
<?=$user->name;?> <?=$user->surname;?>, <?=$user->city;?>, <?=$user->adress;?>, тел. <?=$user->phone;?></p>

<form action="" method="POST">
	<select name="status">
		<option value="processing">В обработке</option>
		<option value="sent">Отправлен</option>
		<option value="received">Получен</option>
	</select>
	<input type="submit" name="change_order_status" value="Изменить статус">
</form>