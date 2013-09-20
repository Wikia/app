<?php

class ParserSpeedHooks {

	const SCRIBE_KEY = 'parser_speed_article';

	static public function onParserAfterTidy( Parser &$parser, &$text ) {
		$parser->mOutput->setPerformanceStats('expFuncCount',   $parser->mExpensiveFunctionCount);
		$parser->mOutput->setPerformanceStats('nodeCount',      $parser->mPPNodeCount);
		$parser->mOutput->setPerformanceStats('postExpandSize', $parser->mIncludeSizes['post-expand']);
		$parser->mOutput->setPerformanceStats('tempArgSize',    $parser->mIncludeSizes['arg']);
		return true;
	}

	static public function onArticleViewAfterParser( Article $article, ParserOutput $parserOutput ) {
		global $wgCityId, $wgDBname;
		// we collect production data from Oasis only
		/*
		$app = F::app();
		if ( !$app->checkSkin( 'oasis', $app->wg->Skin )
				|| $app->wg->DevelEnvironment || $app->wg->StagingEnvironment ) {
			return true;
		}
		*/

		if ( class_exists('WScribeClient') ) {
			try {
				$title = $article->getTitle();
				$fields = array(
					'wikiId'         => intval($wgCityId),
					'databaseName'   => $wgDBname,
					'articleId'      => $title->getArticleID(),
					'namespaceId'    => $title->getNamespace(),
					'articleTitle'   => $title->getText(),
					'parserTime'     => $parserOutput->getPerformanceStats('time'),
					'wikitextSize'   => $parserOutput->getPerformanceStats('wikitextSize'),
					'htmlSize'       => $parserOutput->getPerformanceStats('htmlSize'),
					'expFuncCount'   => $parserOutput->getPerformanceStats('expFuncCount'),
					'nodeCount'      => $parserOutput->getPerformanceStats('nodeCount'),
					'postExpandSize' => $parserOutput->getPerformanceStats('postExpandSize'),
					'tempArgSize'    => $parserOutput->getPerformanceStats('tempArgSize'),
				);
				$data = json_encode( $fields );
				WScribeClient::singleton( self::SCRIBE_KEY )->send( $data );
			}
			catch( TException $e ) {
				Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
			}
		}

		return true;
	}

}