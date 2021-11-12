<?php
class Validate{
	
	// Error array
	private $errors	= array();
	
	// Source array
	private $source	= array();
	
	// Rules array
	private $rules	= array();
	
	// Result array
	private $result	= array();
	
	// Contrucst
	public function __construct($source){
		$this->source = $source;
	}
	
	// Add rules
	public function addRules($rules){
		$this->rules = array_merge($rules, $this->rules );
	}
	
	// Get error
	public function getError(){
		return $this->errors;
	}
	
	// Set error
	public function setError($element, $message){
		$strElement = str_replace('_', ' ', $element);
		if(array_key_exists($element, $this->errors)){
			$this->errors[$element] .= ' - ' . $message;
		}else{
			$this->errors[$element] = '<b>' . ucwords($strElement) . ':</b> ' . $message;
		}
	}
	
	// Get result
	public function getResult(){
		return $this->result;
	}
	
	// Add rule
	public function addRule($element, $type, $options = null, $required = true){
		$this->rules[$element] = array('type' => $type, 'options' => $options, 'required' => $required);
		return $this;
	}
	
	// Run
	public function run(){
		foreach($this->rules as $element => $value){
			if($value['required'] == true && trim($this->source[$element])==null){
				$this->setError($element, 'giá trị này không được rỗng!');
			}else{
				switch ($value['type']) {
					case 'int':
						$this->validateInt($element, $value['options']['min'], $value['options']['max']);
						break;
					case 'string':
						$this->validateString($element, $value['options']['min'], $value['options']['max']);
						break;
					case 'url':
						$this->validateUrl($element);
						break;
					case 'email':
						$this->validateEmail($element);
						break;
					case 'status':
						$this->validateStatus($element, $value['options']);
						break;
					case 'group':
						$this->validateGroupID($element);
						break;
					case 'password':
						$this->validatePassword($element, $value['options']);
						break;
					case 'captcha':
						$this->validateCaptcha($element);
						break;
					case 'date':
						$this->validateDate($element, $value['options']['start'], $value['options']['end']);
						break;
					case 'existRecord':
						$this->validateExistRecord($element, $value['options']);
						break;
					case 'notExistRecord':
						$this->validateNotExistRecord($element, $value['options']);
						break;
					case 'string-notExistRecord':
						$this->validateString($element, $value['options']['min'], $value['options']['max']);
						$this->validateNotExistRecord($element, $value['options']);
						break;
					case 'email-notExistRecord':
						$this->validateEmail($element);
						$this->validateNotExistRecord($element, $value['options']);
						break;
					case 'file':
						$this->validateFile($element, $value['options']);
						break;
				}
			}
			if(!array_key_exists($element, $this->errors)) {
				$this->result[$element] = $this->source[$element];
			}
		}
		$eleNotValidate = array_diff_key($this->source, $this->errors);
		$this->result	= array_merge($this->result, $eleNotValidate);
		
	}
	
	// Validate Integer
	private function validateInt($element, $min = 0, $max = 0){
		if(!filter_var($this->source[$element], FILTER_VALIDATE_INT, array("options"=>array("min_range"=>$min,"max_range"=>$max)))){
			$this->setError($element, 'không hợp lệ!');
		}
	}
	
	// Validate String
	private function validateString($element, $min = 0, $max = 0){
		$length = strlen($this->source[$element]);
		if($length < $min) {
			$this->setError($element, 'phải từ '.$min.' ký tự trở lên!');
		}elseif($length > $max){
			$this->setError($element, 'phải từ '.$max.' ký tự trở xuống!');
		}elseif(!is_string($this->source[$element])){
			$this->setError($element, 'không hợp lệ!');
		}
	}

	// Validate Captcha
	private function validateCaptcha($element){
		require_once ''.TEMPLATE_PATH.'default/main/securimage/securimage.php';
		$securimage = new Securimage();

		if ($securimage->check($this->source[$element]) == false) {
			$this->setError($element, 'Mã xác nhận sai!');
		}
	}
	
	// Validate URL
	private function validateURL($element){
		if(!filter_var($this->source[$element], FILTER_VALIDATE_URL)){
			$this->setError($element, 'url không hợp lệ!');
		}
	}
	
