<div class="content">
		<div class="detail-item">
			<h3><?=$this->item->name;?></h3>
			<div class="detail-image"><img src='/<?=$this->item->image;?>'></div>
			<div class="price"><b>Цена</b>: <?=$this->item->price;?> | <a href='/cat/<?=$this->item->category;?>?add=<?=$this->item->id;?>'>Купить</a></div>
			<div class="description">
				<p><b>Описание:</b></p>
				<?=$this->item->description;?>
			</div>
		</div>
</div>
<div class="clearfix"></div>
</div>