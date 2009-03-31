<?php

class LinkSearchSpecialPage extends SpecialPage {
	public function __construct() {
		parent::__construct( 'LinkSearch' );
	}

	function execute( $par ) {
		wfLoadExtensionMessages( 'LinkSearch' );

		$this->setHeaders();

		list( $limit, $offset ) = wfCheckLimits();
		global $wgOut, $wgRequest, $wgUrlProtocols, $wgMiserMode;
		$target = $GLOBALS['wgRequest']->getVal( 'target', $par );
		$namespace = $GLOBALS['wgRequest']->getIntorNull( 'namespace', null );

		$protocols_list[] = '';
		foreach( $wgUrlProtocols as $prot ) {
			$protocols_list[] = $prot;
		}

		$target2 = $target;
		$protocol = '';
		$pr_sl = strpos($target2, '//' );
		$pr_cl = strpos($target2, ':' );
		if ( $pr_sl ) {
			// For protocols with '//'
			$protocol = substr( $target2, 0 , $pr_sl+2 );
			$target2 = substr( $target2, $pr_sl+2 );
		} elseif ( !$pr_sl && $pr_cl ) {
			// For protocols without '//' like 'mailto:'
			$protocol = substr( $target2, 0 , $pr_cl+1 );
			$target2 = substr( $target2, $pr_cl+1 );
		} elseif ( $protocol == '' && $target2 != '' ) {
			// default
			$protocol = 'http://';
		}
		if ( !in_array( $protocol, $protocols_list ) ) {
			// unsupported protocol, show original search request
			$target2 = $target;
			$protocol = '';
		}

		$self = Title::makeTitle( NS_SPECIAL, 'Linksearch' );

		$wgOut->addWikiText( wfMsg( 'linksearch-text', '<nowiki>' . implode( ', ',  $wgUrlProtocols) . '</nowiki>' ) );
		$s =	Xml::openElement( 'form', array( 'id' => 'mw-linksearch-form', 'method' => 'get', 'action' => $GLOBALS['wgScript'] ) ) .
			Xml::hidden( 'title', $self->getPrefixedDbKey() ) .
			'<fieldset>' .
			Xml::element( 'legend', array(), wfMsg( 'linksearch' ) ) .
			Xml::inputLabel( wfMsg( 'linksearch-pat' ), 'target', 'target', 50, $target ) . ' ';
		if ( !$wgMiserMode ) {
			$s .= Xml::label( wfMsg( 'linksearch-ns' ), 'namespace' ) . ' ' .
				XML::namespaceSelector( $namespace, '' );
		}
		$s .=	Xml::submitButton( wfMsg( 'linksearch-ok' ) ) .
			'</fieldset>' .
			Xml::closeElement( 'form' );
		$wgOut->addHTML( $s );

		if( $target != '' ) {
			$searcher = new LinkSearchPage( $target2, $namespace, $protocol );
			$searcher->doQuery( $offset, $limit );
		}
	}
}
