<?php

use Wikia\Template\PHPEngine;

class CategoryPage3 extends CategoryPage {
	/**
	 * @var String - query param used for pagination
	 */
	private $from;

	/**
	 * @var CategoryPage3Model
	 */
	private $model;

	public function openShowCategory() {
		// Use ResourceLoader for scripts because it uses single request to lazy load all scripts
		$this->getContext()->getOutput()->addModules( 'ext.wikia.CategoryPage3.scripts' );

		// Use AssetsManager for styles because it bundles all styles and blocks render so there is no FOUC
		\Wikia::addAssetsToOutput( 'category_page3_scss' );
	}

	/**
	 * @throws Exception
	 */
	public function closeShowCategory() {
		$context = $this->getContext();
		$request = $context->getRequest();
		$this->from = $request->getVal( 'from' );

		$this->model = new CategoryPage3Model( $context->getTitle(), $this->from );
		$this->model->loadData();

		$this->addPaginationToHead();
		$context->getOutput()->addHTML( $this->getHTML() );
	}

	private function addPaginationToHead() {
		$paginationUrls = $this->getPaginationUrls();
		$output = $this->getContext()->getOutput();

		// TODO use class instead of array
		if ( !empty ( $paginationUrls['prev'] ) ) {
			$output->addHeadItem(
				'rel_prev',
				"\t" . Html::element( 'link', [
					'rel' => 'prev',
					'href' => $paginationUrls['prev'],
				] ) . PHP_EOL
			);
		}

		if ( !empty ( $paginationUrls['next'] ) ) {
			$output->addHeadItem(
				'rel_next',
				"\t" . Html::element( 'link', [
					'rel' => 'next',
					'href' => $paginationUrls['next'],
				] ) . PHP_EOL
			);
		}
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	private function getHTML() {
		$mustache = new PhpEngine();

		$templateVars = [
			'members' => $this->model->getMembers()
		];

		return $mustache->clearData()
			->setData( $templateVars )
			->render( 'extensions/wikia/CategoryPage3/templates/CategoryPage3.php' );
	}

	private function getPaginationUrls() {
		//TODO
	}
}
