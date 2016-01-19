<?php

class CategoryValidate extends Validate{

	private $category_mapper;
	private $errors = array();
	private $category;

	public function __construct($category_mapper){
		$this->category_mapper = $category_mapper;
		$this->category = new Category;
	}

	public function valid($post_category){
		$this->nameValid($post_category['name']);
		$this->codeValid($post_category['code']);
		$this->titleValid($post_category['title']);

		if(!empty($this->errors)){
			return $this->errors;
		}else{
			return $this->category;
		}
	}

	private function nameValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['name'] = 'Поле пустое';
		}elseif(mb_strlen($data, 'utf-8') > 20){
			$this->errors['name'] = 'Имя категории слишком длинное';
		}elseif(mb_strlen($data, 'utf-8') < 2){
			$this->errors['name'] = 'Имя категории слишком короткое';
		}else{
			$this->category->name = $data;
		}
	}

	private function codeValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['code'] = 'Поле пустое';
		}elseif($this->category_mapper->exist('code', $data)){
			$this->errors['code'] = 'Такая категория уже существует';
		}elseif(mb_strlen($data, 'utf-8') > 20){
			$this->errors['code'] = 'Символьный код слишком длинный';
		}elseif(mb_strlen($data, 'utf-8') < 2){
			$this->errors['code'] = 'Символьный код слишком короткий';
		}else{
			$this->category->code = $data;
		}
	}

	private function titleValid($data){
		$data = $this->strValid($data);
		if(empty($data)){
			$this->errors['title'] = 'Поле пустое';
		}elseif(mb_strlen($data, 'utf-8') > 150){
			$this->errors['title'] = 'Тайтл слишком длинный';
		}elseif(mb_strlen($data, 'utf-8') < 2){
			$this->errors['title'] = 'Тайтл слишком короткий';
		}else{
			$this->category->title = $data;
		}
	}
}