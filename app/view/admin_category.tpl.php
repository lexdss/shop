<?php if(!empty($_SESSION['message'])):?>
	<div class="error"><?=$_SESSION['message'];?></div>
<?php endif;?>
<form action='' method='POST'>
<div class="table">
	<div class="row">
		<div class="cell"><b>Категория</b></div>
		<div class="cell"><b>Символьный код</b></div>
		<div class="cell"><b>ID</b></div>
	</div>
	<?php if(!empty($this->category)):?>
		<?php foreach($this->category as $category):?>
			<div class="row">
				<div class="cell"><label><input type='checkbox' name='<?=$category->id;?>' value='<?=$category->id;?>'><?=$category->name;?></label></div>
				<div class="cell"><?=$category->code;?></div>
				<div class="cell"><?=$category->id;?></div>
			</div>
		<?php endforeach;?>
	<?php endif;?>
</div>
<input type='submit' value='Удалить' name='delete_category'>
</form>

<form action='' method='POST'>
	<div class="form-input"><label>Название категории: <input type='text' name='name' value="<?=$this->value['name'];?>"></label><span class="error"><?=$this->error['name'];?></span></div>
	<div class="form-input"><label>Символьный код: <input type='text' name='code' value="<?=$this->value['code'];?>"></label><span class="error"><?=$this->error['code'];?></span></div>
	<div class="form-input"><label>Заоловок страницы (title): <input type='text' name='title' value="<?=$this->value['title'];?>"></label><span class="error"><?=$this->error['title'];?></span></div>
	<div class="form-input"><input type='submit' value='Добавить' name='add_category'></div>
</form>