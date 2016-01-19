<?php

//Валидация данных пользователя при регистрации
class UserValidate extends Validate{

	public $errors = array(); //Если при валидации будут ошибки, то будут добавляться сюда
	public $user; //Доменный объект пользоватля, данные, которые прошли валидацию будут добавляться сюда
	private $db;
	private $user_mapper;

	public function __construct(PDO $db){
		$this->db = $db;
		$this->user = new User;
		$this->user_mapper = new UserMapper($this->db); //Взаимодействи с БД, нужно для проверки уникальности email'a и телефона
	}

	//Получаем массив с данными ($_POST), которые заполнил пользователь при регистрации, заполням доменный объект пользователя
	public function valid($post_user){
		$this->nameValid($post_user['name']);
		$this->surnameValid($post_user['surname']);
		$this->emailValid($post_user['email']);
		$this->phoneValid($post_user['phone']);
		$this->cityValid($post_user['city']);
		$this->adressValid($post_user['adress']);
		$this->passValid($post_user['password'], $post_user['repassword']);
		//Заполняем поля объекта, которые не требуют валидации
		$this->user->date = date("Y-m-d H:i:s", time());
		$this->user->role = 'user'; //Роль пользователя по-умолчанию
		//Если ошибок нет - возвращаем заполненный объект пользователя
		if(empty($this->errors)){
			return $this->user;
		}else{
			return $this->errors;
		}
	}

	public function nameValid($data){
		$data = $this->strValid($data); //Приводим к строке
		if(empty($data)){
			$this->errors['name'] = 'Заполните поле';
		}elseif(mb_strlen($data, 'utf-8') < 2){
			$this->errors['name'] = 'Имя слишком короткое';
		}elseif(mb_strlen($data, 'utf-8') > 25){
			$this->errors['name'] = 'Имя слишком длинное';
		}else{
			$this->user->name = $data;
		}
	}
	
	public function surnameValid($data){
		$data = $this->strValid($data); //Приводим к строке
		if(empty($data)){
			$this->errors['surname'] = 'Заполните поле';
		}elseif(mb_strlen($data, 'utf-8') > 25){
			$this->errors['surname'] = 'Фамилия слишком длинная';
		}elseif(mb_strlen($data, 'utf-8') < 2){
			$this->errors['surname'] = 'Фамилия слишком короткая';
		}else{
			$this->user->surname = $data;
		}
	}

	public function emailValid($data){
		$data = $this->strValid($data); //Приводим к строке
		if(empty($data)){
			$this->errors['email'] = 'Поле пустое';
		}elseif(!filter_var($data, FILTER_VALIDATE_EMAIL)){
			$this->errors['email'] = 'Вы ввели некорректный email';
		}elseif($this->user_mapper->exist('email', $data)){
			$this->errors['email'] = 'Такой email уже существует';
		}else{
			$this->user->email = $data;
		}
	}

	public function phoneValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['phone'] = 'Поле пустое';
		}elseif(mb_strlen($data, 'utf-8') !== 10){
			$this->errors['phone'] = 'Номер телефона должен состоять из 10 цифр';
		}elseif($this->user_mapper->exist('phone', $data)){
			$this->errors['phone'] = 'Пользователь с таким телефоном уже зарегистрирован';
		}else{
			$this->user->phone = $data;
		}
	}

	public function cityValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['city'] = 'Поле пустое';
		}elseif(mb_strlen($data, 'utf-8') > 15){
			$this->errors['city'] = 'Название города слишком длинное';
		}elseif(mb_strlen($data, 'utf-8') < 2){
			$this->errors['city'] = 'Название города слишком короткое';
		}else{
			$this->user->city = $data;
		}
	}

	public function adressValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['adress'] = 'Поле пустое';
		}elseif(mb_strlen($data, 'utf-8') > 70){
			$this->errors['adress'] =  'Адрес слишком длинный';
		}elseif(mb_strlen($data, 'utf-8') < 2){
			$this->errors['adress'] =  'Адрес слишком короткий';
		}else{
			$this->user->adress = $data;
		}
	}
	
	public function passValid($data1, $data2){
		$data1 = $this->strValid($data1);
		$data2 = $this->strValid($data2);
		if(empty($data1) or empty($data2)){
			$this->errors['password'] = 'Введите оба пароля';
		}elseif(mb_strlen($data1, 'utf-8') < 5){
			$this->errors['password'] = 'Пароль слишком короткий';
		}elseif(mb_strlen($data1, 'utf-8') > 25){
			$this->errors['password'] = 'Пароль слишком длинный';
		}elseif($data1 !== $data2){
			$this->errors['password'] = 'Пароли не совпадают';
		}else{
			$this->user->password = $this->preparePass($data1);
		}
	}

	private function preparePass($data){
		$salt = uniqid(); //Генерируем соль (случайная строка из 13 символов)
		$password = md5($salt.$data); //Хэшируем соль с паролем
		$password = $salt.$password; //К началу хэшированого пароля добавляем соль
		return $password;
	}
	
}