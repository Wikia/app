<?php

class CategoryPage3 extends CategoryPage {
	/**
	 * @var String - query param used for pagination
	 */
	private $from;

	/**
	 * @var CategoryPage3Model
	 */
	private $model;

	/**
	 * @throws Exception
	 */
	function closeShowCategory() {
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
		$data = $this->model->getDataForTemplate();
		$mustache = MustacheService::getInstance();

		return $mustache->render( 'templates/CategoryPage3.mustache', $data );
	}

	private function getPaginationUrls() {
		//TODO
	}
}
