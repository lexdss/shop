<div class="conteiner">
		<div class="sidebar">
			<ul>
				<li><a href="/">Главная</a></li>
				<?php if(!empty($this->category)):?>
					<?php foreach($this->category as $category):?>
						<li><a href="/cat/<?=$category->code;?>"><?=$category->name;?></a></li>
					<?php endforeach;?>
			<?php endif;?>
			</ul>
		</div>