<?php
//include 'User.php';
class RegController extends Controller{
	
	//Регистрация пользователя
	public function indexAction(){

		if(isset($_POST['registration'])){

			//Валидация данных введеных пользователем
			$result = $this->service->get('user_validate')->valid($_POST);

			//В случае не пройденной валидации приходит массив ошибок, если пройдена - объект пользователя
			if(is_array($result)){

				$view_data['error'] = $result; //Массив с ошибками
				$view_data['value'] = $_POST; //То что ввел пользователь (для заполнения формы)
			}else{

				//Если все данные валидны сохраняем объект пользователя в БД
				$this->service->get('user_mapper')->save($result);

				//Получаем ID нового пользователя и сохраняем его в сессионной переменной
				$user = $this->service->get('user_mapper')->getUserFromEmail($result->email);
				$_SESSION['user_id'] = $user->id;
				$_SESSION['user_role'] = $user->role;
				header('Location: /');
				exit;
			}
		}

		$view_data['title'] = 'Страница регистрации'; // title страницы
		$this->service->get('view')->render('reg.tpl.php', $view_data);
	}
}