<div class="content">
	<?php if(!empty($basket)):?>
		<div class="table">
			<div class="row">
				<div class="cell"><b>Наименование</b></div>
				<div class="cell"><b>Количество</b></div>
				<div class="cell"><b>Цена</b></div>
				<div class="cell"><b>Убрать товар</b></div>
			</div>
				<?php foreach($basket as $id => $item):?>
					<div class="row">
						<div class="cell"><?=$item['name'];?></div>
						<div class="cell"><?=$item['count'];?> шт.</div>
						<div class="cell"><?=$item['price'];?> руб.</div>
						<div class="cell"><a href='?del_item=<?=$id;?>'>Убрать</a></div>
					</div>
				<?php endforeach;?>
		</div>
		<div><b>Итого</b>: <?=$this->basket_info['total_sum']?> руб.</div>
		<!--Если пользователь не авторизован или зарегистрирован-->
		<?php if(!isset($_SESSION['user_id'])):?>
			<div>Для подтверждения заказа войдите или <a href="/reg/">зарегистрируйтесь</a></div>
		<?php else:?>
			<form action="/basket" method="post">
			Способ оплаты:
				<select name="pay">
					<option value="cash">Наличные</option>
					<option value="e-money">Электронные деньги</option>
					<option value="cod">Наложенный платеж</option>
				</select>
				<br>
			Способ доставки:
				<select name="delivery">
					<option value="post">Почта</option>
					<option value="courier">Курьер</option>
					<option value="delivery">Служба доставки</option>
				</select>
				<br>
				<input type="submit" name="confirm_order" value="Подтвердить заказ">
			</form>
		<?php endif;?>
		<!--После подтверждения заказа-->
	<?php elseif(isset($_SESSION['message'])):?>
		<?=$_SESSION['message'];?>
		<!--Если корзина пуста-->
	<?php else:?>
		<div class="error">Ваша корзина пуста</div>
	<?php endif;?>
</div>
<div class="clearfix"></div>
</div>