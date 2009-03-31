<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class ValidationStatistics extends IncludableSpecialPage
{
	function __construct() {
		IncludableSpecialPage::IncludableSpecialPage( 'ValidationStatistics' );
		wfLoadExtensionMessages( 'ValidationStatistics' );
		wfLoadExtensionMessages( 'FlaggedRevs' );
	}

	function execute( $par ) {
		global $wgRequest, $wgUser, $wgOut, $wgLang, $wgContLang, $wgFlaggedRevsNamespaces;
		$this->setHeaders();
		$this->skin = $wgUser->getSkin();
		$this->db = wfGetDB( DB_SLAVE );

		$this->maybeUpdate();

		$ec = $this->getEditorCount();
		$rc = $this->getReviewerCount();

		$wgOut->addWikiText( wfMsgExt( 'validationstatistics-users', array( 'parsemag' ), 
			$wgLang->formatnum( $ec ), $wgLang->formatnum( $rc ) ) );

		if( !$this->readyForQuery() ) {
			return false;
		}

		$wgOut->addWikiText( wfMsg('validationstatistics-table') );
		$wgOut->addHTML( Xml::openElement( 'table', array( 'class' => 'wikitable flaggedrevs_stats_table' ) ) );
		$wgOut->addHTML( "<tr>\n" );
		// Headings (for a positive grep result):
		// validationstatistics-ns, validationstatistics-total, validationstatistics-stable,
		// validationstatistics-latest, validationstatistics-synced, validationstatistics-old
		$msgs = array( 'ns', 'total', 'stable', 'latest', 'synced', 'old' ); // our headings
		foreach( $msgs as $msg ) {
			$wgOut->addHTML( '<th>' . wfMsgExt("validationstatistics-$msg",array('parseinline')) . '</th>' );
		}
		$wgOut->addHTML( "</tr>\n" );

		foreach( $wgFlaggedRevsNamespaces as $namespace ) {
			$row = $this->db->selectRow( 'flaggedrevs_stats', '*', array('namespace' => $namespace) );
			$NsText = $wgContLang->getFormattedNsText( $row->namespace );
			$NsText = $NsText ? $NsText : wfMsgHTML('blanknamespace');

			$percRev = intval( $row->total ) == 0
				? '-' // devision by zero
				: $wgLang->formatnum( wfMsgExt( 'validationstatistics-nbr', array( 'escapenoentities' ),
					sprintf( '%4.2f', 100 * intval( $row->reviewed ) / intval( $row->total ) ) ) );
			$percLatest = intval( $row->total ) == 0
				? '-' // devision by zero
				: $wgLang->formatnum( wfMsgExt( 'validationstatistics-nbr', array( 'escapenoentities' ),
					sprintf( '%4.2f', 100 * intval( $row->synced ) / intval( $row->total ) ) ) );
			$percSynced = intval( $row->reviewed ) == 0
				? '-' // devision by zero
				: $wgLang->formatnum( wfMsgExt( 'validationstatistics-nbr', array( 'escapenoentities' ),
					sprintf( '%4.2f', 100 * intval( $row->synced ) / intval( $row->reviewed ) ) ) );
			$outdated = intval( $row->reviewed ) - intval( $row->synced );
			$outdated = $wgLang->formatnum( max( 0, $outdated ) ); // lag between queries

			$wgOut->addHTML( 
				"<tr align='center'>
					<td>" .
						htmlspecialchars( $NsText ) .
					"</td>
					<td>" .
						htmlspecialchars( $wgLang->formatnum( $row->total ) ) .
					"</td>
					<td>" .
						htmlspecialchars( $wgLang->formatnum( $row->reviewed ) . $wgContLang->getDirMark() ) . " <i>($percRev)</i>
					</td>
					<td>" .
						htmlspecialchars( $wgLang->formatnum( $row->synced ) . $wgContLang->getDirMark() ) . " <i>($percLatest)</i>
					</td>
					<td>" .
						$percSynced .
					"</td>
					<td>" .
					
						htmlspecialchars( $outdated ) .
					"</td>
				</tr>"
			);
		}
		$wgOut->addHTML( Xml::closeElement( 'table' ) );
	}

	protected function maybeUpdate() {
		global $wgFlaggedRevsStatsAge;
		if( !$wgFlaggedRevsStatsAge ) {
			return false;
		}
		$dbCache = wfGetCache( CACHE_DB );
		$key = wfMemcKey( 'flaggedrevs', 'statsUpdated' );
		$keySQL = wfMemcKey( 'flaggedrevs', 'statsUpdating' );
		// If a cache update is needed, do so asynchronously.
		// Don't trigger query while another is running.
		if( $dbCache->get( $key ) ) {
			wfDebugLog( 'ValidationStatistics', __METHOD__ . " skipping, got data" );
		} elseif( $dbCache->get( $keySQL ) ) {
			wfDebugLog( 'ValidationStatistics', __METHOD__ . " skipping, in progress" );
		} else {
			global $wgPhpCli;
			$ext = !empty($wgPhpCli) ? $wgPhpCli : 'php';
			$path = wfEscapeShellArg( dirname(__FILE__).'/../maintenance/updateStats.php' );
			$wiki = wfEscapeShellArg( wfWikiId() );
			$devNull = wfIsWindows() ? "NUL:" : "/dev/null";
			$commandLine = "$ext $path --wiki=$wiki > $devNull &";
			wfDebugLog( 'ValidationStatistics', __METHOD__ . " executing: $commandLine" );
			wfShellExec( $commandLine );
			return true;
		}
		return false;
	}
	
	protected function readyForQuery() {
		if( !$this->db->tableExists( 'flaggedrevs_stats' ) ) {
			return false;
		} else {
			return ( 0 != $this->db->selectField( 'flaggedrevs_stats', 'COUNT(*)' ) );
		}
	}
	
	protected function getEditorCount() {
		return $this->db->selectField( 'user_groups', 'COUNT(*)',
			array( 'ug_group' => 'editor' ),
			__METHOD__ );
	}

	protected function getReviewerCount() {
		return $this->db->selectField( 'user_groups', 'COUNT(*)',
			array( 'ug_group' => 'reviewer' ),
			__METHOD__ );
	}
}
