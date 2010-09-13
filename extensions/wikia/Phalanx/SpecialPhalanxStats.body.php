<?php

class PhalanxStats extends UnlistedSpecialPage {
	function __construct( ) {
		parent::__construct( 'PhalanxStats', 'phalanx' );
	}

	function execute( $par ) {
		global $wgOut, $wgLang, $wgUser, $wgRequest;

		wfLoadExtensionMessages( 'Phalanx' );

		#set base title
		$wgOut->setPageTitle( wfMsg('phalanx-stats-title') );

		global $wgExtensionsPath, $wgStyleVersion;
		$wgOut->addStyle( "$wgExtensionsPath/wikia/Phalanx/css/Phalanx.css?$wgStyleVersion" );

		// check restrictions
		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		if ( empty( $par ) ) {
			$par = $wgRequest->getInt( 'blockId' );
		}

		// give up if no block ID is given
		if ( empty( $par ) ) {
			return true;
		}

		#we have a valid id, change title to use it
		$wgOut->setPageTitle( wfMsg('phalanx-stats-title') . ' #' . $par);

		$block = array();
		$block = Phalanx::getFromId( intval($par) );

		if ( empty( $block ) ) {
			$wgOut->addWikiMsg( 'phalanx-stats-block-notfound' );
			return true;
		}

		// process block data for display
		$block['author_id'] = User::newFromId( $block['author_id'] )->getName();
		$block['timestamp'] = $wgLang->timeanddate( $block['timestamp'] );
		if ( $block['expire'] == null ) {
			$block['expire'] = 'infinte';
		} else {
			$block['expire'] = $wgLang->timeanddate( $block['expire'] );
		}
		$block['exact'] = $block['exact'] ? 'Yes' : 'No';
		$block['regex'] = $block['regex'] ? 'Yes' : 'No';
		$block['case'] = $block['case'] ? 'Yes' : 'No';
		$block['type'] = implode( ', ', Phalanx::getTypeNames( $block['type'] ) );
		$block['lang'] = empty($block['lang']) ? '*' : $block['lang'];

		#pull these out of the array, so they dont get used in the top rows
		$block2['text'] = $block['text']; unset($block['text']);
		$block2['reason'] = $block['reason']; unset($block['reason']);
		
		//TODO: add i18n
		$headers = array(
			wfMsg('phalanx-stats-table-id'),
			wfMsg('phalanx-stats-table-user'),
			wfMsg('phalanx-stats-table-type'),
			wfMsg('phalanx-stats-table-create'),
			wfMsg('phalanx-stats-table-expire'),
			wfMsg('phalanx-stats-table-exact'),
			wfMsg('phalanx-stats-table-regex'),
			wfMsg('phalanx-stats-table-case'),
			wfMsg('phalanx-stats-table-language'),
		);

		$html = '';

		$tableAttribs = array(
			'border' => 1,
			'cellpadding' => 4,
			'cellspacing' => 0,
			'style' => "font-family:monospace;",
		);

		#use magic to build it
		$table = Xml::buildTable( array( $block ), $tableAttribs, $headers );
		#rip off bottom
		$table = str_replace("</table>", "", $table);
		#add some stuff
		$table .= "<tr><th>".wfMsg('phalanx-stats-table-text')."</th><td colspan='8'>" . htmlspecialchars($block2['text']) . "</td></tr>";
		$table .= "<tr><th>".wfMsg('phalanx-stats-table-reason')."</th><td colspan='8'>{$block2['reason']}</td></tr>";
		#seal it back up
		$table .= "</table>";

		$html .=  $table . "\n";

		$phalanxUrl = Title::newFromText( 'Phalanx', NS_SPECIAL )->getFullUrl( array( 'id' => $block['id'] ) );
		$html .= " &bull; <a class='modify' href='{$phalanxUrl}'>" . wfMsg('phalanx-link-modify') . "</a><br/>\n";

		$html .=  "<br/>\n";
		$wgOut->addHTML( $html );

		$pager = new PhalanxStatsPager( $par );

		$html = '';
		$html .= $pager->getNavigationBar();
		$html .= $pager->getBody();
		$html .= $pager->getNavigationBar();

		$wgOut->addHTML( $html );
	}
}

class PhalanxStatsPager extends ReverseChronologicalPager {
	public function __construct( $id ) {
		global $wgExternalSharedDB;

		parent::__construct();
		$this->mDb = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$this->mBlockId = (int) $id;

	}

	function getQueryInfo() {
		$query['tables'] = 'phalanx_stats';
		$query['fields'] = '*';
		$query['conds'] = array(
			'ps_blocker_id' => $this->mBlockId,
		);

		return $query;
	}

	function getPagingQueries() {
		$queries = parent::getPagingQueries();

		foreach ( $queries as $type => $query ) {
			if ( $query === false ) {
				continue;
			}
			$query['blockId'] = $this->mBlockId;
			$queries[$type] = $query;
		}

		return $queries;
	}

	function getIndexField() {
		return 'ps_timestamp';
	}

	function getStartBody() {
		return '<ul id="phalanx-block-' . $this->mBlockId . '-stats">';
	}

	function getEndBody() {
		return '</ul>';
	}

	function formatRow( $row ) {
		global $wgLang;

		wfLoadExtensionMessages( 'Phalanx' );

		$type = implode( Phalanx::getTypeNames( $row->ps_blocker_type ) );
		
		$username = $row->ps_blocked_user;

		$timestamp = $wgLang->timeanddate( $row->ps_timestamp );

		$oWiki = WikiFactory::getWikiById( $row->ps_wiki_id );
		$url = $oWiki->city_url;

		$html = '<li>';
		$html .= wfMsgExt( 'phalanx-stats-row', array('parseinline'), $type, $username, $url, $timestamp );
		$html .= '</li>';

		return $html;
	}
}
