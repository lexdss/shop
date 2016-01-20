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
			$this->errors['name'] = 'Имя: поле пустое';
		}elseif(mb_strlen($data, 'utf-8') < 2 | mb_strlen($data, 'utf-8') > 25){
			$this->errors['name'] = 'Имя: от 2 до 25 символов';
		}else{
			$this->user->name = $data;
		}
	}
	
	public function surnameValid($data){
		$data = $this->strValid($data); //Приводим к строке
		if(empty($data)){
			$this->errors['surname'] = 'Фамилия: поле пустое';
		}elseif(mb_strlen($data, 'utf-8') > 25 | mb_strlen($data, 'utf-8') < 2){
			$this->errors['surname'] = 'Фамилия: от 2 до 25 символов';
		}else{
			$this->user->surname = $data;
		}
	}

	public function emailValid($data){
		$data = $this->strValid($data); //Приводим к строке
		if(empty($data)){
			$this->errors['email'] = 'Email: поле пустое';
		}elseif(!filter_var($data, FILTER_VALIDATE_EMAIL)){
			$this->errors['email'] = 'Email: некорректное значение';
		}elseif($this->user_mapper->exist('email', $data)){
			$this->errors['email'] = 'Email: такой email уже существует';
		}else{
			$this->user->email = $data;
		}
	}

	public function phoneValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['phone'] = 'Телефон: поле пустое';
		}elseif(preg_match('/^[0-9]{10}$/', $data) !== 1){
			$this->errors['phone'] = 'Телефон: должен состоять из 10 цифр';
		}elseif($this->user_mapper->exist('phone', $data)){
			$this->errors['phone'] = 'Телефон: телефоном уже зарегистрирован в системе';
		}else{
			$this->user->phone = $data;
		}
	}

	public function cityValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['city'] = 'Город: поле пустое';
		}elseif(mb_strlen($data, 'utf-8') > 15 | mb_strlen($data, 'utf-8') < 2){
			$this->errors['city'] = 'Город: от 2 до 15 символов';
		}else{
			$this->user->city = $data;
		}
	}

	public function adressValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['adress'] = 'Адрес: поле пустое';
		}elseif(mb_strlen($data, 'utf-8') > 70 | mb_strlen($data, 'utf-8') < 2){
			$this->errors['adress'] =  'Адрес: от 2 до 70 символов';
		}else{
			$this->user->adress = $data;
		}
	}
	
	public function passValid($data1, $data2){
		$data1 = $this->strValid($data1);
		$data2 = $this->strValid($data2);
		if(empty($data1) or empty($data2)){
			$this->errors['password'] = 'Пароль: ведите оба пароля';
		}elseif(mb_strlen($data1, 'utf-8') < 5 | mb_strlen($data1, 'utf-8') > 25){
			$this->errors['password'] = 'Пароль: от 2 до 25 символов';
		}elseif($data1 !== $data2){
			$this->errors['password'] = 'Пароль: пароли не совпадают';
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