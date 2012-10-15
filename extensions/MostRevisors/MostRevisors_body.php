<?php
class MostRevisors extends IncludableSpecialPage {
	private $limit = null;
	private $namespace = null;
	private $redirects = null;

	public function __construct() {
		parent::__construct( 'MostRevisors' );
		$this->mIncludable = true;
	}

	public function execute( $par ) {
		global $wgOut, $wgRequest, $wgLang, $wgContLang;
		

		# Decipher input passed to the page
		$this->decipherParams( $par );
		$this->setOptions( $wgRequest );

		# ##debug
		# $wgOut->addWikiText( "DEBUG thisNS: $this->namespace" );

		$dbr = wfGetDB( DB_SLAVE );

		$conds = array();
		if ( $this->namespace == 'all' ) {
			$qns = null;
			if ( !$this->redirects ) $qns = "WHERE page_is_redirect=0";
		} else {
			$qns = "WHERE page_namespace=" . $this->namespace;
			if ( !$this->redirects ) $qns .= " AND page_is_redirect=0";
		}
		# ##debug
		# $wgOut->addWikiText( "DEBUG qns: $qns" );
		$limitfewrevisors = wfMsg( 'mostrevisors-limit-few-revisors' );
		list( $revision, $page ) = $dbr->tableNamesN( 'revision', 'page' );
		$sql = "
		SELECT
			page_title as title,
			page_is_redirect,
			page_namespace as namespace,
			COUNT(distinct rev_user) as value
		FROM $revision
		JOIN $page ON page_id = rev_page
		" . $dbr->strencode( $qns ) . "
		GROUP BY page_namespace, page_title
		HAVING COUNT(distinct rev_user) >=$limitfewrevisors
		ORDER BY value DESC
		LIMIT " . "{$this->limit}
		";
		# ##debug
		# $wgOut->addWikiText( "DEBUG sql: $sql" );
		$res = $dbr->query( $sql, __METHOD__ );
		$count = $dbr->numRows( $res );

		# Don't show the navigation if we're including the page
		if ( !$this->mIncluding ) {
			$this->setHeaders();
			$limit = $wgLang->formatNum( $this->limit );
			if ( $this->namespace > 0 ) {
				$wgOut->addWikiMsg( 'mostrevisors-ns-header', $limit, $wgContLang->getFormattedNsText( $this->namespace ) );
			} else {
				$wgOut->addWikiMsg( 'mostrevisors-header', $limit );
			}
			$wgOut->addHTML( $this->makeNamespaceForm() );
			$wgOut->addHTML( '<p>' . $this->makeLimitLinks() );
			$wgOut->addHTML( '<br />' . $this->makeRedirectToggle() . '</p>' );
		}

		if ( $count > 0 ) {
			# Make list
			if ( !$this->mIncluding )
				$wgOut->addWikiMsg( 'mostrevisors-showing', $wgLang->formatNum( $count ) );
			$wgOut->addHTML( "<ol>" );
			foreach ( $res as $row ) {
				$wgOut->addHTML( $this->makeListItem( $row ) );
			}
			$wgOut->addHTML( "</ol>" );
		} else {
			$wgOut->addWikiMsg( 'mostrevisors-none' );
		}
	}

	private function setOptions( &$req ) {
		global $wgMostRevisorsPagesLimit;
		if ( !isset( $this->limit ) )
		$this->limit = $this->sanitiseLimit( $req->getInt( 'limit', $wgMostRevisorsPagesLimit ) );
		if ( !isset( $this->namespace ) )
		$this->namespace = $this->extractNamespace( $req->getVal( 'namespace', 0 ) );
		if ( !isset( $this->redirects ) )
		$this->redirects = (bool)$req->getInt( 'redirects', 1 );
	}

	private function sanitiseLimit( $limit ) {
		return min( (int)$limit, 5000 );
	}

