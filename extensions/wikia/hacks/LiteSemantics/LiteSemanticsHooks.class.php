<?php
/**
 * Lite Semantics hooks
 *
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */

class LiteSemanticsHooks extends WikiaObject{

	public function onInternalParseBeforeLinks( &$parser, &$text ){
		$semanticsDocument = F::build( 'LiteSemanticsParser' )->parse( $text, $parser->getTitle() );

		//give a chance to extensions to alter the data to be stored
		if ( F::app()->runHook( 'LiteSemanticsBeforeProcessDocument', array( &$semanticsDocument ) ) ) {
			//TODO: store in DB/cache goes here

			$text = $semanticsDocument->process();
		}

		return true;
	}

	public function onArticleDeleteComplete( &$article, User &$user, $reason, $id ){
		//TODO: clear cache/DB
		return true;
	}

	public function onArticleSaveComplete( &$article, &$user, $text, $summary,
		 $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId, &$redirect ){
		//TODO: clear cache/DB
		return true;
	}
}
