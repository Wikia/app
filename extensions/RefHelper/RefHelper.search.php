<?php
class RefSearch extends SpecialPage {
	function __construct() {
		parent::__construct( 'RefSearch', 'edit', true, false, 'default', false );
		wfLoadExtensionMessages( 'RefHelper' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgScript;

		$this->setHeaders();

		# Get request data from, e.g.
		$action = $wgRequest->getText( 'action' );

		$query = htmlentities( $wgRequest->getText( 'query' ) );

		# Output
		$wgOut->addHTML(
			Xml::fieldset( wfMsg( RefHelper::MSG . 'refsearch_legend' ) ) .
			Xml::openElement( 'form', array( 'action' => $wgScript, 'id' => 'mw_search-ref-form' ) ) .
			Xml::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
			Xml::hidden( 'action', 'submit' ) .
			Xml::openElement( 'table', array( 'id' => 'mw_search-ref-table' ) ) .
			Xml::openElement( 'tbody' ) );

		$wgOut->addHTML(
			Xml::openElement( 'tr' ) .
			Xml::openElement( 'td', array( 'class' => 'mw-input' ) ) .
			Xml::input( 'query', 50, $query ) .
			Xml::closeElement( 'td' ) .
			Xml::openElement( 'td', array( 'class' => 'mw-submit' ) ) .
			Xml::element( 'input', array( 'value' => wfMsg( RefHelper::MSG . 'search' ), 'type' => 'submit' ) ) .
			Xml::closeElement( 'td' ) .
			Xml::closeElement( 'tr' ) );

		$wgOut->addHTML(
			Xml::closeElement( 'tbody' ) .
			Xml::closeElement( 'table' ) .
			Xml::closeElement( 'form' ) );

		$reqfilled = strlen( $query );
		if ( $action == "submit" || $reqfilled ) {
			$wgOut->addHTML( self::perform_search( $query ) );
		}
		$wgOut->addHTML( Xml::closeElement( 'fieldset' ) );
	}

	static function newArticleHook( &$editpage ) {
		wfLoadExtensionMessages( 'RefHelper' );
		global $wgOut, $wgRefHelperCiteNS;

		// don't display if page already exists
		$title = $editpage->getArticle()->getTitle();
		if ( $title->exists() ) return true;
		if ( $title->getNsText() !== $wgRefHelperCiteNS ) return true;

		$editpage->setHeaders();

		$query = $title->getText();
		$query = preg_replace( '/ ((?>19|20)[0-9]{2})$/', ' $1[PDAT]', $query );
		$query = preg_replace( '/(?> |^)([^0-9]+) /', ' $1[AUTH] ', $query );
		/*$query = preg_replace('/ ([0-9]{4})$/',' $1[PDAT]',$query);*/

		$wgOut->addWikiMsg( RefHelper::MSG . 'newarticle_nocitation' );

		$result = self::perform_search( $query );
		if ( $result ) {
			$wgOut->addWikiMsg( RefHelper::MSG . 'newarticle_suggestions' );
			$wgOut->addHTML( $result );
		}
		else {
			$wgOut->addWikiMsg( RefHelper::MSG . 'newarticle_nosuggestions' );
		}
		return false;
	}

	static function perform_search( $query ) {
		global $wgScript;
		$query = str_replace( " ", "+", $query );
		$ch = curl_init( "http://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?term=$query&tool=mediawiki_refhelper" );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$result = curl_exec( $ch );
		curl_close( $ch );

		$num = preg_match_all( "|<Id>(\d+)</Id>|", $result, $matches );
		if ( $num === 0 || $num === false ) return false;

		$ret = Xml::openElement( 'table' );
		for ( $i = 0; $i < $num; $i++ ) {
			$pmid = $matches[1][$i];
			$result = self::query_pmid( $pmid );

			$author = array_shift( $result["authors"] );
			if ( isset( $author ) ) $author = $author[1];
			$title = $result["title"];
			$query = $result["query_url"];
			$year = $result["year"];
			if ( count( $result["AU"] ) > 1 ) $etal = " et al.";
			else $etal = "";

			$ret .=
				Xml::openElement( 'tr' ) .
				Xml::element( 'td', null, "$author $etal ($year) \"$title\"" ) .
				Xml::openElement( 'td' ) .
				Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript, 'id' => "mw-create-ref-form$i" ) ) .
				Xml::hidden( 'title', 'Special:RefHelper' ) .
				Xml::hidden( 'pmid', $pmid ) .
				Xml::element( 'input', array( 'value' => wfMsg( RefHelper::MSG . 'create' ), 'type' => 'submit' ) ) .
				Xml::closeElement( 'form' ) .
				Xml::closeElement( 'td' ) .
				Xml::closeElement( 'tr' );
		}
		$ret .= Xml::closeElement( 'table' );
		return $ret;
	}

	private static function parse_medline( $text, $field ) {
		$field = strtoupper( $field );
		$num = preg_match_all( "|\n$field\s*- (.*)(?>\n      (.*))*|", $text, $matches, PREG_SET_ORDER );
		$ret = array();
		for ( $i = 0; $i < $num; $i++ )
		{
			array_shift( $matches[$i] );
			$ret[] = implode( " ", $matches[$i] );
		}
		return $ret;
	}

	static function query_pmid( $pmid ) {
		$ret = array();
		$ret["query_url"] = "http://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=pubmed&report=medline&mode=text&id=$pmid&email=jonwilliford@gmail.com&tool=mediawiki_refhelper";
		$ch = curl_init( $ret["query_url"] );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$result = curl_exec( $ch );
		curl_close( $ch );

		$ret["title"]   = array_shift( self::parse_medline( $result, "TI" ) );
		$ret["journal"] = array_shift( self::parse_medline( $result, "TA" ) );
		$ret["year"]    = substr( array_shift( self::parse_medline( $result, "DP" ) ), 0, 4 );
		$ret["volume"]  = array_shift( self::parse_medline( $result, "VI" ) );
		$ret["issue"]   = array_shift( self::parse_medline( $result, "IP" ) );
		$ret["pages"]   = array_shift( self::parse_medline( $result, "PG" ) );

		$ret["firstlasts"] = self::parse_medline( $result, "FAU" );
		$ret["AU"] = self::parse_medline( $result, "AU" );

		$ret["authors"] = array();

		/* This wasn't working as I was wanting previously. I want to test more before uncommenting.
		if( isset( $ret["firstlasts"] ) )
		{
			for( $i = 0; $i < count( $ret["firstlasts"] ); $i++ ) {

				$auth = $ret["firstlasts"][$i];

				if( preg_match("|(.+), (.+)|", $auth, $matches ) ) {

					// index 0 for first name, index 1 for surname
					$ret["authors"][$i][1] = $matches[1];
					$ret["authors"][$i][0] = $matches[2];
				}
				else {
					$ret["authors"][$i] = array(0=>"",1=>$auth);
				}
			}
		}
		else*/
		{
			for ( $i = 0; $i < count( $ret["AU"] ); $i++ ) {

				$auth = $ret["AU"][$i];

				if ( preg_match( "|^(.+) (.+)$|", $auth, $matches ) ) {

					// index 0 for first name, index 1 for surname
					$ret["authors"][$i][1] = $matches[1];
					$ret["authors"][$i][0] = $matches[2];
				}
				else {
					$ret["authors"][$i] = array( 0 => "", 1 => $auth );
				}
			}
		}

		return $ret;
	}
}
