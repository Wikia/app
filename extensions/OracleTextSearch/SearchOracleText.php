<?php

class SearchOracleText extends SearchOracle {


	public function update( $id, $title, $text ) {
		global $wgExIndexMIMETypes, $wgExIndexOnHTTP;

		parent::update( $id, $title, $text );

		$titleObj = Title::newFromID( $id );
		$file = wfLocalFile( $titleObj->getText() );
		if ( in_array( $file->getMimeType(), $wgExIndexMIMETypes ) ) {
			$dbw = wfGetDB(DB_MASTER);
			//$dbw->query("CALL CTXSYS.CTX_OUTPUT.START_LOG('wiki_ctx.log')"); //use for INTERNAL debuging ONLY!!!

			$url = $wgExIndexOnHTTP ? preg_replace( '/^https:/i', 'http:', $file->getFullUrl() ) : $file->getFullUrl();
			$dbw->update('searchindex',
				array( 'si_url' => $url ), 
				array( 'si_page' => $id ),
				'SearchIndexUpdate:update' );
			wfDebugLog( 'OracleTextSearch', 'Updated si_url for page ' . $id );

			$index = $dbw->getProperty('mTablePrefix')."si_url_idx";
			$dbw->query( "CALL ctx_ddl.sync_index('$index')" );
			wfDebugLog( 'OracleTextSearch', 'Synced index: '.$index);
		}
	}

	function parseQuery( $filteredText, $fulltext ) {
		$match = parent::parseQuery( $filteredText, $fulltext );

		if ( $fulltext ) {
			$field = $this->getIndexField($fulltext);
			$searchon = preg_replace( "/ CONTAINS\($field, ('.*'), 1\) > 0 /", "\\1", $match);
			$match = "($match OR CONTAINS(si_url, $searchon, 2) > 0) ";
		}

		wfDebugLog( 'OracleTextSearch', 'Matching: '.$match );
		return $match;
	}

	public static function onUploadCompleteHook( &$file ) {
		global $wgExIndexMIMETypes;

		$localFile = $file->getLocalFile();
		if ( $localFile !=  null && in_array( $localFile->getMimeType(), $wgExIndexMIMETypes ) ) {
			wfDebugLog( 'OracleTextSearch', 'Touching file page to force indexing');
			$article = new Article( $localFile->getTitle() );
			$article->loadContent();
			$article->doEdit( $article->mContent, $article->mComment );
		}
		return true;
	}
}
