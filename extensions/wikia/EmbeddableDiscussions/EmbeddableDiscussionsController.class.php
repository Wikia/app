<?php

class EmbeddableDiscussionsController {
	const TAG_NAME = 'discussions';
	const ITEMS_DEFAULT = 5;
	const ITEMS_MIN = 3;
	const ITEMS_MAX = 6;
	const COLUMNS_DEFAULT = 1;
	const COLUMNS_MIN = 1;
	const COLUMNS_MAX = 2;

	private $templateEngine;

	function __construct() {
		$this->templateEngine = ( new Wikia\Template\MustacheEngine )->setPrefix( __DIR__ . '/templates' );
	}

	public static function onParserFirstCallInit( Parser $parser ) {
		global $wgEnableDiscussions;

		if ( $wgEnableDiscussions ) {
			$parser->setHook( self::TAG_NAME, [ new self(), 'render' ] );
		}

		return true;
	}

	public static function onBeforePageDisplay() {
		\Wikia::addAssetsToOutput( 'embeddable_discussions_js' );
		\Wikia::addAssetsToOutput( 'embeddable_discussions_scss' );

		JSMessages::enqueuePackage( 'EmbeddableDiscussions', JSMessages::EXTERNAL );

		return true;
	}

	/**
	 * Checks arguments for errors.
	 * @param array $args
	 * @param string errorMessage Return parameter with the proper error message to show. Disregard if return is false
	 * @return true if ok, false if error
	 */
	private function checkArguments( array $args, $modelData, &$errorMessage ) {
		// mostrecent must be bool
		if ( isset( $args['mostrecent'] ) &&
			$args['mostrecent'] !== 'true' &&
			$args['mostrecent'] !== 'false'
		) {
			$errorMessage = wfMessage( 'embeddable-discussions-parameter-error', 'mostrecent' )->plain() .
				wfMessage( 'embeddable-discussions-parameter-error-boolean' )->plain();

			return false;
		}

		// size must be integer in range
		if ( isset( $args['size'] ) ) {
			$size = $args['size'];

			// TODO: Refactor error messages to avoid direct concatenation, see JPN-657
			$errorMessage = wfMessage( 'embeddable-discussions-parameter-error', 'size' )->plain() .
				wfMessage( 'embeddable-discussions-parameter-error-range',
					self::ITEMS_MIN , self::ITEMS_MAX )->plain();

			if ( !ctype_digit( $size ) ||
				intval( $size ) > self::ITEMS_MAX ||
				intval( $size ) < self::ITEMS_MIN
			) {
				return false;
			}
		}

		// columns must be integer in range
		if ( isset( $args['columns'] ) ) {
			$columns = $args['columns'];

			// TODO: Refactor error messages to avoid direct concatenation, see JPN-657
			$errorMessage = wfMessage( 'embeddable-discussions-parameter-error', 'columns' )->plain() .
				wfMessage( 'embeddable-discussions-parameter-error-range', self::COLUMNS_MIN , self::COLUMNS_MAX )->plain();

			if ( !ctype_digit( $columns ) ||
				intval( $columns ) > self::COLUMNS_MAX ||
				intval( $columns ) < self::COLUMNS_MIN
			) {
				return false;
			}
		}

		// category must be a valid category
		if ( $modelData['invalidCategory'] ) {
			// TODO: Refactor error messages to avoid direct concatenation, see JPN-657
			$errorMessage = wfMessage( 'embeddable-discussions-parameter-error', $args['category'] )->plain() .
				wfMessage( 'embeddable-discussions-parameter-error-category' )->plain();

			return false;
		}

		return true;
	}

	private function renderMobile( $modelData, $showLatest, $itemCount ) {
		// In Mercury, discussions are rendered client side as an Ember component
		$modelData = [
			'mercuryComponentAttrs' => json_encode( [
				'category' => $modelData['categoryId'],
				'show' => $showLatest ? 'latest' : 'trending',
				'itemCount' => $itemCount,
			] ),
			'loading' => wfMessage( 'embeddable-discussions-loading' )->plain()
		];

		// In mercury, discussions app is rendered client side in an Ember container
		return $this->templateEngine->clearData()
			->setData( $modelData )
			->render( 'DiscussionThreadMobile.mustache' );
	}

	private function renderDesktop( $modelData, $showLatest, $category, $columns ) {
		$modelData['requestData'] = json_encode( [
			'category' => $category,
			'columns' => $columns,
			'showLatest' => $showLatest,
			'upvoteRequestUrl' => $modelData['upvoteRequestUrl'],
		] );

		if ( $showLatest && $category ) {
			$heading = wfMessage( 'embeddable-discussions-show-latest-in-category', $category )->plain();
		} elseif ( $showLatest ) {
			$heading = wfMessage( 'embeddable-discussions-show-latest' )->plain();
		} elseif ( $category ) {
			$heading = wfMessage( 'embeddable-discussions-show-trending-in-category', $category )->plain();
		} else {
			$heading = wfMessage( 'embeddable-discussions-show-trending' )->plain();
		}

		$modelData['columnsWrapperClass'] = $columns === 2 ? 'embeddable-discussions-threads-columns' : '';
		$modelData['heading'] = $heading;
		$modelData['showAll'] = wfMessage( 'embeddable-discussions-show-all' )->plain();
		$modelData['loading'] = wfMessage( 'embeddable-discussions-loading' )->plain();

		return $this->templateEngine->clearData()
			->setData( $modelData )
			->render( 'DiscussionThreadDesktop.mustache' );
	}

	public function render( $input, array $args ) {
		global $wgCityId;

		$showLatest = !empty( $args['mostrecent'] ) && filter_var( $args['mostrecent'], FILTER_VALIDATE_BOOLEAN );
		$itemCount = empty( $args['size'] ) ? self::ITEMS_DEFAULT : intval( $args['size'] );
		$columns = empty( $args['columns'] ) ? self::COLUMNS_DEFAULT : intval( $args['columns'] );
		$category = empty( $args['category'] ) ? '' :  $args['category'];

		$modelData = ( new DiscussionsThreadModel( $wgCityId ) )->getData( $showLatest, $itemCount, $category );

		if ( !$this->checkArguments( $args, $modelData, $errorMessage ) ) {
			return $this->templateEngine->clearData()
				->setData( [
					'errorMessage' => $errorMessage,
				] )
				->render( 'DiscussionError.mustache' );
		}

		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			return $this->renderMobile( $modelData, $showLatest, $itemCount );
		} else {
			return $this->renderDesktop( $modelData, $showLatest, $category, $columns );
		}
	}
}
