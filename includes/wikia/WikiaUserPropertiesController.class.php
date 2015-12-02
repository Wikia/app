<?php
class WikiaUserPropertiesController extends WikiaController {
	protected static $handlers = array();

	public static function registerHandler($handlerName) {
		self::$handlers[$handlerName] = true;
	}

	public static function unregisterHandler($handlerName) {
		unset(self::$handlers[$handlerName]);
	}

	public function performPropertyOperation() {
		$handlerName = $this->request->getVal('handlerName', null);
		$methodName = $this->request->getVal('methodName', null);
		$methodParams = $this->request->getVal('callParams',array());

		$this->results = new stdClass();
		$this->results->success = false;

		if (empty(self::$handlers[$handlerName])) {
			$this->results->error = wfMsg('user-properties-handler-not-registered');
		} elseif (class_exists($handlerName)) {
			$handler = new $handlerName;
			if (method_exists($handler, $methodName)) {
				$this->results = $handler->$methodName($methodParams);
			} else {
				$this->results->error = wfMsg('user-properties-method-nonexistent');
			}
		} else {
			$this->results->error = wfMsg('user-properties-handler-nonexistent');
		}
	}

	protected function throwExceptionForAnons() {
		if (!$this->wg->User->isLoggedIn()) {
			throw new Exception('User not logged-in');
		}
	}
}
