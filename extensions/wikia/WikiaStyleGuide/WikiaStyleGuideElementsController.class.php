<?
class WikiaStyleGuideElementsController extends WikiaController {

	public function contentHeaderSort() {
		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);

		$this->label = $this->getVal('label');
		$this->sortMsg = $this->getVal('sortMsg');
		$this->sortOptions = $this->getVal('sortOptions');
		$this->containerId = $this->getVal('containerId');
	}

}