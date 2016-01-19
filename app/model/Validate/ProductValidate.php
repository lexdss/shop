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
			$this->errors['category'] = 'Выберите категорию';
		}else{
			$this->product->category = $data;
		}
	}

	public function nameValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['name'] = 'Поле пустое';
		}elseif(mb_strlen($data, 'utf-8') > 50){
			$this->errors['name'] = 'Название слишком длинное';
		}elseif(mb_strlen($data, 'utf-8') < 2){
			$this->errors['name'] = 'Название слишком короткое';
		}else{
			$this->product->name = $data;
		}
	}
	
	public function descriptionValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['description'] = 'Поле пустое';
		}elseif(mb_strlen($data, 'utf-8') > 10000){
			$this->errors['description'] = 'Описание слишком длинное';
		}elseif(mb_strlen($data, 'utf-8') < 2){
			$this->errors['description'] = 'Описание слишком короткое';
		}else{
			$this->product->description = $data;
		}
	}
	
	public function titleValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['title'] = 'Поле пустое';
		}elseif(mb_strlen($data, 'utf-8') > 200){
			$this->errors['title'] = 'Тайтл слишком длинный';
		}elseif(mb_strlen($data, 'utf-8') < 2){
			$this->errors['title'] = 'Тайтл слишком короткий';
		}else{
			$this->product->title = $data;
		}
	}
	
	public function priceValid($data){
		$data = (float)$data;
		if(empty($data)){
			$this->errors['price'] = 'Поле пустое';
		}elseif($data > 999999){
			$this->errors['price'] = 'Цена слишком большая';
		}else{
			$this->product->price = $data;
		}
	}
	
	public function imageValid($data){
		if(empty($data['tmp_name'])){
			$this->errors['image'] = 'Загрузите картинку';
		}elseif($this->getExt($data['name']) !== 'jpg'){
			$this->errors['image'] = 'Загружать можно только jpg и  png изображения';
		}elseif(!getimagesize($data['tmp_name'])){
			$this->errors['image'] = 'Загружать можно только jpg и  png изображения';
		}elseif(move_uploaded_file($data['tmp_name'], $this->getFilePath($data['name']))){
			$this->product->image = $this->getFilePath($data['name']);
		}else{
			$this->errors['image'] = 'Ошибка при загрузке файла';
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