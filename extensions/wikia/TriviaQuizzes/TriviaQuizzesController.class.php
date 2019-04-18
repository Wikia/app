<?php

class TriviaQuizzesController {
	const TAG_NAME = 'trivia-quizzes';
	const ITEMS_DEFAULT = 4;
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
		global $wgEnableTriviaQuizzesAlpha;

		if ( $wgEnableTriviaQuizzesAlpha ) {
			$parser->setHook( self::TAG_NAME, [ new self(), 'render' ] );
		}

		return true;
	}

	public static function onBeforePageDisplay() {
		\Wikia::addAssetsToOutput( 'trivia_quizzes_js' );

		JSMessages::enqueuePackage( 'TriviaQuizzes', JSMessages::EXTERNAL );

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
			$errorMessage = wfMessage( 'embeddable-discussions-parameter-error', 'mostrecent',
				wfMessage( 'embeddable-discussions-parameter-error-boolean' )->inContentLanguage()->plain()
			)->inContentLanguage()->plain();

			return false;
		}

		// size must be integer in range
		if ( isset( $args['size'] ) ) {
			$size = $args['size'];

			if ( !ctype_digit( $size ) ||
				intval( $size ) > self::ITEMS_MAX ||
				intval( $size ) < self::ITEMS_MIN
			) {
				$errorMessage = wfMessage( 'embeddable-discussions-parameter-error', 'size',
					wfMessage( 'embeddable-discussions-parameter-error-range',
						self::ITEMS_MIN , self::ITEMS_MAX )->inContentLanguage()->plain()
				)->inContentLanguage()->plain();

				return false;
			}
		}

		// columns must be integer in range
		if ( isset( $args['columns'] ) ) {
			$columns = $args['columns'];

			if ( !ctype_digit( $columns ) ||
				intval( $columns ) > self::COLUMNS_MAX ||
				intval( $columns ) < self::COLUMNS_MIN
			) {
				$errorMessage = wfMessage( 'embeddable-discussions-parameter-error', 'columns',
					wfMessage( 'embeddable-discussions-parameter-error-range',
						self::COLUMNS_MIN , self::COLUMNS_MAX )->inContentLanguage()->plain()
				)->inContentLanguage()->plain();

				return false;
			}
		}

		// category must be a valid category
		if ( $modelData['invalidCategory'] ) {
			$errorMessage = wfMessage( 'embeddable-discussions-parameter-error', $args['catid'],
				wfMessage( 'embeddable-discussions-parameter-error-category' )->inContentLanguage()->plain()
			)->inContentLanguage()->plain();

			return false;
		}

		return true;
	}

	private function renderMobile( $wgCityId ) {
		return $this->templateEngine->clearData()
			->setData( [] )
			->render( 'TriviaQuizzes.mustache' );
	}

	private function renderDesktop( $wgCityId ) {
		return $this->templateEngine->clearData()
			->setData( [] )
			->render( 'TriviaQuizzes.mustache' );
	}

	public function render( $input, array $args ) {
		global $wgCityId;

		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			return $this->renderMobile( $wgCityId );
		} else {
			return $this->renderDesktop( $wgCityId );
		}
	}
}
