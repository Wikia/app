<?php
 
class DPLVariables {
    static $memoryVar   = array();
    static $memoryArray = array();

	// expects pairs of 'variable name' and 'value'
	// if the first parameter is empty it will be ignored {{#vardefine:|a|b}} is the same as {{#vardefine:a|b}}
    static function setVar($arg) {
        $numargs  = count($arg);
		if ($numargs>=3 && $arg[2]=='')	$start=3;
		else									$start=2;
        for ($i = $start; $i < $numargs; $i++) {
          $var = $arg[$i];
		  if (++$i <= $numargs-1)	self::$memoryVar[$var] = $arg[$i];
		  else 						self::$memoryVar[$var] = '';
        }
        return '';
    }
 
    static function setVarDefault($arg) {
        $numargs  = count($arg);
        if ($numargs >3) $value = $arg[3];
		else return '';
        $var = $arg[2];
	    if (!array_key_exists($var,self::$memoryVar) || self::$memoryVar[$var]=='') {
			self::$memoryVar[$var] = $value;
		}
		return '';
    }

    static function getVar($var) {
	    if (array_key_exists($var,self::$memoryVar)) return self::$memoryVar[$var];
	    return '';
    }

    static function setArray($arg) {
        $numargs  = count($arg);
		if ($numargs<5) return '';
		$var = trim($arg[2]);
		$value = $arg[3];
		$delimiter = $arg[4];
		if ($var=='') return '';
		if ($value=='') {
			self::$memoryArray[$var] = array();
			return;
		}
		if ($delimiter=='') {
			self::$memoryArray[$var] = array($value);
			return;
		}
	    if (0!==strpos($delimiter,'/') || (strlen($delimiter)-1)!==strrpos($delimiter,'/')) {
			$delimiter='/\s*'.$delimiter.'\s*/';
		}
		self::$memoryArray[$var] = preg_split($delimiter, $value);
        return "value=$value, delimiter=$delimiter," . count(self::$memoryArray[$var]);
    }

    static function dumpArray($arg) {
        $numargs  = count($arg);
		if ($numargs<3) return '';
		$var = trim($arg[2]);
		$text=" array $var = {";
		$n=0;
		if (array_key_exists($var,self::$memoryArray)) {
			foreach (self::$memoryArray[$var] as $value) {
				if ($n++>0) $text.=', ';
				$text.= "$value";
			}
		}
		return $text."}\n";
    }

    static function printArray($var, $delimiter, $search, $subject) {
		$var = trim($var);
		if ($var=='') return '';
		if (!array_key_exists($var,self::$memoryArray)) return '';
		$values=self::$memoryArray[$var];    
		$rendered_values= array();
		foreach($values as $v){
			$temp_result_value  = str_replace($search, $v, $subject);
			$rendered_values[] = $temp_result_value ;
		}
		return array(implode( $delimiter, $rendered_values) , 'noparse' => false, 'isHTML' => false);
    }

}
