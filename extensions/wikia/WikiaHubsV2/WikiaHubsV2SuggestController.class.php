<?php
class WikiaHubsV2SuggestController extends WikiaController {
	/** @var WikiaHubsV2SuggestModel */
	protected $model;

	public function __construct() {
		$this->model = F::build('WikiaHubsV2SuggestModel');
	}

	public function suggestVideo() {
		$this->formData = $this->model->getSuggestVideoForm();
	}

	public function suggestArticle() {
		$this->formData = $this->model->getSuggestArticleForm();
	}

}
