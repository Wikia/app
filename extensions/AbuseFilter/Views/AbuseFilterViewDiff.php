<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

class AbuseFilterViewDiff extends AbuseFilterView {
	var $mOldVersion = null;
	var $mNewVersion = null;
	var $mFilter = null;

	function show() {
		$show = $this->loadData();

		global $wgOut, $wgUser, $wgLang;
		$this->mSkin = $wgUser->getSkin();

		$links = array();
		if ( $this->mFilter ) {
			$links['abusefilter-history-backedit'] = $this->getTitle( $this->mFilter );
			$links['abusefilter-diff-backhistory'] = $this->getTitle( 'history/' . $this->mFilter );
		}

		foreach ( $links as $msg => $title ) {
			$links[$msg] = $this->mSkin->link( $title, wfMsgExt( $msg, 'parseinline' ) );
		}

		$backlinks = $wgLang->pipeList( $links );
		$wgOut->addHTML( Xml::tags( 'p', null, $backlinks ) );

		if ( $show )
			$wgOut->addHTML( $this->formatDiff() );
	}

	function loadData() {
		$oldSpec = $this->mParams[3];
		$newSpec = $this->mParams[4];
		$this->mFilter = $this->mParams[1];

		$this->mOldVersion = $this->loadSpec( $oldSpec, $newSpec );
		$this->mNewVersion = $this->loadSpec( $newSpec, $oldSpec );

		if ( is_null( $this->mOldVersion ) || is_null( $this->mNewVersion ) ) {
			global $wgOut;
			$wgOut->addWikiMsg( 'abusefilter-diff-invalid' );
			return false;
		}

		return true;
	}

	function loadSpec( $spec, $otherSpec ) {
		static $dependentSpecs = array( 'prev', 'next' );
		static $cache = array();

		global $wgUser;

		if ( AbuseFilter::filterHidden( $this->mFilter ) &&
				!$wgUser->isAllowed( 'abusefilter-modify' ) ) {
			return null;
		}

		if ( isset( $cache[$spec] ) )
			return $cache[$spec];

		$dbr = wfGetDB( DB_SLAVE );
		if ( is_numeric( $spec ) ) {
			$row = $dbr->selectRow(
				'abuse_filter_history',
				'*',
				array( 'afh_id' => $spec, 'afh_filter' => $this->mFilter ),
				__METHOD__
			);
		} elseif ( $spec == 'cur' ) {
			$row = $dbr->selectRow(
				'abuse_filter_history',
				'*',
				array( 'afh_filter' => $this->mFilter ),
				__METHOD__,
				array( 'ORDER BY' => 'afh_timestamp desc' )
			);
		} elseif ( $spec == 'prev' && !in_array( $otherSpec, $dependentSpecs ) ) {
			// cached
			$other = $this->loadSpec( $otherSpec, $spec );

			$row = $dbr->selectRow(
				'abuse_filter_history',
				'*',
				array(
					'afh_filter' => $this->mFilter,
					'afh_id<' . $dbr->addQuotes( $other['meta']['history_id'] ),
				),
				__METHOD__,
				array( 'ORDER BY' => 'afh_timestamp desc' )
			);
			if ( $other && !$row ) {
				$t = $this->getTitle(
					'history/' . $this->mFilter . '/item/' . $other['meta']['history_id'] );
				global $wgOut;
				$wgOut->redirect( $t->getFullURL() );
				return;
			}

		} elseif ( $spec == 'next' && !in_array( $otherSpec, $dependentSpecs ) ) {
			// cached
			$other = $this->loadSpec( $otherSpec, $spec );

			$row = $dbr->selectRow(
				'abuse_filter_history',
				'*',
				array(
					'afh_filter' => $this->mFilter,
					'afh_id>' . $dbr->addQuotes( $other['meta']['history_id'] ),
				),
				__METHOD__,
				array( 'ORDER BY' => 'afh_timestamp DESC' )
			);

			if ( $other && !$row ) {
				$t = $this->getTitle(
					'history/' . $this->mFilter . '/item/' . $other['meta']['history_id'] );
				global $wgOut;
				$wgOut->redirect( $t->getFullURL() );
				return;
			}
		}

		if ( !$row )
			return null;

		$data = $this->loadFromHistoryRow( $row );
		$cache[$spec] = $data;
		return $data;
	}

	function loadFromHistoryRow( $row ) {
		return array(
			'meta' => array(
				'history_id' => $row->afh_id,
				'modified_by' => $row->afh_user,
				'modified_by_text' => $row->afh_user_text,
				'modified' => $row->afh_timestamp,
			),
			'info' => array(
				'description' => $row->afh_public_comments,
				'flags' => $row->afh_flags,
				'notes' => $row->afh_comments,
			),
			'pattern' => $row->afh_pattern,
			'actions' => unserialize( $row->afh_actions ),
		);
	}

	function formatVersionLink( $timestamp, $history_id ) {
		global $wgLang, $wgUser;

		$sk = $wgUser->getSkin();

		$filter = $this->mFilter;
		$text = $wgLang->timeanddate( $timestamp );
		$title = $this->getTitle( "history/$filter/item/$history_id" );

		$link = $sk->link( $title, $text );

		return $link;
	}

