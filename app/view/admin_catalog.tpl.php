<p>Выберите категорию:</p>
<div class="catalog-menu">
	<a href="/admin/catalog">Все</a>
	<?php if(!empty($this->category)):?>
		<?php foreach($this->category as $category):?>
			<a href="/admin/catalog?cat=<?=$category->code;?>"><?=$category->name;?></a>
		<?php endforeach;?>
	<?php endif;?>
</div>

<?php if(!empty($_SESSION['message'])):?>
	<div class="error"><?=$_SESSION['message'];?></div>
<?php endif;?>
<div>
	<form action='' method='POST'>
	<div>Все товары:</div>
		<div class="table">
			<div class="row">
				<div class="cell"><b>Название</b></div>
				<div class="cell"><b>Категория</b></div>
				<div class="cell"><b>Цена</b></div>
			</div>
			<?php if(!empty($this->items)):?>
				<?php foreach($this->items as $item):?>
					<div class="row">
						<div class="cell">
							<input type='checkbox' name='<?=$item->id;?>' value='<?=$item->id;?>'>
							<a href=" /cat/<?=$item->category;?>/<?=$item->id;?> "><?=$item->name;?></a>
						</div>
						<div class="cell"><?=$item->category;?></div>
						<div class="cell"><?=$item->price;?> руб.</div>
					</div>
				<?php endforeach;?>
			<?php endif;?>
		</div>
		<input type='submit' name='delete_product' value='Удалить'>
	</form>
</div>