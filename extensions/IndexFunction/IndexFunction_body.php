<?php
/* TODO:
 * Memcached
 * Warnings for API edit
 * Better documentation
*/

class IndexFunction {
	var $mTo = array(); // An array of titles for pages being indexed
	var $mFrom = null; // A title object representing the index-title

	function __construct() {}

	// Constructor for a known index-title
	public static function newFromTitle( Title $indextitle ) {
		$ns = $indextitle->getNamespace();
		$t = $indextitle->getDBkey();
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select( 'indexes', 'in_from',
			array( 'in_namespace' => $ns, 'in_title' => $t ),
			__METHOD__
		);

		if ( !$res->numRows() ) {
			return null;
		}

		$ind = new IndexFunction();
		$ids = array();

		foreach ( $res as $row ) {
			$ids[] = $row->in_from;
		}

		$ind->mTo = Title::newFromIDs( $ids );
		$ind->mFrom = $indextitle;

		return $ind;
	}

	// Constructor for known target
	public static function newFromTarget( Title $target ) {
		$pageid = $target->getArticleID();
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select( 'indexes', array( 'in_namespace', 'in_title' ),
			array( 'in_from' => $pageid ),
			__METHOD__
		);

		if ( !$res->numRows() ) {
			return null;
		}

		$ind = new IndexFunction();
		$row = $res->fetchRow();
		$ind->mFrom = Title::makeTitle( $row->in_namespace, $row->in_title );

		return $ind;
	}

	public function getIndexTitle() {
		return $this->mFrom;
	}

	public function getTargets() {
		if ( $this->mTo ) {
			return $this->mTo;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$ns = $this->mFrom->getNamespace();
		$t = $this->mFrom->getDBkey();

		$res = $dbr->select( 'indexes', 'in_from',
			array( 'in_namespace' => $ns, 'in_title' => $t ),
			__METHOD__
		);

		$ids = array();

		foreach ( $res as $row ) {
			$ids[] = $row->in_from;
		}

		$this->mTo = Title::newFromIDs( $ids );

		return $this->mTo;
	}

	// Makes an HTML <ul> list of targets
	public function makeTargetList() {
		global $wgUser;

		$sk = $wgUser->getSkin();
		$targets = $this->getTargets();
		$list = Xml::openElement( 'ul' );

		foreach ( $targets as $t ) {
			$link = $sk->link( $t, $t->getPrefixedText(), array(), array(), array( 'known', 'noclasses' ) );
			$list .= Xml::tags( 'li', null, $link );
		}

		$list .= Xml::CloseElement( 'ul' );

		return $list;
	}

	// Returns true if a redirect should go to a special page
	// ie - if there are multiple targets
	public function useSpecialPage() {
		if ( !$this->mTo ) {
			$this->getTargets();
		}

		return count( $this->mTo ) > 1;
	}
}

class IndexFunctionHooks {
	// Makes "Go" searches for an index title go directly to their target
	static function redirectSearch( $term, &$title ) {
		$title = Title::newFromText( $term );

		if ( is_null( $title ) ) {
			return true;
		}

		$index = IndexFunction::newFromTitle( $title );

		if ( !$index ) {
			return true;
		} elseif ( $index->useSpecialPage() ) {
			$title = SpecialPage::getTitleFor( 'Index', $title->getPrefixedText() );
		} else {
			$targets = $index->getTargets();
			$title = $targets[0];
		}

		return false;
	}

	// Make indexes work like redirects
	static function doRedirect( &$title, &$request, & $ignoreRedirect, &$target, &$article ) {
		if ( $article->exists() ) {
			return true;
		}

		$index = IndexFunction::newFromTitle( $title );

		if ( !$index ) {
			return true;
		} elseif ( $index->useSpecialPage() ) {
			$target = SpecialPage::getTitleFor( 'Index', $title->getPrefixedText() );
			$target = $t->getFullURL();
		} else {
			$targets = $index->getTargets();
			$target = $targets[0];
		}

		$ignoreRedirect = false;

		return true;
	}

	// Turn links to indexes into blue links
	static function blueLinkIndexes( $skin, $target, $options, &$text, &$attribs, &$ret ) {
		if ( in_array( 'known', $options ) ) {
			return true;
		}

		$index = IndexFunction::newFromTitle( $target );

		if ( !$index ) {
			return true;
		}

		$attribs['class'] = str_replace( 'new', 'mw-index', $attribs['class'] );
		$attribs['href'] = $target->getLinkUrl();
		$attribs['title'] = $target->getEscapedText();

		return true;
	}

