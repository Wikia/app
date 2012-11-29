<?
abstract class MarketingToolboxModuleService extends WikiaService {
	const CLASS_NAME_PREFIX = 'MarketingToolboxModule';

	abstract protected function getValidationRules();

	static public function getModuleByName($name) {
		$moduleClassName = self::CLASS_NAME_PREFIX . $name . 'Service';
		return new $moduleClassName();
	}

	public function renderEditor($data) {
		return $this->getView('editor', $data);
	}

	public function save($data) {
		// TODO saving data
	}

	public function validate($data) {
		$rules = $this->getValidationRules();
		return true;
	}

	protected function getView($viewName, $data, $viewType = WikiaResponse::FORMAT_HTML) {
		return $this->app->getView(get_class($this), $viewName, array('data'=> $data));
	}

}
?>