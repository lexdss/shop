<head>
	<title><?=$this->title;?></title>
	<link rel="stylesheet" href="/css/style.css">
</head>
<body>
	<div class="header">
		<div class="basket"><a href='/basket/'>Корзина:</a> <?=$this->basket_info['total_count'];?> товаров на сумму: <?=$this->basket_info['total_sum'];?> руб.</div>
		<?php if(!$_SESSION['user_id']):?>
		<div class="auth">
			<form action='/auth' method='POST'>
				<label>Логин: <input type='text' name='email'></label>
				<label>Пароль: <input type='password' name='password'></label>
				<input type='submit' value='Вход' name='login'>
				<span class="error"><?=$_SESSION['message'];?></span>
			</form>
			<a href='/reg/'>Регистрация</a>
		</div>
		<?php endif;?>
		<?php if($_SESSION['user_role'] == 'admin'):?>
			<a href='/admin/'>Панель управления</a>
		<?php endif;?>
		<?php if(isset($_SESSION['user_id'])):?>
			<a href='/auth?act=logout'>Выход</a>
		<?php endif;?>
	</div>