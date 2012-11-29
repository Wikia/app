<?
abstract class MarketingToolboxModule extends WikiaService {
	const CLASS_NAME_PREFIX = 'MarketingToolboxModule';

	abstract protected function getValidationRules();

	static public function getModuleByName($name) {
		$moduleClassName = self::CLASS_NAME_PREFIX . $name;
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
		$request = new WikiaResponse($viewType);
		$request->setData(array('data' => $data));
		$request->getView()->setTemplatePath($this->getTemplatePath($viewName));

		return $request->getView();
	}

	protected function getTemplatePath($viewName) {
		return __DIR__. DIRECTORY_SEPARATOR .
			'..' . DIRECTORY_SEPARATOR .
			'templates' . DIRECTORY_SEPARATOR .
			'modules' . DIRECTORY_SEPARATOR .
			get_class($this) . '_' . $viewName . '.php';
	}
}
?>