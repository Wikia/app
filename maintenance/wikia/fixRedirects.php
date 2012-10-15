<?php
/**
 * @addto maintenance
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com>
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

/**
 * get broken redirects
 */
$wgUser = User::newFromName( "WikiaBot" );
$broken_redirects = array();
$dbw = wfGetDB( DB_MASTER );
$sql = "
	SELECT
		page_title, page_namespace, page_id, page_latest
	FROM
		page
	LEFT JOIN
		redirect
	ON
		page_id = rd_from
	WHERE
		page_is_redirect = 1
	AND
		rd_from IS NULL;
";
$oRes = $dbw->query( $sql, __FILE__ );
while( $oRow = $dbw->fetchObject( $oRes) ) {
	$broken_redirects[] = $oRow;
}
$dbw->freeResult( $oRes );

foreach( $broken_redirects as $page ) {
	/**
	 * get revision for this articles
	 */
	$oRevision = Revision::newFromId( $page->page_latest );
	$text = $oRevision->getText();

	/**
	 * first find proper redirects
	 */
	//echo $text."\n";
	$counter = 0;
	if( preg_match("/#REDIRECT\s+\[\[(.+)\]\]/i", $text, $match ) ) {
		$title = trim( $match[1] );
		$oTitle = Title::newFromURL( $title );
		if( ! is_null( $oTitle ) && ! $oTitle->isExternal() ) {
			/**
			 * now delete old redirect (if any) and insert new one
			 * into redirect table
			 */
			$dbw->begin();
			$dbw->delete(
				"redirect",
				array( "rd_from" => $page->page_id ),
				__METHOD__
			);
			$dbw->insert(
				"redirect",
				array(
					"rd_from" => $page->page_id,
					"rd_namespace" => $oTitle->getNamespace(),
					"rd_title" => $oTitle->getText()
				),
				__METHOD__
			);
			$dbw->commit();
			echo ".";
			$counter++;
		}
	}
	else {
		/**
		 * fix common typos
		 */
		$oTitle = Title::newFromId( $page->page_id );

		/**
		 * now find target
		 */
		if( preg_match("/#REDIRECT\[\[(.+)\]\]/i", $text, $match ) ) {
			/**
			 * no space after #REDIRECT
			 */
			$title = trim( $match[1] );
		}
		elseif( preg_match("/#REDIRECT:\s*\[\[(.+)\]\]/i", $text, $match ) ) {
			/**
			 * colon after #REDIRECT
			 */
			$title = trim( $match[1] );
		}
		elseif( preg_match("/#REDIRECTS \s*\[\[(.+)\]\]/i", $text, $match ) ) {
			/**
			 * #REDIRECTS instead #REDIRECT
			 */
			$title = trim( $match[1] );
		}

		echo ".";
		if( !is_null( $oTitle ) ) {
			/**
			 * new Article revision with updated text
			 */
			$article = new Article( $oTitle, 0 );
			$article->doEdit(
				"#REDIRECT [[{$title}]]\n",
				"broken redirection, fixed by maintenance script",
				EDIT_UPDATE | EDIT_MINOR | EDIT_FORCE_BOT
			);
			$counter++;
		}
	}
}
echo "\nTotal redirects fixed: {$counter}\n";
