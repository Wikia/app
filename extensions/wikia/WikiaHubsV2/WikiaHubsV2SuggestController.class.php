<?php
class WikiaHubsV2SuggestController extends WikiaController {
	/** @var WikiaHubsV2SuggestModel */
	protected $model;

	public function __construct() {
		$this->model = new WikiaHubsV2SuggestModel();
	}

	public function suggestArticle() {
		$this->successMessage = wfMessage('wikiahubs-suggest-article-success')->text();
		$this->formData = $this->model->getSuggestArticleForm();
	}

}
