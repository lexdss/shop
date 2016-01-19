<?php if(isset($_SESSION['message'])):?>
	<?=$_SESSION['message'];?>
<?php endif;?>
	<p>Данные заказа: <br>
	ID заказа: <?=$this->order->id;?><br>
	Статус: <?=$this->order->status;?><br>
	Способ доставки: <?=$this->order->delivery;?><br>
	Способ оплаты: <?=$this->order->pay;?><br>
	Дата: <?=$this->order->date;?></p>

	<span>Заказано:</span>
	<table border="1">
		<tr>
			<th>Название товара</th>
			<th>Цена</th>
			<th>Количество</th>
		</tr>
		<?php if(!empty($this->product)):?>
			<?php foreach($this->product as $product):?>
				<tr>
					<td><a href="/cat/<?=$product->category;?>/<?=$product->id;?>"><?=$product->name;?></a></td>
					<td><?=$product->price;?></td>
					<td><?=$product->count;?></td>
				</tr>
			<?php endforeach;?>
		<?php endif;?>
	</table>
	<span>Сумма оплаты: <?=$this->order->total_sum;?></span>

<p>Данные пользователя:<br>
<?=$this->user->name;?> <?=$this->user->surname;?>, <?=$this->user->city;?>, <?=$this->user->adress;?>, тел. <?=$this->user->phone;?></p>

<form action="" method="POST">
	<select name="status">
		<option value="processing">В обработке</option>
		<option value="sent">Отправлен</option>
		<option value="received">Получен</option>
	</select>
	<input type="submit" name="change_order_status" value="Изменить статус">
</form>