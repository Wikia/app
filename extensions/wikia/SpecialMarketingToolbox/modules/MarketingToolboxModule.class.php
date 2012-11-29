<?
abstract class MarketingToolboxModule {
	const CLASS_NAME_PREFIX = 'MarketingToolboxModule';

	abstract protected function getValidationRules();

	static public function getModuleByName($name) {
		$moduleClassName = self::CLASS_NAME_PREFIX . $name;
		return new $moduleClassName();
	}

	public function renderEditor($data) {
		return $this->getView(__METHOD__, $data);
	}

	public function save($data) {
		// TODO saving data
	}

	public function validate($data) {
		$rules = $this->getValidationRules();
		return true;
	}

	// TODO fix this
	protected function getView($viewName, $data) {
		return 'test edit';//$this->app->getView(get_class($this), $viewName, array('data'=> $data));
	}
}
?>