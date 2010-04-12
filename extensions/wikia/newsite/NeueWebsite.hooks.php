<?php

/**
 * parser hooks definition
 * @author Krzysztof Krzyżaniak (eloy)
 */


class NeueWebsiteHooks {

	/**
	 * renderRelated
	 *
	 * static constructor/callback function -- render values from related table
	 *
	 * @access public
	 * @static
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @param string $input: Text from tag
	 * @param array $params: atrributions
	 * @param Object $parser: Wiki Parser object
	 */
	static public function renderRelated( $input, $params, &$parser ) {
		global $wgTitle, $wgOut;

		wfProfileIn( __METHOD__ );

		$key = strtolower( $wgTitle->getDBkey() );

		$dbr = wfGetDB( DB_SLAVE );
		$sth = $dbr->select(
			array( "related" ),
			array( "name1", "name2" ),
			array( $dbr->makeList( array( "name1" => $key, "name2" => $key ), LIST_OR ) )
		);

		$results = array();
		$output  = "";

		while( $row = $dbr->fetchObject( $sth ) ) {
			if( $row->name1 !== $key ) {
				$results[] = $row->name1;
			}
			if( $row->name2 !== $key ) {
				$results[] = $row->name2;
			}
		}
		$results = array_unique( $results );
		if( count( $results ) ) {
			wfLoadExtensionMessages( 'Newsite' );
			$output .= wfMsgForContent( 'newsite-output-related' ) . "\n";
			$output .= Xml::openElement( "span", array( "class" => "small" ) );
			foreach( $results as $site ) {
				$output .= sprintf("[[%s]] ", ucfirst( strtolower( $site ) ) );
			}
			$output .= Xml::closeElement( "span" );
		}
		else {
			$output .= "<!-- 0 related -->";
		}

		$output = $wgOut->parse( $output );

		wfProfileOut( __METHOD__ );

		return $output;
	}

}
