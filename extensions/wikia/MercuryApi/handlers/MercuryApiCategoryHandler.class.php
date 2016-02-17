<?php

class MercuryApiCategoryHandler {
	/**
	 * @var WikiaMobileCategoryService
	 */
	private $categoryService = null;
	private $title = null;
	private $categoryPage = null;

	public function __construct($title) {
		$this->categoryService = new WikiaMobileCategoryService();
		$this->title = $title;
		$this->categoryPage = CategoryPage::newFromTitle($title, RequestContext::getMain());
	}

	public function getCategoryContent() {
		return [
			'members' => $this->getMembers(),
			'exhibition' => $this->getExhibition(),
			'content' => $this->getContent()
		];
	}

	public function getMembers() {
		return F::app()->sendRequest(
			'WikiaMobileCategoryService',
			'alphabeticalList',
			['categoryPage' => $this->categoryPage]
		)->getData();
	}

	public function getExhibition() {
		return F::app()->sendRequest(
			'WikiaMobileCategoryService',
			'categoryExhibition',
			['categoryPage' => $this->categoryPage]
		)->getData();
	}

	public function getContent() {
		return null;
	}
}
