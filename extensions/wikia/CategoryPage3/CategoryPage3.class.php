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
		$this->model->loadImages( 40, 30 );

		$this->addPaginationToHead();
		$context->getOutput()->addHTML( $this->getHTML() );
	}

	private function addPaginationToHead() {
		$pagination = $this->model->getPagination();
		$output = $this->getContext()->getOutput();

		if ( !empty ( $pagination->getPrevPageUrl() ) ) {
			$output->addHeadItem(
				'rel_prev',
				"\t" . Html::element( 'link', [
					'rel' => 'prev',
					'href' => $pagination->getPrevPageUrl(),
				] ) . PHP_EOL
			);
		}

		if ( !empty ( $pagination->getNextPageUrl() ) ) {
			$output->addHeadItem(
				'rel_next',
				"\t" . Html::element( 'link', [
					'rel' => 'next',
					'href' => $pagination->getNextPageUrl(),
				] ) . PHP_EOL
			);
		}
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	private function getHTML() {
		$membersGroupedByChar = $this->model->getMembersGroupedByChar();

		$this->setBreakColumnAfterMiddleMember( $membersGroupedByChar );

		$templateVars = [
			'membersGroupedByChar' => $membersGroupedByChar,
			'pagination' => $this->model->getPagination(),
			'totalNumberOfMembers' => $this->model->getTotalNumberOfMembers()
		];

		return ( new PhpEngine() )->clearData()
			->setData( $templateVars )
			->render( 'extensions/wikia/CategoryPage3/templates/CategoryPage3.php' );
	}

	/**
	 * This is messy and wouldn't be needed if this worked:
	 * .category-page__first-char { break-after: avoid; }
	 * but it doesn't, so we need to calculate the break manually
	 *
	 * @param $membersGroupedByChar
	 */
	private function setBreakColumnAfterMiddleMember( $membersGroupedByChar ) {
		$numberOfHeaders = count( $membersGroupedByChar );
		$numberOfMembers = count( $this->model->getMembers() );
		$breakColumnAfter = floor( ( $numberOfHeaders + $numberOfMembers ) / 2 );

		$count = 1;
		foreach ( $membersGroupedByChar as $members ) {
			/** @var CategoryPage3Member $member */
			foreach ( $members as $member ) {
				if ( $count >= $breakColumnAfter ) {
					$member->setBreakColumnAfter( true );
					return;
				}

				$count++;
			}

			// Headers take space too
			$count++;
		}
	}
}
