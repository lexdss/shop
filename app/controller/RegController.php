<?php
//include 'User.php';
class RegController extends AController{
	
	//Регистрация пользователя
	public function indexAction(){

		if(isset($_POST['registration'])){

			//Валидация данных введеных пользователем
			$user_validate = new UserValidate($this->db);
			$result = $user_validate->valid($_POST);

			//В случае не пройденной валидации приходит массив ошибок, если пройдена - объект пользователя
			if(is_array($result)){

				$this->view->error = $result; //Массив с ошибками
				$this->view->value = $_POST; //То что ввел пользователь (для заполнения формы)
			}else{

				//Если все данные валидны сохраняем объект пользователя в БД
				$this->user_mapper->save($result);

				//Получаем ID нового пользователя и сохраняем его в сессионной переменной
				$user = $this->user_mapper->getUserFromEmail($result->email);
				$_SESSION['user_id'] = $user->id;
				$_SESSION['user_role'] = $user->role;
				header('Location: /');
				exit;
			}
		}

		$this->view->title = 'Страница регистрации'; // title страницы
		$this->view->render('reg.tpl.php');
	}
}