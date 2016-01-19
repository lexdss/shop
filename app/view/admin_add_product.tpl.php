<?php if(isset($_SESSION['message'])):?>
	<div class="error"><?=$_SESSION['message'];?></div>
<?php endif;?>
<form action='' method='POST' enctype='multipart/form-data'>
	<label>Название: <input type='text' name='name' value="<?=$this->value['name'];?>"></label><span class="error"><?=$this->error['name'];?></span><br>
	<label>Описание: <textarea name='description' rows='10' cols='70'><?=$this->value['description'];?></textarea></label><span class="error"><?=$this->error['description'];?></span><br>
	Категория: <select name='category'>
		<option value=''></option>
		<?php if(!empty($this->category)):?>
			<?php foreach($this->category as $category):?>
			<option value='<?=$category->code;?>'><?=$category->name;?></option>
			<?php endforeach;?>
		<?php endif;?>
	</select><span class="error"><?=$this->error['category'];?></span><br>
	<label>Цена: <input type='text' name='price' value="<?=$this->value['price'];?>"></label><span class="error"><?=$this->error['price'];?></span><br>
	<label>Title: <input type='text' name='title' value="<?=$this->value['title'];?>"></label><span class="error"><?=$this->error['title'];?></span><br>
	<input type='hidden' name='MAX_FILE_SIZE' value='1000000'>
	<label>Изображение: <input type='file' name='image'></label><span class="error"><?=$this->error['image'];?></span><br>
	<input type='submit' value='Добавить' name='add_product'>
</form>