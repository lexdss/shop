<?php

class UserMapper extends Mapper{

	public $table = 'user';
	public $fields = array('id', 'name', 'surname', 'email', 'phone', 'city', 'adress', 'password', 'date', 'role');
	public $db;
	public $obj_name = 'User';

	//Получение данных пользователя по логину(emeil)
	public function getUserFromEmail($email){
		$sth = $this->db->prepare("SELECT ".implode($this->fields, ', ')." FROM ".$this->table." WHERE `email` = :email");
		$sth->execute(array('email' => $email));
		if(!empty($row = $sth->fetch(PDO::FETCH_ASSOC))){
			$domain_obj = new $this->obj_name;
			foreach($this->fields as $field){
				$domain_obj->$field = $row[$field]; 
			}
		}
		$result = (empty($domain_obj)) ? false : $domain_obj;
		return $result;
	}
}