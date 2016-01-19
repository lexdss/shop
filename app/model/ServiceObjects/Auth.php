<?php

class Auth{

	private $user_mapper;

	public function __construct($user_mapper){
		$this->user_mapper = $user_mapper;
	}

	//Принимаем $_POST массив с логином (email'ом и паролем)
	public function login($data){

		//Получаем объект пользователя с таким логином, если он есть
		if(!$user = $this->user_mapper->getUserFromEmail($data['email'])){
			$_SESSION['message'] = 'Пользоватeля с таким логином не существует';
		}else{

			//Вытаскиваем соль (первые 13 символов пароля)
			//mb_internal_encoding('UTF-8'); 
			$salt = mb_substr($user->password, 0, 13, 'UTF-8');
			//Сравниваем
			if($user->password !== $salt.md5($salt.$data['password'])){
				$_SESSION['message'] = 'Вы ввели не правильный пароль';
			}else{
				$_SESSION['user_id'] = $user->id;
				$_SESSION['user_role'] = $user->role;
			}
		}
	}
}