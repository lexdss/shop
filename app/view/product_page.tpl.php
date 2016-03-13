<div class="content">
		<div class="detail-item">
			<h3><?=$item->name;?></h3>
			<div class="detail-image"><img src='/<?=$item->image;?>'></div>
			<div class="price"><b>Цена</b>: <?=$item->price;?> | <a href='/cat/<?=$item->category;?>?add=<?=$item->id;?>'>Купить</a></div>
			<div class="description">
				<p><b>Описание:</b></p>
				<?=$item->description;?>
			</div>
		</div>
</div>
<div class="clearfix"></div>
</div>