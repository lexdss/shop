<?php if(!isset($_SESSION['user_id'])):?>
	<div class="content">
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
		<form action='' method='POST'>
			<label>Имя: <input type='text' name='name' value="<?=$this->value['name'];?>"></label><br>
			<label>Фамилия: <input type='text' name='surname' value="<?=$this->value['surname'];?>"></label><br>
			<label>E-mail: <input type='text' name='email' value="<?=$this->value['email'];?>"></label><br>
			<label>Телефон: +7<input type='text' name='phone' value="<?=$this->value['phone'];?>"></label><br>
			<label>Город: <input type='text' name='city' value="<?=$this->value['city'];?>"></label><br>
			<label>Адрес: <input type='text' name='adress' value="<?=$this->value['adress'];?>"></label><br>
			<label>Пароль: <input type='password' name='password'></label><br>
			<label>Повторите пароль: <input type='password' name='repassword'></label><br>
			<input type='submit' value='Зарегистрироваться' name='registration'>
		</form>
	</div>
	<div class="clearfix"></div>
	</div>
<?php else:?>
	<div class="error">Вы уже зарегистрированы</div>
<?php endif;?>