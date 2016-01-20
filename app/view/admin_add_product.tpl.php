<?php if(isset($_SESSION['message'])):?>
	<div class="error"><?=$_SESSION['message'];?></div>
<?php endif;?>
<?php if(!empty($this->error)):?>
	<p>Проверьте правильность заполнения формы:</p>
	<div class="error">
		<?php foreach($this->error as $error):?>
			<?=$error;?><br>
		<?php endforeach;?>
	</div>
<?php endif;?>
<form action='' method='POST' enctype='multipart/form-data'>
	<label>Название: <input type='text' name='name' value="<?=$this->value['name'];?>"></label><br>
	<label>Описание: <textarea name='description' rows='10' cols='70'><?=$this->value['description'];?></textarea></label><br>
	Категория: <select name='category'>
		<option value=''></option>
		<?php if(!empty($this->category)):?>
			<?php foreach($this->category as $category):?>
			<option value='<?=$category->code;?>'><?=$category->name;?></option>
			<?php endforeach;?>
		<?php endif;?>
	</select><br>
	<label>Цена: <input type='text' name='price' value="<?=$this->value['price'];?>"></label><br>
	<label>Title: <input type='text' name='title' value="<?=$this->value['title'];?>"></label><br>
	<input type='hidden' name='MAX_FILE_SIZE' value='1000000'>
	<label>Изображение: <input type='file' name='image'></label><br>
	<input type='submit' value='Добавить' name='add_product'>
</form>