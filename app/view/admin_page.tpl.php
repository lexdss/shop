<head>
	<title><?=$title;?></title>
	<link rel="stylesheet" href="/css/style.css">
</head>
<body>
	<div class="conteiner">
		<div class="sidebar">
			<ul>
				<li><a href='/'>Сайт</a></li>
				<li><a href='additem'>Добавить товар</a></li>
				<li><a href='category'>Категории</a></li>
				<li><a href='catalog'>Каталог товаров</a></li>
				<li><a href='orders'>Заказы</a></li>
			</ul>
		</div>
		<div class="content">
			<!--Подключение нужного раздела админки-->
			<?php require_once $content_template;?>
		</div>
		<div class="clearfix">
	</div>
</body>