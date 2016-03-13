<?php
class CategoryMapper extends Mapper{

	public $table = 'category';
	public $fields = array('id', 'name', 'code', 'title');
	public $db;
	public $obj_name = 'Category';
	
	//Возвращает тайтл страницы категории по id
	public function getTitle($id){
		$sth = $this->db->prepare("SELECT `title` FROM ".$this->table." WHERE `id` = :id");
		$sth->execute(array('id' => $id));
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		$result = (!empty($row['title'])) ? $row['title'] : null;
		return $result;
	}
	//Получение категории по ее символьному коду
	public function getCategoryFromCode($code){
		$sth = $this->db->prepare("SELECT ".implode($this->fields, ', ')." FROM ".$this->table." WHERE `code` = :code");
		$sth->execute(array('code' => $code));
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
}