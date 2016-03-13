<?php
class Mapper{
	
	public $table; //@string Имя таблицы
	public $fields; //@array Поля таблицы
	public $db; //Объект PDO
	public $obj_name; //@string Имя доменного объекта для динамического создания
	public $order_by = 'ORDER BY id DESC'; //Сортировка по-умолчанию

	public function __construct(PDO $db){
		$this->db = $db;
	}

	//Выборка из БД
	public function getAll(){
		$sth = $this->db->query("SELECT ".implode($this->fields, ', ')." FROM `".$this->table."` ".$this->order_by);
		$rows = $sth->fetchAll(PDO::FETCH_ASSOC);
		//Создаем массив объектов
		foreach($rows as $row){
			$domain_obj = new $this->obj_name;
			foreach($this->fields as $field){
				$domain_obj->$field = $row[$field]; //Заполняем свойства доменного объекта
			}
			$result[] = $domain_obj;
		}
		$result = (empty($result)) ? false : $result;
		return $result;
	}

	//Извлечение по ID
	public function getFromID($id){
		$sth = $this->db->prepare("SELECT ".implode($this->fields, ', ')." FROM `".$this->table."` WHERE `id` = :id");
		$sth->execute(array('id' => $id));
		//Создание доменного объекта и заполнение его полей
		if(!empty($row = $sth->fetch(PDO::FETCH_ASSOC))){
			$domain_obj = new $this->obj_name;
			foreach($this->fields as $field){
				$domain_obj->$field = $row[$field]; 
			}
		}
		$result = (empty($domain_obj)) ? false : $domain_obj;
		return $result;
	}

	//Добавление/редактирование
	public function save($domain_obj){
		//Если поле id пустое - добавляем, если нет - обновляем
		if(empty($domain_obj->id)){

			//Создание массива с плейсхолдерами
			foreach($this->fields as $field){
				$placeholders[] = ':'.$field;
			}
			
			$sth = $this->db->prepare("INSERT INTO `".$this->table."`(".implode($this->fields, ', ').") VALUES(".implode($placeholders, ', ').")");
			$sth->execute((array)$domain_obj);
		}else{
			
			//Создание массива с полями и плейсхолдерами (field = :field)
			foreach($this->fields as $field){
				$upd[] = $field.' = :'.$field;
			}
			$sth = $this->db->prepare("UPDATE `".$this->table."` SET ".implode($upd, ', ')." WHERE `id` = :id");
			$sth->execute((array)$domain_obj);
		}
	}

	//Удаление
	public function delete($id){
		$sth = $this->db->prepare("DELETE FROM ".$this->table." WHERE `id` = :id");
		$result = $sth->execute(array('id' => $id));
		return $result;
	}

	//Проверка сущствования заданного значения в заданном столбце
	public function exist($field, $search){
		$sth = $this->db->prepare("SELECT ".$field." FROM ".$this->table." WHERE ".$field." LIKE :search");
		$sth->execute(array('search' => $search));
		$result = (empty($result = $sth->fetch())) ? false : true;
		return $result;
	}
}