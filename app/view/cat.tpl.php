		<div class="content">
		<?php if(!empty($this->item)):?>
			<?php foreach($this->item as $item):?>
				<div class="item">
					<p class="item-name"><a href="/cat/<?=$item->category;?>?item_id=<?=$item->id;?>"><?=$item->name;?></a></p>
					<img class="prew-img" src="/<?=$item->image;?>">
					<div class="buy"><a href="/cat/<?=$item->category;?>?add=<?=$item->id;?>">Купить</a> | <?=$item->price;?> руб.</div>
				</div>
			<?php endforeach;?>
		<?php endif;?>
		</div>
	<div class="clearfix"></div>
</div>