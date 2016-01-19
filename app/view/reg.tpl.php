<?php if(!isset($_SESSION['user_id'])):?>
	<div class="content">
		<?php if(isset($_SESSION['message'])):?>
			<div class="error"><?=$_SESSION['message'];?></div>
		<?php endif;?>
		<form action='' method='POST'>
			<label>Имя: <input type='text' name='name' value="<?=$this->value['name'];?>"></label><span class="error"><?=$this->error['name'];?></span><br>
			<label>Фамилия: <input type='text' name='surname' value="<?=$this->value['surname'];?>"></label><span class="error"><?=$this->error['surname'];?></span><br>
			<label>E-mail: <input type='text' name='email' value="<?=$this->value['email'];?>"></label><span class="error"><?=$this->error['email'];?></span><br>
			<label>Телефон: +7<input type='text' name='phone' value="<?=$this->value['phone'];?>"></label><span class="error"><?=$this->error['phone'];?></span><br>
			<label>Город: <input type='text' name='city' value="<?=$this->value['city'];?>"></label><span class="error"><?=$this->error['city'];?></span><br>
			<label>Адрес: <input type='text' name='adress' value="<?=$this->value['adress'];?>"></label><span class="error"><?=$this->error['adress'];?></span><br>
			<label>Пароль: <input type='password' name='password'></label><span class="error"><?=$this->error['password'];?></span><br>
			<label>Повторите пароль: <input type='password' name='repassword'></label><br>
			<input type='submit' value='Зарегистрироваться' name='registration'>
		</form>
	</div>
	<div class="clearfix"></div>
	</div>
<?php else:?>
	<div class="error">Вы уже зарегистрированы</div>
<?php endif;?>