	private function decipherParams( $par ) {
		if ( $par ) {
			$bits = explode( '/', $par );
			foreach ( $bits as $bit ) {
				if ( is_numeric( $bit ) ) {
					$this->limit = $this->sanitiseLimit( $bit );
				} else {
					$this->namespace = $this->extractNamespace( $bit );
				}
			}
		}
	}

	private function extractNamespace( $namespace ) {
		global $wgContLang;
		if ( is_numeric( $namespace ) ) {
			return $namespace;
		} elseif ( $wgContLang->getNsIndex( $namespace ) !== false ) {
			return $wgContLang->getNsIndex( $namespace );
		} elseif ( $namespace == '-' ) {
			return NS_MAIN;
		} elseif ( $namespace == 'all' ) {
			return 'all';
		} else {
			return 'all';
		}
	}

	private function makeListItem( $row ) {
		global $wgUser, $wgMostRevisorsLinkContributors;
		$title = Title::makeTitleSafe( $row->namespace, $row->title );
		if ( !is_null( $title ) ) {
			$skin = $wgUser->getSkin();
			$link = $row->page_is_redirect
				? '<span class="allpagesredirect">' . $skin->makeKnownLinkObj( $title ) . '</span>'
				: $skin->makeKnownLinkObj( $title );
			$link .= ' ' . wfMsgExt( 'mostrevisors-users', array( 'parsemag'), $row->value );
			// FIXME: check if target page of the link below exists before linking to it.
			// FIXME: move brackets from code into message, see http://www.mediawiki.org/wiki/Internationalisation#Symbols.2C_colons.2C_brackets.2C_etc._are_parts_of_messages
			if ( $wgMostRevisorsLinkContributors == True ) $link .= " (" . $skin->makeKnownLinkObj( Title::makeTitleSafe( - 1, 'Contributors/' . $title ), wfMsg( 'mostrevisors-viewcontributors' ) ) . ")";
			return( "<li>{$link}</li>\n" );
		} else {
			return( "<!-- Invalid title " . htmlspecialchars( $row->title ) . " in namespace " . htmlspecialchars( $row->page_namespace ) . " -->\n" );
		}
	}

	private function makeLimitLinks() {
		global $wgLang;

		$limits = array( 10, 20, 30, 50, 100, 150 );
		foreach ( $limits as $limit ) {
			if ( $limit != $this->limit ) {
				$links[] = $this->makeSelfLink( $wgLang->formatNum( $limit ), 'limit', $limit );
			} else {
				$links[] = (string)$limit;
			}
		}
		return( wfMsgHtml( 'mostrevisors-limitlinks', $wgLang->pipeList( $links ) ) );
	}

	private function makeRedirectToggle() {
		$label = wfMsgHtml( $this->redirects ? 'mostrevisors-hideredir' : 'mostrevisors-showredir' );
		return $this->makeSelfLink( $label, 'redirects', (int)!$this->redirects );
	}

	private function makeSelfLink( $label, $oname = false, $oval = false ) {
		global $wgUser;
		$skin =& $wgUser->getSkin();
		$self = $this->getTitle();
		$attr['limit'] = $this->limit;
		$attr['namespace'] = $this->namespace;
		if ( !$this->redirects )
		$attr['redirects'] = 0;
		if ( $oname )
		$attr[$oname] = $oval;
		foreach ( $attr as $aname => $aval )
		$attribs[] = "{$aname}={$aval}";
		return $skin->makeKnownLinkObj( $self, $label, implode( '&', $attribs ) );
	}

	private function makeNamespaceForm() {
		$self = $this->getTitle();
		$form  = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
		$form .= Xml::label( wfMsg( 'mostrevisors-namespace' ), 'namespace' ) . '&#160;';
		$form .= Xml::namespaceSelector( $this->namespace, 'all' );
		$form .= Html::Hidden( 'limit', $this->limit );
		$form .= Html::Hidden( 'redirects', $this->redirects );
		$form .= Xml::submitButton( wfMsg( 'mostrevisors-submit' ) ) . '</form>';
		return $form;
	}
}
