<?php
class ProductValidate extends Validate{

	public $errors = array(); //Если при валидации будут ошибки, то будут добавляться сюда
	public $product; //Доменный объект товара, данные, которые прошли валидацию будут добавляться сюда

	public function __construct(){
		$this->product = new Product;
	}

	//Получаем массив с данными товара
	public function valid($post_product){
		$this->categoryValid($post_product['category']);
		$this->nameValid($post_product['name']);
		$this->descriptionValid($post_product['description']);
		$this->titleValid($post_product['title']);
		$this->priceValid($post_product['price']);
		$this->imageValid($_FILES['image']);

		//Если есть ошибки - отправляем их, если нет - объект товара
		if(!empty($this->errors)){
			return $this->errors;
		}else{
			return $this->product;
		}
	}

	public function categoryValid($data){
		if(empty($data)){
			$this->errors['category'] = 'Категория: выберите категорию';
		}else{
			$this->product->category = $data;
		}
	}

	public function nameValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['name'] = 'Название: поле пустое';
		}elseif(mb_strlen($data, 'utf-8') > 50 | mb_strlen($data, 'utf-8') < 2){
			$this->errors['name'] = 'Название: от 2 до 50 символов';
		}else{
			$this->product->name = $data;
		}
	}
	
	public function descriptionValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['description'] = 'Описание: поле пустое';
		}elseif(mb_strlen($data, 'utf-8') > 5000 | mb_strlen($data, 'utf-8') < 2){
			$this->errors['description'] = 'Описание: от 2 до 5000 символов';
		}else{
			$this->product->description = $data;
		}
	}
	
	public function titleValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['title'] = 'Тайтл: поле пустое';
		}elseif(mb_strlen($data, 'utf-8') > 150){
			$this->errors['title'] = 'Тайтл: от 2 до 150 символов';
		}else{
			$this->product->title = $data;
		}
	}
	
	public function priceValid($data){
		if(empty($data)){
			$this->errors['price'] = 'Цена: пустое';
		}elseif(floatval($data) > 999999){
			$this->errors['price'] = 'Цена: максимум 999999 руб.';
		}elseif(preg_match('/^[0-9]{1,6}(\.[0-9]{2})?$/', $data) !== 1){
			$this->errors['price'] = 'Цена: неверный формат';
		}else{
			$this->product->price = floatval($data);
		}
	}
	
	public function imageValid($data){
		if(empty($data['tmp_name'])){
			$this->errors['image'] = 'Картинка: вы не загрузили картинку';
		}elseif($this->getExt($data['name']) !== 'jpg'){
			$this->errors['image'] = 'Картинка: только jpg';
		}elseif(!getimagesize($data['tmp_name'])){
			$this->errors['image'] = 'Картинка: только jpg';
		}elseif(move_uploaded_file($data['tmp_name'], $this->getFilePath($data['name']))){
			$this->product->image = $this->getFilePath($data['name']);
		}else{
			$this->errors['image'] = 'Ошибка при загрузке картинки';
		}
	}

	private function getExt($filename){
		$file_name_arr = explode('.', $filename);
		$ext = strtolower(array_pop($file_name_arr));
		return $ext;
	}

	private function getFilePath($filename){
		$upload_dir = 'image/'; //Куда будет перемещена катинка после загрузки
		$file_name = 'img_'.time().'.'.$this->getExt($filename); //Формирование имени файла
		$file_path = $upload_dir.$file_name; //Путь к файлу
		return $file_path;
	}
}