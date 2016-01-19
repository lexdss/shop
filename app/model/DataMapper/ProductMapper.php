<?php

class ProductMapper extends Mapper{
	public $table = 'product';
	public $fields = array('id', 'category', 'name', 'description', 'title', 'price', 'image');
	public $db; 
	public $obj_name = 'Product';

	//Извлечение товаров по категории
	public function getProductFromCategory($category){
		$sth = $this->db->prepare("SELECT ".implode($this->fields, ', ')." FROM ".$this->table." WHERE `category` = :category ".$this->order_by);
		$sth->execute(array('category' => $category));
		$rows = $sth->fetchAll(PDO::FETCH_ASSOC);
		//Создание доменного объекта и заполнение его полей
		foreach($rows as $row){
			$domain_obj = new $this->obj_name;
			foreach($this->fields as $field){
				$domain_obj->$field = $row[$field];
			}
			$result[] = $domain_obj;
		}
		$result = (empty($result)) ? false : $result;
		return $result; 
	}

	//Возвращает тайтл страницы товара по id
	public function getTitle($id){
		$sth = $this->db->prepare("SELECT `title` FROM ".$this->table." WHERE `id` = :id");
		$sth->execute(array('id' => $id));
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		$result = (!empty($row['title'])) ? $row['title'] : null;
		return $result;
	}
}