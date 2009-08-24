<?php

class CodeReleaseNotes extends CodeView {
	function __construct( $repoName ) {
		global $wgRequest, $wgWikiSVN, $IP;
		parent::__construct( $repoName );
		$this->mRepo = CodeRepository::newFromName( $repoName );
		$this->mPath = htmlspecialchars( trim( $wgRequest->getVal( 'path' ) ) );
		if ( strlen( $this->mPath ) && $this->mPath[0] !== '/' ) {
			$this->mPath = "/{$this->mPath}"; // make sure this is a valid path
		}
		$this->mPath = preg_replace( '/\/$/', '', $this->mPath ); // kill last slash
		$this->mStartRev = $wgRequest->getIntOrNull( 'startrev' );
		$this->mEndRev = $wgRequest->getIntOrNull( 'endrev' );
		# Default start rev to last live one if possible
		if ( !$this->mStartRev && $this->mRepo && $this->mRepo->getName() == $wgWikiSVN ) {
			$this->mStartRev = SpecialVersion::getSvnRevision( $IP ) + 1;
		}
	}

	function execute() {
		if ( !$this->mRepo ) {
			$view = new CodeRepoListView();
			$view->execute();
			return;
		}
		$this->showForm();
		# Sanity/performance check...
		$lastRev = $this->mRepo->getLastStoredRev();
		if ( $this->mStartRev < ( $lastRev - 3000 ) )
			$this->mStartRev = NULL;
		# Show notes if we have at least a starting revision
		if ( $this->mStartRev ) {
			$this->showReleaseNotes();
		}
	}

