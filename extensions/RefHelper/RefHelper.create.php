<?php
class RefHelper extends SpecialPage {
	const MSG = 'refhelper-';
	function __construct() {
		parent::__construct( 'RefHelper', 'edit', true, false, 'default', false );
		
	}

	/** A simple helper function to output the html of a table row with an input box.
		@param $out $wgOut should be passed
		@param $varname the string of the GET variable name
		@param $varval the value of the GET variable name
		@param $label the text describing the variable
	*/
	private function addTableRow( &$out, $varname, $varval, $label, $size = 50 ) {
		$out->addHTML( Xml::openElement( 'tr' ) );
		$out->addHTML( Xml::openElement( 'td', array( 'class' => 'mw-label' ) ) );
		$out->addHTML( Xml::element( 'label', array( 'for' => $varname ), "$label" ) );
		$out->addHTML( Xml::closeElement( 'td' ) );
		$out->addHTML( Xml::openElement( 'td' ) );
		$out->addHTML( Xml::input( $varname, $size, $varval, array( 'id' => "inp_$varname" ) ) );
		$out->addHTML( Xml::closeElement( 'td' ) );
		$out->addHTML( Xml::closeElement( 'tr' ) );
	}

	/**
	 * Another simple helper function to output the html of a table row, but with two input boxes.
	 * See addTableRow for parameter details
	 */
	private function add2ColTableRow( &$out, $varname1, $varname2, $varval1, $varval2, $label1, $label2 ) {
		$out->addHTML( Xml::openElement( 'tr' ) );
		$out->addHTML( Xml::openElement( 'td', array( 'class' => 'mw-label' ) ) );
		$out->addHTML( Xml::element( 'label', array( 'for' => $varname1 ), "$label1" ) );
		$out->addHTML( Xml::closeElement( 'td' ) );
		$out->addHTML( Xml::openElement( 'td' ) );
		$out->addHTML( Xml::input( $varname1, 15, $varval1, array( 'id' => "inp_$varname1", 'oninput' => 'updateFirstName(event)' ) ) );
		$out->addHTML( Xml::element( 'label', array( 'for' => $varname2 ), " $label2: " ) );
		$out->addHTML( Xml::input( $varname2, 20, $varval2, array( 'id' => "inp_$varname2", 'oninput' => 'updateSurname(event)' ) ) );
		$out->addHTML( Xml::closeElement( 'td' ) );
		$out->addHTML( Xml::closeElement( 'tr' ) );
	}

