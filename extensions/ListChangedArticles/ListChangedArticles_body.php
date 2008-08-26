<?php

class ListChangedArticles extends UnlistedSpecialPage
{
	function ListChangedArticles() {
		UnlistedSpecialPage::UnlistedSpecialPage("ListChangedArticles");
	}

	function execute( $par ) {
		global $wgRequest ;
		$since = $wgRequest->getText( 'since' ) ;
		print $this->getListOfChangedArticlesSince ( $since ) ;
		exit ( 0 ) ;
	}

	/**
	 * This function returns a XML list with all article titles and namespaces changed since {$since}
	 * Using WikiExporter for this seems overkill, as the SQL query is pretty simple
	*/
	function getListOfChangedArticlesSince ( $since ) {
		global $wgLang ;
		$fname = "getListOfChangedArticlesSince" ;
		wfProfileIn( $fname );
		
		$rowlimit = 30000 ; # The maximum number of results
	
		$ret = "" ;
		$dbr =& wfGetDB( DB_SLAVE );
		$since = $dbr->timestamp ( $since ) ;
		$sql = "SELECT page_namespace,page_title FROM page WHERE page_touched >= \"{$since}\" LIMIT {$rowlimit}" ;
		$res = $dbr->query ( $sql , $fname ) ;
		
		if ( mysql_num_rows ( $res ) == $rowlimit ) { # Assuming there are more. Would be better with SQL_CALC_FOUND_ROWS (MySQL 4 and above)
			mysql_free_result ( $res ) ;
			wfProfileOut( $fname );
			return "TOO MANY ROWS!" ;
		}
		
		header( "Content-type: application/xml; charset=utf-8" );
		$ret .= "<mediawiki>" ;
		$ret .= "<articlelist>" ;
		
		while( $obj = $dbr->fetchObject( $res ) ) {
			$t = Title::newFromText ( $obj->page_title , $obj->page_namespace ) ;			
			$attribs = array () ;
			$attribs["prefixed_title"] = $t->getPrefixedDBkey() ;
			$attribs["title"] = $t->getDBkey() ;
			$attribs["namespace_id"] = $obj->page_namespace ;
			$attribs["namespace_name"] = $wgLang->getNsText ( $obj->page_namespace ) ;
			$ret .= wfElement ( "article" , $attribs ) ;
		}
		
		$ret .= "</articlelist>" ;
		$ret .= "</mediawiki>" ;
	
		wfProfileOut( $fname );
		return $ret ;
	}

}

