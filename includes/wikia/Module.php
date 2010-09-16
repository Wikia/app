<?php
abstract class Module {

	protected static $skinTemplateObj;

	public static function setSkinTemplateObj(&$skinTemplate) {
		self::$skinTemplateObj = $skinTemplate;
	}

	public static function getSkinTemplateObj() {
		return self::$skinTemplateObj;
	}

	public static function get($name, $action = 'Index', $params = null) {
		global $wgAutoloadClasses;

		$moduleClassName = $name.'Module';

		if( !class_exists( $moduleClassName ) ) {
			return null;
		}
		wfProfileIn(__METHOD__ . " (" . $name.'_'.$action .")");

		$moduleObject = new $moduleClassName();
		$moduleObject->templatePath = dirname($wgAutoloadClasses[$moduleClassName]).'/templates/'.$name.'_'.$action.'.php';

		// auto-initialize any module variables which match variables in skinTemplate->data or _GLOBALS
		$objvars = get_object_vars($moduleObject);
		$skindata = array();
		if (isset(self::$skinTemplateObj) && is_array(self::$skinTemplateObj->data)) {
			$skindata = self::$skinTemplateObj->data;
		}
		foreach ($objvars as $var => $unused) {
			if (array_key_exists($var, $GLOBALS)) {
				$moduleObject->$var = $GLOBALS[$var];
			}
			if (array_key_exists($var, $skindata)) {
				$moduleObject->$var = $skindata[$var];
			}
		}

		if(wfRunHooks($name.$action.'BeforeExecute', array(&$moduleObject, &$params))) {
			$actionName = 'execute'.$action;
			$moduleObject->$actionName($params);
		}
		wfRunHooks($name.$action.'AfterExecute', array(&$moduleObject, &$params));

		wfProfileOut(__METHOD__ . " (" . $name.'_'.$action .")");
		return $moduleObject;
	}

	public function getData($var = null) {
		if($var === null) {
			return get_object_vars($this);
		} else {
			$vars = get_object_vars($this);
			return isset($vars[$var]) ? $vars[$var] : null;
		}
	}

	public function getView() {
		return new View($this->templatePath, $this->getData());
	}

	public function render() {
		return $this->getView()->render();
	}

}
