<?php
class WikiaHubsV3SuggestController extends WikiaController {
	/** @var WikiaHubsV3SuggestModel */
	protected $model;

	public function __construct() {
		$this->model = new WikiaHubsV3SuggestModel();
	}

	public function suggestArticle() {
		$this->successMessage = wfMessage('wikiahubs-suggest-article-success')->text();
		$this->formData = $this->model->getSuggestArticleForm();
	}

}