	/**
	 * Create the html body and (depending on the GET variables) creates the page.
	 */
	function execute( $par ) {
		global $wgRequest, $wgOut, $wgScript;

		$this->setHeaders();

		# Get request data from, e.g.
		$action = $wgRequest->getText( 'action' );
		$refname = htmlentities( $wgRequest->getText( 'refname' ) );
		$author1 = htmlentities( $wgRequest->getText( 'author1' ), ENT_COMPAT, "UTF-8" );
		$author2 = htmlentities( $wgRequest->getText( 'author2' ), ENT_COMPAT, "UTF-8" );
		$author3 = htmlentities( $wgRequest->getText( 'author3' ), ENT_COMPAT, "UTF-8" );
		$author4 = htmlentities( $wgRequest->getText( 'author4' ), ENT_COMPAT, "UTF-8" );
		$author5 = htmlentities( $wgRequest->getText( 'author5' ), ENT_COMPAT, "UTF-8" );

		$surname1 = htmlentities( $wgRequest->getText( 'surname1' ), ENT_COMPAT, "UTF-8" );
		$surname2 = htmlentities( $wgRequest->getText( 'surname2' ), ENT_COMPAT, "UTF-8" );
		$surname3 = htmlentities( $wgRequest->getText( 'surname3' ), ENT_COMPAT, "UTF-8" );
		$surname4 = htmlentities( $wgRequest->getText( 'surname4' ), ENT_COMPAT, "UTF-8" );
		$surname5 = htmlentities( $wgRequest->getText( 'surname5' ), ENT_COMPAT, "UTF-8" );

		$pmid = htmlentities( $wgRequest->getText( 'pmid' ), ENT_COMPAT, "UTF-8" );

		$articletitle = htmlentities( $wgRequest->getText( 'articletitle' ) );
		$journal = htmlentities( $wgRequest->getText( 'journal' ) );
		$volume = htmlentities( $wgRequest->getText( 'volume' ) );
		$pages = htmlentities( $wgRequest->getText( 'pages' ) );
		$year = htmlentities( $wgRequest->getText( 'year' ) );

		$cat1 = htmlentities( $wgRequest->getText( 'cat1' ) );
		$cat2 = htmlentities( $wgRequest->getText( 'cat2' ) );
		$cat3 = htmlentities( $wgRequest->getText( 'cat3' ) );
		$cat4 = htmlentities( $wgRequest->getText( 'cat4' ) );

		$reqfilled = strlen( $author1 ) && strlen( $articletitle ) && strlen( $journal ) && strlen( $year ) && strlen( $refname );
		if ( $action != "submit" || !$reqfilled ) {
			if ( strlen( $pmid ) ) {
				$result = RefSearch::query_pmid( $pmid );
				$articletitle = $result["title"];
				$journal      = $result["journal"];
				$volume       = $result["volume"];
				$pages        = $result["pages"];
				$year         = $result["year"];
				$auths        = $result["authors"];
				if ( isset( $auths[0] ) ) {
					$author1   =  $auths[0][0];
					$surname1  =  $auths[0][1];
				}
				if ( isset( $auths[1] ) ) {
					$author2   =  $auths[1][0];
					$surname2  =  $auths[1][1];
				}
				if ( isset( $auths[2] ) ) {
					$author3   =  $auths[2][0];
					$surname3  =  $auths[2][1];
				}
				if ( isset( $auths[3] ) ) {
					$author4   =  $auths[3][0];
					$surname4  =  $auths[3][1];
				}
				if ( isset( $auths[4] ) ) {
					$author5   =  $auths[4][0];
					$surname5  =  $auths[4][1];
				}
			}

			# Output
			$wgOut->addHTML(
				Xml::fieldset( wfMsg( self::MSG . 'refcreate_legend' ) ) .
				Xml::openElement( 'form', array( 'action' => $wgScript, 'id' => 'mw_create-ref-form' ) ) .
				Html::Hidden( 'title', $this->getTitle()->getPrefixedText() ) .
				Html::Hidden( 'action', 'submit' ) .
				Xml::openElement( 'table', array( 'id' => 'mw_create-ref-table' ) ) .
				Xml::openElement( 'tbody' ) );

			$wgOut->addHTML(
				Xml::openElement( 'tr' ) .
				Xml::openElement( 'td', array( 'class' => 'mw-label' ) ) .
				Xml::element( 'label', array( 'for' => 'inp_pastearea' ), wfMsg( self::MSG . 'label_workspace' ) . ":" ) .
				Xml::closeElement( 'td' ) .
				Xml::openElement( 'td' ) .
				Xml::textarea( 'inp_pastearea', '', 20, 5, array( 'oninput' => 'autoPopulateRefFields()' ) ) .
				Xml::closeElement( 'td' ) .
				Xml::closeElement( 'tr' ) );

			self::addTableRow( $wgOut, "pmid", $pmid, 'PMID', 15 );

			self::add2ColTableRow( $wgOut, 'author1', 'surname1', $author1, $surname1,
				wfMsg( self::MSG . 'label_authorforename', '1' ), wfMsg( self::MSG . 'label_authorsurname', '1' ) );
			self::add2ColTableRow( $wgOut, 'author2', 'surname2', $author2, $surname2,
				wfMsg( self::MSG . 'label_authorforename', '2' ), wfMsg( self::MSG . 'label_authorsurname', '2' ) );
			self::add2ColTableRow( $wgOut, 'author3', 'surname3', $author3, $surname3,
				wfMsg( self::MSG . 'label_authorforename', '3' ), wfMsg( self::MSG . 'label_authorsurname', '3' ) );
			self::add2ColTableRow( $wgOut, 'author4', 'surname4', $author4, $surname4,
				wfMsg( self::MSG . 'label_authorforename', '4' ), wfMsg( self::MSG . 'label_authorsurname', '4' ) );
			self::add2ColTableRow( $wgOut, 'author5', 'surname5', $author5, $surname5,
				wfMsg( self::MSG . 'label_authorforename', '5' ), wfMsg( self::MSG . 'label_authorsurname', '5' ) );

			self::addTableRow( $wgOut, "articletitle", $articletitle, wfMsg( self::MSG . 'title' ) );
			self::addTableRow( $wgOut, "journal", $journal, wfMsg( self::MSG . 'journal' ) );
			self::addTableRow( $wgOut, "pages", $pages, wfMsg( self::MSG . 'pages' ) );
			self::addTableRow( $wgOut, "year", $year, wfMsg( self::MSG . 'year' ) );
			self::addTableRow( $wgOut, "refname", $refname, wfMsg( self::MSG . 'refname' ) );
			self::addTableRow( $wgOut, "cat1", $cat1, wfMsg( self::MSG . 'category', '1' ) );
			self::addTableRow( $wgOut, "cat2", $cat2, wfMsg( self::MSG . 'category', '2' ) );
			self::addTableRow( $wgOut, "cat3", $cat3, wfMsg( self::MSG . 'category', '3' ) );
			self::addTableRow( $wgOut, "cat4", $cat4, wfMsg( self::MSG . 'category', '4' ) );

			$wgOut->addHTML(
				Xml::openElement( 'tr' ) .
				Xml::openElement( 'td', array( 'class' => 'mw-submit' ) ) .
				Xml::element( 'input', array( 'value' => wfMsg( self::MSG . 'create' ), 'type' => 'submit' ) ) .
				Xml::closeElement( 'td' ) .
				Xml::closeElement( 'tr' ) .
				Xml::closeElement( 'tbody' ) .
				Xml::closeElement( 'table' ) .
				Xml::closeElement( 'form' ) .
				Xml::closeElement( 'fieldset' ) );
		}
		else
		{
			global $wgRefHelperCiteTemplate, $wgRefHelperPageTemplate, $wgRefHelperCiteNS;
			$db = wfGetDB( DB_MASTER );

			$citeTitle = null;
			if ( strlen( $wgRefHelperCiteNS ) ) $citeTitle = Title::newFromText( "$wgRefHelperCiteNS:$refname" );
			$pageTitle = Title::newFromText( $refname );


			$paramtext = '';
			$paramtext .= "| first1 = $author1\n";
			$paramtext .= "| last1 = $surname1\n";

			if ( strlen( $author2 ) || strlen( $surname2 ) ) {
				$paramtext .= "| first2 = $author2\n";
				$paramtext .= "| last2 = $surname2\n";
			}
			if ( strlen( $author3 ) || strlen( $surname3 ) ) {
				$paramtext .= "| first3 = $author3\n";
				$paramtext .= "| last3 = $surname3\n";
			}
			if ( strlen( $author4 ) || strlen( $surname4 ) ) {
				$paramtext .= "| first4 = $author4\n";
				$paramtext .= "| last4 = $surname4\n";
			}
			if ( strlen( $author5 ) || strlen( $surname5 ) ) {
				$paramtext .= "| first5 = $author5\n";
				$paramtext .= "| last5 = $surname5\n";
			}

			$paramtext .= "| refname = $refname\n";
			$paramtext .= "| articletitle = $articletitle\n";
			$paramtext .= "| titlelink = [[$refname|$articletitle]]\n";
			$paramtext .= "| journal = $journal\n";
			$paramtext .= "| volume = $volume\n";
			$paramtext .= "| pages = $pages\n";
			$paramtext .= "| pmid = $pmid\n";
			$paramtext .= "| year = $year\n";
			$paramtext .= "| lt = <\n"; // can be used to allow templates to create pages with onlyinclude, etc.
			$paramtext .= "| categories = ";
			if ( strlen( $cat1 ) ) $paramtext .= "[[Category:$cat1]]\n";
			if ( strlen( $cat2 ) ) $paramtext .= "[[Category:$cat2]]\n";
			if ( strlen( $cat3 ) ) $paramtext .= "[[Category:$cat3]]\n";
			if ( strlen( $cat4 ) ) $paramtext .= "[[Category:$cat4]]\n";

			if ( $citeTitle->exists() == false ) {
				$newcontent = '{{' . "$wgRefHelperCiteTemplate\n$paramtext}}\n";

				$citePage = new Article( $citeTitle );
				$citePage->doEdit( $newcontent, wfMsg( self::MSG . 'refcreate_autocomment' ) );
				$rev_id = $citePage->insertOn( $db );

				$wgOut->addWikiText( wfMsg( self::MSG . 'refcreate_success', array( "$wgRefHelperCiteNS:$refname" ) ) );
			}
			else {
				$wgOut->addWikiText( wfMsg( self::MSG . 'refcreate_failure', array( "$wgRefHelperCiteNS:$refname" ) ) );
			}
			if ( $pageTitle->exists() == false ) {
				$newcontent = '{{' . "$wgRefHelperPageTemplate\n$paramtext}}\n";

				$newPage = new Article( $pageTitle );
				$newPage->doEdit( $newcontent, wfMsg( self::MSG . 'refcreate_autocomment' ) );
				$rev_id = $newPage->insertOn( $db );

				$wgOut->addWikiText( wfMsg( self::MSG . 'refcreate_success', array( $refname ) ) );
			}
			else {
				$wgOut->addWikiText( wfMsg( self::MSG . 'refcreate_failure', array( $refname ) ) );
			}

			$wgOut->addWikiText( '[[Special:RefHelper|' . wfMsg( self::MSG . 'refcreate_another' ) . ']]' );
		}
	}
}
