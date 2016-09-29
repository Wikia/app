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

	public function __construct() {
		$this->templateEngine = ( new Wikia\Template\MustacheEngine )->setPrefix( __DIR__ . '/templates' );
	}

	public function render( array $args ) {
		global $wgCityId;

		$parameters = [
			static::PARAM_MOSTRECENT => $args[ static::PARAM_MOSTRECENT ] ?? false,
			static::PARAM_SIZE => $args[ static::PARAM_SIZE ] ?? self::ITEMS_DEFAULT,
			static::PARAM_COLUMNS => $args[ static::PARAM_COLUMNS ] ?? self::COLUMNS_DEFAULT,
			static::PARAM_CATEGORY => $args[ static::PARAM_CATEGORY ] ?? '',
		];

		$errorMessage = $this->validateArguments( $parameters );

		$modelData = ( new DiscussionsThreadModel( $wgCityId ) )
			->getData( $parameters[ static::PARAM_MOSTRECENT ], $parameters[ static::PARAM_SIZE ], $parameters[ static::PARAM_CATEGORY ] );

		$errorMessage = $this->validateCategory( $args, $modelData ) ?? $errorMessage;

		if ( isset( $errorMessage ) ) {
			return $this->templateEngine
				->clearData()
				->setData( [ 'errorMessage' => $errorMessage ] )
				->render( 'DiscussionError.mustache' );
		}

		return F::app()->checkSkin( 'wikiamobile' ) ?
			$this->renderMobile( $modelData, $parameters[ static::PARAM_MOSTRECENT ], $parameters[ static::PARAM_SIZE ] ) :
			$this->renderDesktop( $modelData, $parameters[ static::PARAM_MOSTRECENT ], $parameters[ static::PARAM_CATEGORY ], $parameters[ static::PARAM_COLUMNS ] );
	}

	/**
	 * @param array $parameters
	 * @return String error message or empty string if category is valid
	 */
	private function validateArguments( array $parameters ) {
		$errorMessage = '';

		// PARAM_MOSTRECENT must be bool
		if ( !AttributesValidator::isBoolish( $parameters[ static::PARAM_MOSTRECENT ] ) ) {
			$errorMessage = wfMessage( 'embeddable-discussions-parameter-error',
				static::PARAM_MOSTRECENT,
				wfMessage( 'embeddable-discussions-parameter-error-boolean' )->plain()
			)->plain();
		}

		// size must be integer in range
		if ( !AttributesValidator::isInRange( $parameters[ static::PARAM_SIZE ], self::ITEMS_MIN, self::ITEMS_MAX ) ) {
			$errorMessage = wfMessage( 'embeddable-discussions-parameter-error',
				static::PARAM_SIZE,
				wfMessage( 'embeddable-discussions-parameter-error-range', self::ITEMS_MIN, self::ITEMS_MAX )->plain()
			)->plain();
		}

		// columns must be integer in range
		if ( !AttributesValidator::isInRange( $parameters[ static::PARAM_COLUMNS ], self::COLUMNS_MIN, self::COLUMNS_MAX ) ) {
			$errorMessage = wfMessage( 'embeddable-discussions-parameter-error',
				static::PARAM_COLUMNS,
				wfMessage( 'embeddable-discussions-parameter-error-range', self::COLUMNS_MIN, self::COLUMNS_MAX )->plain()
			)->plain();
		}

		return $errorMessage;
	}

	/**
	 * @param $modelData
	 * @param array $args
	 * @return String error message or empty string if category is valid
	 */
	private function validateCategory( $modelData, array $args ) {
		// category must be a valid category
		if ( !empty( $modelData[ 'invalidCategory' ] ) ) {
			return wfMessage( 'embeddable-discussions-parameter-error',
				$args[ static::PARAM_CATEGORY ],
				wfMessage( 'embeddable-discussions-parameter-error-category' )->plain()
			)->plain();
		}

		return '';
	}

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
