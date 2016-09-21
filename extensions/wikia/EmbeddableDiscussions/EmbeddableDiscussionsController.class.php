<?php

class EmbeddableDiscussionsController {
	const TAG_NAME = 'discussions';
	const ITEMS_DEFAULT = 5;
	const ITEMS_MIN = 3;
	const ITEMS_MAX = 6;
	const COLUMNS_DEFAULT = 1;
	const COLUMNS_MIN = 1;
	const COLUMNS_MAX = 2;

	public static function onParserFirstCallInit( Parser $parser ) {
		global $wgEnableDiscussions;

		if ( $wgEnableDiscussions ) {
			$parser->setHook( self::TAG_NAME, [ 'EmbeddableDiscussionsController', 'render' ] );
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
	 * @param errorMessage Return parameter with the proper error message to show. Disregard if return is false
	 * @return true if ok, false if error
	 */
	private static function checkArguments( array $args, $modelData, &$errorMessage ) {
		// mostrecent must be bool
		if ( isset( $args['mostrecent'] )
			&& $args['mostrecent'] !== 'true'
			&& $args['mostrecent'] !== 'false'
		) {
			$errorMessage = wfMessage( 'embeddable-discussions-parameter-error',
				'mostrecent',
				wfMessage( 'embeddable-discussions-parameter-error-boolean' )->plain()
			)->plain();

			return false;
		}

		// size must be integer in range
		if ( isset( $args['size'] ) ) {
			$size = $args['size'];

			if ( !ctype_digit( $size )
				|| intval( $size ) > self::ITEMS_MAX
				|| intval( $size ) < self::ITEMS_MIN
			) {
				$errorMessage = wfMessage( 'embeddable-discussions-parameter-error',
					'size',
					wfMessage( 'embeddable-discussions-parameter-error-range', self::ITEMS_MIN, self::ITEMS_MAX )->plain()
				)->plain();

				return false;
			}
		}

		// columns must be integer in range
		if ( isset( $args['columns'] ) ) {
			$columns = $args['columns'];

			if ( !ctype_digit( $columns )
				|| intval( $columns ) > self::COLUMNS_MAX
				|| intval( $columns ) < self::COLUMNS_MIN
			) {
				$errorMessage = wfMessage( 'embeddable-discussions-parameter-error',
					'columns',
					wfMessage( 'embeddable-discussions-parameter-error-range', self::COLUMNS_MIN , self::COLUMNS_MAX )->plain()
				)->plain();

				return false;
			}
		}

		// category must be a valid category
		if ( !empty( $modelData['invalidCategory'] ) ) {
			$errorMessage = wfMessage( 'embeddable-discussions-parameter-error', $args['category'],
				wfMessage( 'embeddable-discussions-parameter-error-category' )->plain()
			)->plain();

			return false;
		}

		return true;
	}

	public static function render( $input, array $args ) {
		global $wgCityId;

		$showLatest = !empty( $args['mostrecent'] ) && filter_var( $args['mostrecent'], FILTER_VALIDATE_BOOLEAN );
		$itemCount = empty( $args['size'] ) ? self::ITEMS_DEFAULT : intval( $args['size'] );
		$columns = empty( $args['columns'] ) ? self::COLUMNS_DEFAULT : intval( $args['columns'] );
		$category = empty( $args['category'] ) ? '' :  $args['category'];

		$modelData = ( new DiscussionsThreadModel( $wgCityId ) )->getData( $showLatest, $itemCount, $category );

		if ( !static::checkArguments( $args, $modelData, $errorMessage ) ) {
			return static::renderError( $errorMessage );
		}

		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			return static::renderMobile( $modelData, $showLatest, $itemCount );
		} else {
			return static::renderDesktop( $category, $columns, $showLatest, $modelData );
		}
	}

	/**
	 * @param $templateEngine
	 * @param $errorMessage
	 * @return mixed
	 */
	private static function renderError( $errorMessage ) {
		$templateEngine = ( new Wikia\Template\MustacheEngine )->setPrefix( __DIR__ . '/templates' );
		return $templateEngine->clearData()->setData( [
			'errorMessage' => $errorMessage
		] )->render( 'DiscussionError.mustache' );
	}

	/**
	 * @param $modelData
	 * @param $showLatest
	 * @param $itemCount
	 * @param $templateEngine
	 * @return mixed
	 */
	private static function renderMobile( $modelData, $showLatest, $itemCount ) {
		$templateEngine = ( new Wikia\Template\MustacheEngine )->setPrefix( __DIR__ . '/templates' );

		// In Mercury, discussions are rendered client side as an Ember component
		$modelData = [
			'mercuryComponentAttrs' => json_encode( [
				'category' => $modelData['categoryId'],
				'show' => $showLatest ? 'latest' : 'trending',
				'itemCount' => $itemCount
			] ),
			'loading' => wfMessage( 'embeddable-discussions-loading' )->plain()
		];

		// In mercury, discussions app is rendered client side in an Ember container
		return $templateEngine->clearData()->setData( $modelData )->render( 'DiscussionThreadMobile.mustache' );
	}

	/**
	 * @param $category
	 * @param $columns
	 * @param $showLatest
	 * @param $modelData
	 * @param $templateEngine
	 * @return mixed
	 */
	private static function renderDesktop( $category, $columns, $showLatest, $modelData ) {
		$templateEngine = ( new Wikia\Template\MustacheEngine )->setPrefix( __DIR__ . '/templates' );

		$modelData['requestData'] = json_encode( [
			'category' => $category,
			'columns' => $columns,
			'showLatest' => $showLatest,
			'upvoteRequestUrl' => $modelData['upvoteRequestUrl'],
		] );

		if ( $showLatest && $category ) {
			$heading = wfMessage( 'embeddable-discussions-show-latest-in-category', $category )->plain();
		} else if ( $showLatest ) {
			$heading = wfMessage( 'embeddable-discussions-show-latest' )->plain();
		} else if ( $category ) {
			$heading = wfMessage( 'embeddable-discussions-show-trending-in-category', $category )->plain();
		} else {
			$heading = wfMessage( 'embeddable-discussions-show-trending' )->plain();
		}

		$modelData['columnsWrapperClass'] = $columns === 2 ? 'embeddable-discussions-threads-columns' : '';
		$modelData['heading'] = $heading;
		$modelData['showAll'] = wfMessage( 'embeddable-discussions-show-all' )->plain();
		$modelData['loading'] = wfMessage( 'embeddable-discussions-loading' )->plain();

		return $templateEngine->clearData()->setData( $modelData )->render( 'DiscussionThreadDesktop.mustache' );
	}
}
