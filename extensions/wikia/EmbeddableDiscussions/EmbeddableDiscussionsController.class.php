<?php

class EmbeddableDiscussionsController {
	const TAG_NAME = 'discussions';
	const ITEMS_DEFAULT = 5;
	const ITEMS_MIN = 3;
	const ITEMS_MAX = 8;
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

	public static function render( $input, array $args ) {
		global $wgCityId;

		$showLatest = !empty( $args['mostrecent'] ) && filter_var( $args['mostrecent'], FILTER_VALIDATE_BOOLEAN );
		$itemCount = empty( $args['size'] ) ? self::ITEMS_DEFAULT : intval( $args['size'] );
		$columns = empty( $args['columns'] ) ? self::COLUMNS_DEFAULT : intval( $args['columns'] );
		$category = empty( $args['category'] ) ? '' :  $args['category'];

		if ( $itemCount > self::ITEMS_MAX ) {
			$itemCount = self::ITEMS_MAX;
		}

		if ( $itemCount < self::ITEMS_MIN ) {
			$itemCount = self::ITEMS_MIN;
		}

		if ( $columns < self::COLUMNS_MIN ) {
			$columns = self::COLUMNS_MIN;
		}

		if ( $columns > self::COLUMNS_MAX ) {
			$columns = self::COLUMNS_MAX;
		}

		$templateEngine = ( new Wikia\Template\MustacheEngine )->setPrefix( __DIR__ . '/templates' );

		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			// In Mercury, discussions are rendered client side as an Ember component
			$modelData = [
				'mercuryComponentAttrs' => json_encode( [
					'category' => ( new DiscussionsThreadModel( $wgCityId ) )->getCategoryId( $category ),
					'show' => $showLatest ? 'latest' : 'trending',
					'itemCount' => $itemCount,
				] ),
				'loading' => wfMessage( 'embeddable-discussions-loading' )->plain()
			];

			// In mercury, discussions app is rendered client side in an Ember container
			return $templateEngine->clearData()
				->setData( $modelData )
				->render( 'DiscussionThreadMobile.mustache' );
		} else {
			$modelData = ( new DiscussionsThreadModel( $wgCityId ) )->getData( $showLatest, $itemCount, $category );

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

			return $templateEngine->clearData()
				->setData( $modelData )
				->render( 'DiscussionThreadDesktop.mustache' );
		}
	}
}