	function formatDiff() {
		$oldVersion = $this->mOldVersion;
		$newVersion = $this->mNewVersion;

		// headings
		$oldLink = $this->formatVersionLink(
			$oldVersion['meta']['modified'],
			$oldVersion['meta']['history_id']
		);
		$newLink = $this->formatVersionLink(
			$newVersion['meta']['modified'],
			$newVersion['meta']['history_id']
		);

		$sk = $this->mSkin;
		$oldUserLink = $sk->userLink(
			$oldVersion['meta']['modified_by'],
			$oldVersion['meta']['modified_by_text']
		);
		$newUserLink = $sk->userLink(
			$newVersion['meta']['modified_by'],
			$newVersion['meta']['modified_by_text']
		);

		$headings = '';
		$headings .= Xml::tags( 'th', null,
						wfMsgExt( 'abusefilter-diff-item', 'parseinline' ) );
		$headings .= Xml::tags( 'th', null,
			wfMsgExt( 'abusefilter-diff-version',
				array( 'parseinline', 'replaceafter' ),
				array( $oldLink, $oldUserLink,
						$newVersion['meta']['modified_by_text'] )
			)
		);
		$headings .= Xml::tags( 'th', null,
			wfMsgExt( 'abusefilter-diff-version',
				array( 'parseinline', 'replaceafter' ),
				array( $newLink, $newUserLink )
			)
		);

		$headings = Xml::tags( 'tr', null, $headings );

		// Basic info
		$info = '';
		$info .= $this->getHeaderRow( 'abusefilter-diff-info' );
		$info .= $this->getSimpleRow(
			'abusefilter-edit-description',
			$oldVersion['info']['description'],
			$newVersion['info']['description'],
			'wikitext'
		);
		$info .= $this->getSimpleRow(
			'abusefilter-edit-flags',
			AbuseFilter::formatFlags( $oldVersion['info']['flags'] ),
			AbuseFilter::formatFlags( $newVersion['info']['flags'] )
		);

		$info .= $this->getMultiLineRow(
			'abusefilter-edit-notes',
			$oldVersion['info']['notes'],
			$newVersion['info']['notes']
		);

		// Pattern
		$info .= $this->getHeaderRow( 'abusefilter-diff-pattern' );
		$info .= $this->getMultiLineRow(
			'abusefilter-edit-rules',
			$oldVersion['pattern'],
			$newVersion['pattern'],
			'text'
		);

		// Actions
		$oldActions = $this->stringifyActions( $oldVersion['actions'] );
		$newActions = $this->stringifyActions( $newVersion['actions'] );

		$info .= $this->getHeaderRow( 'abusefilter-edit-consequences' );
		$info .= $this->getMultiLineRow(
			'abusefilter-edit-consequences',
			$oldActions,
			$newActions
		);

		$html = "<table class='mw-abusefilter-diff'>
		<thead>$headings</thead>
		<tbody>$info</tbody>
</table>";

		$html = Xml::tags( 'h2', null, wfMsgExt( 'abusefilter-diff-title', 'parseinline' ) ) . $html;

		return $html;
	}

	function stringifyActions( $actions ) {
		$lines = array();

		ksort( $actions );
		foreach ( $actions as $action => $parameters ) {
			$lines[] = AbuseFilter::formatAction( $action, $parameters );
		}

		if ( !count( $lines ) )
			$lines[] = '';

		return $lines;
	}

	function getHeaderRow( $msg ) {
		$html = wfMsgExt( $msg, 'parseinline' );
		$html = Xml::tags( 'th', array( 'colspan' => 3 ), $html );
		$html = Xml::tags( 'tr', array( 'class' => 'mw-abusefilter-diff-header' ), $html );

		return $html;
	}

	function getSimpleRow( $msg, $old, $new, $format = 'wikitext' ) {
		$row = '';

		$row .= Xml::tags( 'th', null, wfMsgExt( $msg, 'parseinline' ) );

		$oldClass = $newClass = 'mw-abusefilter-diff-context';
		if ( trim( $old ) != trim( $new ) ) {
			$oldClass = 'mw-abusefilter-diff-removed';
			$newClass = 'mw-abusefilter-diff-added';
		}

		if ( $format == 'wikitext' ) {
			global $wgOut;
			$old = $wgOut->parseInline( $old );
			$new = $wgOut->parseInline( $new );
		}

		if ( $format == 'text' ) {
			$old = htmlspecialchars( $old );
			$new = htmlspecialchars( $new );
		}

		$row .= Xml::tags( 'td', array( 'class' => $oldClass ), $old );
		$row .= Xml::tags( 'td', array( 'class' => $newClass ), $new );

		return Xml::tags( 'tr', null, $row ) . "\n";
	}

	function getMultiLineRow( $msg, $old, $new ) {
		if ( !is_array( $old ) )
			$old = explode( "\n", $old );
		if ( !is_array( $new ) )
			$new = explode( "\n", $new );

		if ( $old == $new ) {
			$old = implode( "<br />\n", $old );
			$new = implode( "<br />\n", $new );
			return $this->getSimpleRow( $msg, $old, $new, 'text' );
		}

		$row = '';
		$row .= Xml::tags( 'th', null, wfMsgExt( $msg, 'parseinline' ) );

		$diff = new Diff( $old, $new );
		$formatter = new TableDiffFormatter();
		$formattedDiff = $formatter->format( $diff );
		$formattedDiff =
			"<table class='mw-abusefilter-diff-multiline'><tbody>$formattedDiff</tbody></table>";
		$row .= Xml::tags( 'td', array( 'colspan' => 2 ), $formattedDiff );

		return Xml::tags( 'tr', null, $row ) . "\n";
	}
}
