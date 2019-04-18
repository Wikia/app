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

	public static function onBeforePageDisplay(OutputPage $out) {
        global $wgEnableTriviaQuizzesAlpha;

        if ( $wgEnableTriviaQuizzesAlpha ) {
            $out->addModules('ext.wikia.TriviaQuizzes');
            Wikia::addAssetsToOutput( 'trivia_quizzes' );
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