	protected function showForm() {
		global $wgOut, $wgScript, $wgUser;
		$special = SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/releasenotes' );
		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'action' => $wgScript, 'method' => 'get' ) ) .
			"<fieldset><legend>" . wfMsgHtml( 'code-release-legend' ) . "</legend>" .
				Xml::hidden( 'title', $special->getPrefixedDBKey() ) . '<b>' .
				Xml::inputlabel( wfMsg( "code-release-startrev" ), 'startrev', 'startrev', 10, $this->mStartRev ) .
				'</b>&nbsp;' .
				Xml::inputlabel( wfMsg( "code-release-endrev" ), 'endrev', 'endrev', 10, $this->mEndRev ) .
				'&nbsp;' .
				Xml::inputlabel( wfMsg( "code-pathsearch-path" ), 'path', 'path', 45, $this->mPath ) .
				'&nbsp;' .
				Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . "\n" .
			"</fieldset>" . Xml::closeElement( 'form' )
		);
	}

	protected function showReleaseNotes() {
		global $wgOut;
		$linker = new CodeCommentLinkerWiki( $this->mRepo );
		$dbr = wfGetDB( DB_SLAVE );
		if ( $this->mEndRev ) {
			$where = 'cr_id BETWEEN ' . intval( $this->mStartRev ) . ' AND ' . intval( $this->mEndRev );
		} else {
			$where = 'cr_id >= ' . intval( $this->mStartRev );
		}
		if ( $this->mPath ) {
			$where .= ' AND (cr_path LIKE ' . $dbr->addQuotes( $dbr->escapeLike( "{$this->mPath}/" ) . '%' );
			$where .= ' OR cr_path = ' . $dbr->addQuotes( $this->mPath ) . ')';
		}
		# Select commits within this range...
		$res = $dbr->select( array( 'code_rev', 'code_tags' ),
			array( 'cr_message', 'cr_author', 'cr_id', 'ct_tag AS rnotes' ),
			array(
				'cr_repo_id' => $this->mRepo->getId(), // this repo
				"cr_status NOT IN('reverted','deferred','fixme')", // not reverted/deferred/fixme
				"cr_message != ''",
				$where // in range
			),
			__METHOD__,
			array( 'ORDER BY' => 'cr_id DESC' ),
			array( 'code_tags' => array( 'LEFT JOIN', # Tagged for release notes?
				'ct_repo_id = cr_repo_id AND ct_rev_id = cr_id AND ct_tag = "release-notes"' )
			)
		);
		$wgOut->addHTML( '<ul>' );
		# Output any relevant seeming commits...
		while ( $row = $dbr->fetchObject( $res ) ) {
			$summary = htmlspecialchars( $row->cr_message );
			# Add this commit summary if needed.
			if ( $row->rnotes || $this->isRelevant( $summary ) ) {
				# Keep it short if possible...
				$summary = $this->shortenSummary( $summary );
				# Anything left? (this can happen with some heuristics)
				if ( $summary ) {
					$summary = str_replace( "\n", "<br/>", $summary ); // Newlines -> <br/>
					$wgOut->addHTML( "<li>" );
					$wikiText = $linker->link( $summary ) . " ''(" . htmlspecialchars( $row->cr_author ) .
						', ' . $linker->link( "r{$row->cr_id}" ) . ")''";
					$wgOut->addWikiText( $wikiText, false );
					$wgOut->addHTML( "</li>\n" );
				}
			}
		}
		$wgOut->addHTML( '</ul>' );
	}

	private function shortenSummary( $summary, $first = true ) {
		# Astericks often used for point-by-point bullets
		if ( preg_match( '/(^|\n) ?\*/', $summary ) ) {
			$blurbs = explode( '*', $summary );
		# Double newlines separate importance generally
		} else if ( strpos( $summary, "\n\n" ) !== false ) {
			$blurbs = explode( "\n\n", $summary );
		} else {
			return trim( $summary );
		}
		$blurbs = array_map( 'trim', $blurbs ); # Clean up items
		$blurbs = array_filter( $blurbs ); # Filter out any garbage
		# Doesn't start with '*' and has some length?
		# If so, then assume that the top bit is important.
		if ( count( $blurbs ) ) {
			$header = strpos( ltrim( $summary ), '*' ) !== 0 && str_word_count( $blurbs[0] ) >= 5;
		} else {
			$header = false;
		}
		# Keep it short if possible...
		if ( count( $blurbs ) > 1 ) {
			$summary = array();
			foreach ( $blurbs as $blurb ) {
				# Always show the first bit
				if ( $header && $first && count( $summary ) == 0 ) {
					$summary[] = $this->shortenSummary( $blurb, true );
				# Is this bit important? Does it mention a revision?
				} else if ( $this->isRelevant( $blurb ) || preg_match( '/\br(\d+)\b/', $blurb ) ) {
					$bit = $this->shortenSummary( $blurb, false );
					if ( $bit ) $summary[] = $bit;
				}
			}
			$summary = implode( "\n", $summary );
		} else {
			$summary = implode( "\n", $blurbs );
		}
		return $summary;
	}

	// Quick relevance tests (these *should* be over-inclusive a little if anything)
	private function isRelevant( $summary, $whole = true ) {
		# Fixed a bug? Mentioned a config var?
		if ( preg_match( '/\b(bug #?(\d+)|\$[we]g[0-9a-z]{3,50})\b/i', $summary ) )
			return true;
		# Sanity check: summary cannot be *too* short to be useful
		$words = str_word_count( $summary );
		if ( mb_strlen( $summary ) < 40 || $words <= 5 )
			return false;
		# All caps words (like "BREAKING CHANGE"/magic words)?
		if ( preg_match( '/\b[A-Z]{6,30}\b/', $summary ) )
			return true;
		# Random keywords
		if ( preg_match( '/\b(wiki|HTML\d|CSS\d|UTF-?8|(Apache|PHP|CGI|Java|Perl|Python|\w+SQL) ?\d?\.?\d?)\b/i', $summary ) )
			return true;
		# Are we looking at the whole summary or an aspect of it?
		if ( $whole ) {
			return preg_match( '/(^|\n) ?\*/', $summary ); # List of items?
		} else {
			return true;
		}
	}
}
