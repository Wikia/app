<?php

class ParserSpeedHooks extends WikiaObject {

	const SCRIBE_KEY = 'parser_speed_article';

	public function onArticleViewAfterParser( Article $article, ParserOutput $parserOutput ) {
		// we collect production data from Oasis only
		if ( !$this->app->checkSkin( 'oasis', $this->wg->Skin )
				|| $this->wg->DevelEnvironment || $this->wg->StagingEnvironment ) {
			return true;
		}

		if ( class_exists('WScribeClient') ) {
			try {
				$title = $article->getTitle();
				$fields = array(
					'wikiId' => intval($this->wg->CityId),
					'databaseName' => $this->wg->DBname,
					'articleId' => $title->getArticleID(),
					'namespaceId' => $title->getNamespace(),
					'articleTitle' => $title->getText(),
					'parserTime' => $parserOutput->getPerformanceStats('time'),
					'wikitextSize' => $parserOutput->getPerformanceStats('wikitextSize'),
					'htmlSize' => $parserOutput->getPerformanceStats('htmlSize'),
				);
				$data = json_encode( $fields );
				WScribeClient::singleton( self::SCRIBE_KEY )->send( $data );
				wfDebug( 'parser speed article' . $data . "\n" );
			}
			catch( TException $e ) {
				Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
			}
		}

		return true;
	}

}