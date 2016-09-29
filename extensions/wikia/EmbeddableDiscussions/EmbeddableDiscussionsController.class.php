<?php

class EmbeddableDiscussionsController {
	const TAG_NAME = 'discussions';
	const ITEMS_DEFAULT = 5;
	const ITEMS_MIN = 3;
	const ITEMS_MAX = 6;
	const COLUMNS_DEFAULT = 1;
	const COLUMNS_MIN = 1;
	const COLUMNS_MAX = 2;

	const PARAM_MOSTRECENT = 'mostrecent';
	const PARAM_SIZE = 'size';
	const PARAM_COLUMNS = 'columns';
	const PARAM_CATEGORY = 'category';

	private $templateEngine;

	function __construct() {
		$this->templateEngine = ( new Wikia\Template\MustacheEngine )->setPrefix( __DIR__ . '/templates' );
	}

	public static function onParserFirstCallInit( Parser $parser ) {
		global $wgEnableDiscussions;

		if ( $wgEnableDiscussions ) {
			$parser->setHook( self::TAG_NAME, [
				'EmbeddableDiscussionsController',
				'render'
			] );
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
	 * @param $modelData
	 * @param array $args
	 * @internal param $errorMessage /Return parameter with the proper error message to show.
	 * Disregard if return is false.
	 * @return true if ok, false if error
	 */
	private function checkArguments( $modelData, array $args, &$errorMessage ) {
		// PARAM_MOSTRECENT must be bool
		if ( isset( $args[ static::PARAM_MOSTRECENT ] ) &&
			$args[ static::PARAM_MOSTRECENT ] !== 'true' &&
			$args[ static::PARAM_MOSTRECENT ] !== 'false'
		) {
			$errorMessage = wfMessage( 'embeddable-discussions-parameter-error',
				static::PARAM_MOSTRECENT,
				wfMessage( 'embeddable-discussions-parameter-error-boolean' )->plain()
			)->plain();

			return false;
		}

		// size must be integer in range
		if ( isset( $args[ static::PARAM_SIZE ] ) ) {
			$sizeArg = $args[ static::PARAM_SIZE ];
			$size = ctype_digit( $sizeArg ) ? intval( $sizeArg ) : $sizeArg;

			if ( !is_int ( $size ) ||
				$size > self::ITEMS_MAX ||
				$size < self::ITEMS_MIN
			) {
				$errorMessage = wfMessage( 'embeddable-discussions-parameter-error',
					static::PARAM_SIZE,
					wfMessage( 'embeddable-discussions-parameter-error-range', self::ITEMS_MIN, self::ITEMS_MAX )->plain()
				)->plain();

				return false;
			}
		}

		// columns must be integer in range
		if ( isset( $args[ static::PARAM_COLUMNS ] ) ) {
			$columnsArg = $args[ static::PARAM_COLUMNS ];
			$columns = ctype_digit( $columnsArg ) ? intval( $columnsArg ) : $columnsArg;

			if ( !is_int( $columns ) ||
				$columns > self::COLUMNS_MAX ||
				$columns < self::COLUMNS_MIN
			) {
				$errorMessage = wfMessage( 'embeddable-discussions-parameter-error',
					static::PARAM_COLUMNS,
					wfMessage( 'embeddable-discussions-parameter-error-range', self::COLUMNS_MIN, self::COLUMNS_MAX )->plain()
				)->plain();

				return false;
			}
		}

		// category must be a valid category
		if ( !empty( $modelData[ 'invalidCategory' ] ) ) {
			$errorMessage = wfMessage( 'embeddable-discussions-parameter-error',
				$args[ static::PARAM_CATEGORY ],
				wfMessage( 'embeddable-discussions-parameter-error-category' )->plain()
			)->plain();

			return false;
		}

		return true;
	}

	/**
	 * @param array $args
	 * @return string
	 */
	public function render( array $args ) {
		global $wgCityId;

		$showLatest = !empty( $args[ static::PARAM_MOSTRECENT ] ) && filter_var( $args[ static::PARAM_MOSTRECENT ], FILTER_VALIDATE_BOOLEAN );
		$itemCount = !empty( $args[ static::PARAM_SIZE ] ) ? intval( $args[ static::PARAM_SIZE ] ) : self::ITEMS_DEFAULT;
		$columns = !empty( $args[ static::PARAM_COLUMNS ] ) ? intval( $args[ static::PARAM_COLUMNS ] ) : self::COLUMNS_DEFAULT;
		$category = !empty( $args[ static::PARAM_CATEGORY ] ) ? $args[ static::PARAM_CATEGORY ] : '';

		$modelData = ( new DiscussionsThreadModel( $wgCityId ) )->getData( $showLatest, $itemCount, $category );

		if ( !$this->checkArguments( $modelData, $args, $errorMessage ) ) {
			return $this->renderError( $errorMessage );
		}

		return F::app()->checkSkin( 'wikiamobile' ) ?
			$this->renderMobile( $modelData, $showLatest, $itemCount ) :
			$this->renderDesktop( $modelData, $showLatest, $category, $columns );
	}

	/**
	 * @param $errorMessage
	 * @return string
	 */
	private function renderError( $errorMessage ) {
		return $this->templateEngine->clearData()->setData( [
			'errorMessage' => $errorMessage
		] )->render( 'DiscussionError.mustache' );
	}

	/**
	 * @param $modelData
	 * @param $showLatest
	 * @param $itemCount
	 * @return string
	 */
	private function renderMobile( $modelData, $showLatest, $itemCount ) {
		// In Mercury, discussions are rendered client side as an Ember component
		$modelData = [
			'mercuryComponentAttrs' => json_encode( [
				'category' => $modelData[ 'categoryId' ],
				'show' => $showLatest ? 'latest' : 'trending',
				'itemCount' => $itemCount
			] ),
			'loading' => wfMessage( 'embeddable-discussions-loading' )->plain()
		];

		// In mercury, discussions app is rendered client side in an Ember container
		return $this->templateEngine
			->clearData()
			->setData( $modelData )
			->render( 'DiscussionThreadMobile.mustache' );
	}

	/**
	 * @param $modelData
	 * @param $showLatest
	 * @param $category
	 * @param $columns
	 * @return string
	 */
	private function renderDesktop( $modelData, $showLatest, $category, $columns ) {
		$modelData[ 'requestData' ] = json_encode( [
			'category' => $category,
			'columns' => $columns,
			'showLatest' => $showLatest,
			'upvoteRequestUrl' => $modelData[ 'upvoteRequestUrl' ],
		] );

		if ( $showLatest && $category ) {
			$heading = 'embeddable-discussions-show-latest-in-category';
		} elseif ( $showLatest ) {
			$heading = 'embeddable-discussions-show-latest';
		} elseif ( $category ) {
			$heading = 'embeddable-discussions-show-trending-in-category';
		} else {
			$heading = 'embeddable-discussions-show-trending';
		}

		$modelData[ 'columnsWrapperClass' ] =
			$columns === static::COLUMNS_MAX ?
				'embeddable-discussions-threads-columns' :
				'';
		$modelData[ 'heading' ] = wfMessage( $heading, $category )->plain();
		$modelData[ 'showAll' ] = wfMessage( 'embeddable-discussions-show-all' )->plain();
		$modelData[ 'loading' ] = wfMessage( 'embeddable-discussions-loading' )->plain();

		return $this->templateEngine
			->clearData()
			->setData( $modelData )
			->render( 'DiscussionThreadDesktop.mustache' );
	}
}
