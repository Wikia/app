<?php

use Wikia\Template\Engine;
use Wikia\Template\PHPEngine;

class CategoryPage3 extends CategoryPageWithLayoutSelector {
	/**
	 * @var String - query param used for pagination
	 */
	private $from;

	/**
	 * @var CategoryPage3Model
	 */
	private $model;

	/**
	 * @var array
	 */
	private $trendingPages;

	const MEMBER_THUMB_WIDTH = 40;
	const MEMBER_THUMB_HEIGHT = 30;

	public function openShowCategory() {
		parent::openShowCategory();

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

		if ( $this->model->getTotalNumberOfMembers() === 0 ) {
			return;
		}

		$this->model->loadImages( self::MEMBER_THUMB_WIDTH, self::MEMBER_THUMB_HEIGHT );

		if ( empty( $this->from ) ) {
			$this->trendingPages = CategoryPage3TrendingPages::getTrendingPages( $context->getTitle() );
		}

		$this->addPaginationToHead();
		$context->getOutput()->addHTML( $this->getHTML() );
	}

	protected function getCurrentLayout() {
		return CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3;
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
	private function getHTML(): string {
		$html = '';
		$engine = new PhpEngine();
		$engine->setPrefix( 'extensions/wikia/CategoryPage3/templates/' );

		$html .= $this->getHTMLForTrendingPages( $engine );
		$html .= $this->getHTMLForMembersHeader( $engine );
		$html .= $this->getHTMLForMembers( $engine );
		$html .= $this->getHTMLForPagination( $engine );

		return $html;
	}

	private function getHTMLForTrendingPages( Engine $engine ): string {
		if ( empty( $this->trendingPages ) ) {
			return '';
		}

		return $engine->clearData()
			->setData( [
				'trendingPages' => $this->trendingPages
			] )
			->render( 'trending-pages.php' );
	}

	private function getHTMLForMembersHeader( Engine $engine ): string {
		return $engine->clearData()
			->setData( [
				'alphabetShortcuts' => $this->getAlphabetShortcuts(),
				'title' => $this->getTitle(),
				'totalNumberOfMembers' => $this->model->getTotalNumberOfMembers()
			] )
			->render( 'members-header.php' );
	}

	private function getHTMLForMembers( Engine $engine ): string {
		return $engine->clearData()
			->setData( [
				'hasSingleMember' => count( $this->model->getMembers() ) === 1,
				'membersGroupedByChar' => $this->model->getMembersGroupedByChar()
			] )
			->render( 'members.php' );
	}

	private function getHTMLForPagination( Engine $engine ): string {
		return $engine->clearData()
			->setData( [
				'pagination' => $this->model->getPagination()
			] )
			->render( 'pagination.php' );
	}

	public static function getSrcset( string $url ): string {
		// Based on how much space there is on different breakpoints
		$widths = [ 160, 200 ];
		$srcSetItems = [];

		foreach ( $widths as $width ) {
			$thumb = self::getThumbnailUrlForWidth( $url, $width );
			$srcSetItems[] = "${thumb} ${width}w";
		}

		return implode( ',', $srcSetItems );
	}

	private static function getThumbnailUrlForWidth( string $url, int $width ): string {
		// Keep 4:3 ratio
		$height = floor( $width / 4 * 3 );

		try {
			$url = VignetteRequest::fromUrl( $url )
				->topCrop()
				->width( $width )
				->height( $height )
				->url();
		} catch ( Exception $e ) {
			$url = '';
		}

		return $url;
	}

	private function getAlphabetShortcuts(): array {
		$alphabetShortcuts = [];
		$alphabetShortcuts[] = [
			'from' => null,
			// Doesn't make sense to always highlight it on the first page
			'isActive' => false,
			'label' => '#'
		];

		foreach ( range( 'A', 'Z' ) as $latinChar ) {
			$alphabetShortcuts[] = [
				'from' => $latinChar,
				'isActive' => $latinChar === $this->from,
				'label' => $latinChar
			];
		}

		$alphabetShortcuts[] = [
			'from' => '¡',
			'isActive' => '¡' === $this->from,
			'label' => wfMessage( 'category-page3-shortcut-to-other' )
		];

		return $alphabetShortcuts;
	}
}
