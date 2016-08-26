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
			$parser->setHook( static::TAG_NAME, [ 'EmbeddableDiscussionsController', 'render' ] );
		}

		return true;
	}

	public static function onBeforePageDisplay() {
		\Wikia::addAssetsToOutput( 'embeddable_discussions_js' );
		\Wikia::addAssetsToOutput( 'embeddable_discussions_scss' );
		return true;
	}

	public static function render( $input, array $args ) {
		global $wgCityId;

		$showLatest = !empty( $args['mostrecent'] ) && filter_var( $args['mostrecent'], FILTER_VALIDATE_BOOLEAN );
		$itemCount = empty( $args['size'] ) ? static::ITEMS_DEFAULT : intval( $args['size'] );
		$columns = empty( $args['columns'] ) ? static::COLUMNS_DEFAULT : intval( $args['columns'] );

		if ( $itemCount > static::ITEMS_MAX ) {
			$itemCount = static::ITEMS_MAX;
		}

		if ( $itemCount < static::ITEMS_MIN ) {
			$itemCount = static::ITEMS_MIN;
		}

		if ( $columns < static::COLUMNS_MIN ) {
			$columns = static::COLUMNS_MIN;
		}

		if ( $columns > static::COLUMNS_MAX ) {
			$columns = static::COLUMNS_MAX;
		}

		$templateEngine = ( new Wikia\Template\MustacheEngine )->setPrefix( __DIR__ . '/templates' );

		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			// In Mercury, discussions are rendered client side as an Ember component
			$modelData = [
				'mercuryComponentAttrs' => json_encode( [
					'show' => $showLatest ? 'latest' : 'trending',
					'itemCount' => $itemCount,
				] ),
				'loading' => wfMessage( 'embeddable-discussions-loading' )->plain()
			];

			// In mercury, discussions app is rendered client side
			$html = $templateEngine->clearData()
				->setData( $modelData )
				->render( 'DiscussionThreadMobile.mustache' );

			return $html;
		} else {
			$modelData = ( new DiscussionsThreadModel( $wgCityId ) )->getData( $showLatest, $itemCount );

			$modelData['columns'] = $columns;
			$modelData['columnsWrapperClass'] = $columns === 2 ? 'embeddable-discussions-threads-columns' : '';
			$modelData['columnsDetailsClass'] = $columns === 2 ? 'embeddable-discussions-post-detail-columns' : '';
			$modelData['heading'] = $showLatest ? wfMessage( 'embeddable-discussions-show-latest' )->plain() :
				wfMessage( 'embeddable-discussions-show-trending' )->plain();
			$modelData['replyText'] = wfMessage( 'embeddable-discussions-reply' )->plain();
			$modelData['shareText'] = wfMessage( 'embeddable-discussions-share' )->plain();
			$modelData['showAll'] = wfMessage( 'embeddable-discussions-show-all' )->plain();
			$modelData['showLatest'] = $showLatest;
			$modelData['upvoteText'] = wfMessage( 'embeddable-discussions-upvote' )->plain();
			$modelData['zeroText'] = wfMessage( 'embeddable-discussions-zero' )->plain();
			$modelData['zeroTextDetail'] = wfMessage( 'embeddable-discussions-zero-detail' )->plain();

			$html = $templateEngine->clearData()
				->setData( $modelData )
				->render( 'DiscussionThread.mustache' );

			return $html;
		}
	}
}
