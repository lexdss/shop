<?php
class Validate{
	
	public static function strValid($data){
		$data = (trim((string)$data));
		return $data;
	}
	
	public static function intValid($data){
		$data = abs((int)$data);
		return $data;
	}
}