	// Validate Email
	private function validateEmail($element){
		if(!filter_var($this->source[$element], FILTER_VALIDATE_EMAIL)){
			$this->setError($element, 'email không hợp lệ!');
		}
	}
	
	public function showErrors(){
		$xhtml = '';
		if(!empty($this->errors)){
			$xhtml .= '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5><ul>';
			foreach($this->errors as $key => $value){
				$xhtml .= '<li>'.$value.' </li>';
			}
			$xhtml .=  '</ul></div>';
		}
		return $xhtml;
	}

	public function showErrorsPublic(){
		$xhtml = '';
		if(!empty($this->errors)){
			$xhtml .= '<div class="alert alert-danger alert-dismissible"><ul>';
			foreach($this->errors as $key => $value){
				$xhtml .= '<li>'.$value.' </li>';
			}
			$xhtml .=  '</ul></div>';
		}
		return $xhtml;
	}
	
	public function isValid(){
	 	if(count($this->errors)>0) return false;
	 	return true;	
	}
	
	// Validate Status
	private function validateStatus($element, $options){
		// Status 1: Publish Yes, 0: Unpublish No 2 Trash
		// Kiểm tra nếu phần tử trong mảng trùng với phần tử trong deny là ko hợp lệ
		if(in_array($this->source[$element], $options['deny']) == true){
			$this->setError($element, 'Vui lòng chọn giá trị khác giá trị mặc định!');
		}
	}
	
	// Validate GroupID
	private function validateGroupID($element){
		if($this->source[$element] == 0){
			$this->setError($element, 'Select group');
		}
	}
	
	// Validate Password
	private function validatePassword($element, $options){		
		if($options['action'] == 'add' || ($options['action'] == 'edit' && $this->source[$element] )){
			// $pattern = '#^(?=.*\d)(?=.*[A-Z])(?=.*\W).{8,8}$#';	// Php4567!
			$pattern = '#^(?=.*[a-zA-Z0-9]).{6,12}$#';
			if(!preg_match($pattern, $this->source[$element])){
				$this->setError($element, 'password phải từ 6 đến 12 ký tự!');
			};
		}
		
	}
	
	// Validate Date
	private function validateDate($element, $start, $end){		
		// Start
		$arrDateStart 	= date_parse_from_format('d/m/Y', $start) ;
		$tsStart		= mktime(0, 0, 0, $arrDateStart['month'], $arrDateStart['day'], $arrDateStart['year']);
			
		// End
		$arrDateEnd 	= date_parse_from_format('d/m/Y', $end) ;
		$tsEnd			= mktime(0, 0, 0, $arrDateEnd['month'], $arrDateEnd['day'], $arrDateEnd['year']);
		
		// Current
		$arrDateCurrent	= date_parse_from_format('d/m/Y', $this->source[$element]) ;
		$tsCurrent		= mktime(0, 0, 0, $arrDateCurrent['month'], $arrDateCurrent['day'], $arrDateCurrent['year']);
		
		if($tsCurrent < $tsStart || $tsCurrent > $tsEnd){
			$this->setError($element, 'ngày tháng không hợp lệ!');
		}
	}
	
	// Validate Exist record
	private function validateExistRecord($element, $options){
		$database = $options['database'];
		$query	  = $options['query'];
		if($database->isExist($query)==false){
			$this->setError($element, 'dữ liệu không tồn tại!');
		}
	}

	// Validate Not Exist record
	private function validateNotExistRecord($element, $options){
		$database = $options['database'];
		$query	  = $options['query'];
		if($database->isExist($query)==true){
			$this->setError($element, 'giá trị này đã tồn tại!');
		}
	}
	
	// Validate File
	private function validateFile($element, $options){
		if($this->source[$element]['name'] != null){
			if(!filter_var($this->source[$element]['size'], FILTER_VALIDATE_INT, array("options"=>array("min_range"=>$options['min'],"max_range"=>$options['max'])))){
				$this->setError($element, 'kích thước không phù hợp!');
			}
			
			$ext = pathinfo($this->source[$element]['name'], PATHINFO_EXTENSION);
			if(in_array($ext, $options['extension']) == false){
				$this->setError($element, 'phần mở rộng không phù hợp!');
			}
		}
	}
}










