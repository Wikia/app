<?php

class JavascriptTestFramework {

	public $javascriptFiles = array();
	public $styleFiles = array();
	public $forbiddenOutputs = array();

	public $html = '';

	static public function newFromName( $name ) {
		$className = __CLASS__ . '_' . $name;
		if (class_exists($className)) {
			return new $className;
		}
		return null;
	}

}