	// Function called to render the parser function
	// Output is an empty string unless there are errors
	static function indexRender( &$parser ) {
		if ( !isset( $parser->mOutput->mIndexes ) ) {
			$parser->mOutput->mIndexes = array();
		}

		static $indexCount = 0;
		static $indexes = array();

		$args = func_get_args();
		unset( $args[0] );

		if ( $parser->mOptions->getIsPreview() ) {
			# This is kind of hacky, but it seems that we only
			# know if its a preview during parse, not when its
			# done, which is when it matters for this
			$parser->mOutput->setProperty( 'preview', 1 );
		}

		$errors = array();
		$pageid = $parser->mTitle->getArticleID();

		foreach ( $args as $name ) {
			$t = Title::newFromText( $name );

			if ( is_null( $t ) ) {
				$errors[] = wfMsg( 'indexfunc-badtitle', $name );
				continue;
			}

			$ns =  $t->getNamespace();
			$dbkey = $t->getDBkey();
			$entry = array( $ns, $dbkey );

			if ( in_array( $entry, $indexes ) ) {
				continue;
			}

			if ( $t->exists() ) {
				$errors[] = wfMsg( 'indexfunc-index-exists', $name );
				continue;
			}
			$indexCount++;
			$parser->mOutput->mIndexes[$indexCount] =  $entry;
		}

		if ( !$errors ) {
			return '';
		}

		$out = Xml::openElement( 'ul', array( 'class' => 'error' ) );

		foreach ( $errors as $e ) {
			$out .= Xml::element( 'li', null, $e );
		}

		$out .= Xml::closeElement( 'ul' );

		return $out;
	}

	// Called after parse, updates the index table
	static function doIndexes( $out, $parseroutput ) {
		if ( !isset( $parseroutput->mIndexes ) ) {
			$parseroutput->mIndexes = array();
		}

		if ( $parseroutput->getProperty( 'preview' ) ) {
			return true;
		}

		$pageid = $out->getTitle()->getArticleID();
		$dbw = wfGetDB( DB_MASTER );

		$res = $dbw->select( 'indexes',
			array( 'in_namespace', 'in_title' ),
			array( 'in_from' => $pageid ),
			__METHOD__
		);

		$current = array();

		foreach ( $res as $row ) {
			$current[] = array( $row->in_namespace, $row->in_title );
		}

		$toAdd = wfArrayDiff2( $parseroutput->mIndexes, $current );
		$toRem = wfArrayDiff2( $current, $parseroutput->mIndexes );

		if ( $toAdd || $toRem ) {
			$dbw->begin( __METHOD__ );

			if ( $toRem ) {
				$delCond = "in_from = $pageid AND (";
				$parts = array();

				# Looking at Database::delete, it seems to turn arrays into AND statements
				# but we need to chain together groups of ANDs with ORs
				foreach ( $toRem as $entry ) {
					$parts[] = "(in_namespace = " . $entry[0] . " AND in_title = " . $dbw->addQuotes( $entry[1] ) . ")";
				}

				$delCond .= implode( ' OR ', $parts ) . ")";
				$dbw->delete( 'indexes', array( $delCond ), __METHOD__ );
			}

			if ( $toAdd ) {
				$ins = array();

				foreach ( $toAdd as $entry ) {
					$ins[] = array( 'in_from' => $pageid, 'in_namespace' => $entry[0], 'in_title' => $entry[1] );
				}

				$dbw->insert( 'indexes', $ins, __METHOD__ );
			}

			$dbw->commit( __METHOD__ );
		}
		return true;
	}

	// When deleting a page, delete all rows from the index table that point to it
	static function onDelete( &$article, &$user, $reason, $id ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'indexes', array( 'in_from' => $id ), __METHOD__ );

		return true;
	}

	// When creating an article, delete its title from the index table
	static function onCreate( &$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision ) {
		$t = $article->mTitle;
		$ns = $t->getNamespace();
		$dbkey = $t->getDBkey();
		$dbw = wfGetDB( DB_MASTER );

		$dbw->delete( 'indexes',
			array( 'in_namespace' => $ns, 'in_title' => $dbkey ),
			 __METHOD__
		);

		return true;
	}

	// Show a warning when editing an index-title
	static function editWarning( $editpage ) {
		$t = $editpage->mTitle;
		$index = IndexFunction::newFromTitle( $t );

		if ( !$index ) {
			return true;
		}

		$list = $index->makeTargetList();
		$c = count( $index->getTargets() );
		$warn = wfMsgExt( 'indexfunc-editwarning', array( 'parsemag' ), $list, $c );
		$editpage->editFormTextTop .= "<span class='error'>$warn</span>";

		return true;
	}

	static function afterMove( &$form, &$orig, &$new ) {
		global $wgOut;

		$index = IndexFunction::newFromTitle( $new );

		if ( !$index ) {
			return true;
		}

		$c = count( $index->getTargets() );
		$list = $index->makeTargetList();
		$newns = $new->getNamespace();
		$newdbk = $new->getDBkey();
		$dbw = wfGetDB( DB_MASTER );

		$dbw->delete( 'indexes',
			array( 'in_namespace' => $newns, 'in_title' => $newdbk ),
			 __METHOD__
		);

		$msg = wfMsgExt( 'indexfunc-movewarn', array( 'parsemag' ), $new->getPrefixedText(), $list, $c );
		$msg = "<span class='error'>$msg</span>";

		$wgOut->addHTML( $msg );

		return true;
	}
}
