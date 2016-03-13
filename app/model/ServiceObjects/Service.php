<?php

class Service extends ArrayObject{

	public function get($service_name){
		if(isset($this[$service_name]) && is_callable($this[$service_name])){
			return call_user_func($this[$service_name]);
		}
	}
}