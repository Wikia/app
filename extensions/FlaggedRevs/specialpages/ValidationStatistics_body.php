<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}
wfLoadExtensionMessages( 'ValidationStatistics' );
wfLoadExtensionMessages( 'FlaggedRevs' );

class ValidationStatistics extends UnlistedSpecialPage
{
    function __construct() {
        SpecialPage::SpecialPage( 'ValidationStatistics' );
    }

    function execute( $par ) {
        global $wgRequest, $wgUser, $wgOut, $wgContLang, $wgFlaggedRevsNamespaces;
		$this->setHeaders();
		$this->skin = $wgUser->getSkin();
		$this->db = wfGetDB( DB_SLAVE );
		
		$this->maybeUpdate();
		
		$ec = $this->getEditorCount();
		$rc = $this->getReviewerCount();
		
		$wgOut->addWikiText( wfMsgExt('validationstatistics-users',array('parsemag'),$ec,$rc) );
		
		if( !$this->readyForQuery() ) {
			return false;
		}
		
		$wgOut->addWikiText( wfMsg('validationstatistics-table') );
		$wgOut->addHTML( "<table class='wikitable flaggedrevs_stats_table'>\n" );
		$wgOut->addHTML( "<tr>\n" );
		$msgs = array("ns","total","stable","latest","synced","old"); // our headings
		foreach( $msgs as $msg ) {
			$wgOut->addHTML( "<th>".wfMsg("validationstatistics-$msg")."</th>" );
		}
		$wgOut->addHTML( "</tr>\n" );
		
		foreach( $wgFlaggedRevsNamespaces as $namespace ) {
			$row = $this->db->selectRow( 'flaggedrevs_stats', '*', array('namespace' => $namespace) );
			$NsText = $wgContLang->getFormattedNsText( $row->namespace );
			$NsText = $NsText ? $NsText : wfMsgHTML('blanknamespace');
			
			$percRev = @sprintf( '%4.2f', 100*intval($row->reviewed)/intval($row->total) );
			$percLatest = @sprintf( '%4.2f', 100*intval($row->synced)/intval($row->total) );
			$percSynced = @sprintf( '%4.2f', 100*intval($row->synced)/intval($row->reviewed) );
			$outdated = intval($row->reviewed) - intval($row->synced);
			$outdated = max( 0, $outdated ); // lag between queries
			
			$wgOut->addHTML( "<tr align='center'>" );
			$wgOut->addHTML( "<td>$NsText</td>" );
			$wgOut->addHTML( "<td>{$row->total}</td>" );
			$wgOut->addHTML( "<td>{$row->reviewed} <i>($percRev%)</i></td>" );
			$wgOut->addHTML( "<td>{$row->synced} <i>($percLatest%)</i></td>" );
			$wgOut->addHTML( "<td>$percSynced%</td>" );
			$wgOut->addHTML( "<td>".$outdated."</td>" );
			$wgOut->addHTML( "</tr>" );
		}
		$wgOut->addHTML( "</table>" );
	}
	
	protected function maybeUpdate() {
		$dbCache = wfGetCache( CACHE_DB );
		$key = wfMemcKey( 'flaggedrevs', 'statsUpdated' );
		$keySQL = wfMemcKey( 'flaggedrevs', 'statsUpdating' );
		// If a cache update is needed, do so asynchronously.
		// Don't trigger query while another is running.
		if( $dbCache->get( $key ) ) {
			wfDebugLog( 'ValidationStatistic', __METHOD__ . " skipping, got data" );
		} elseif( $dbCache->get( $keySQL ) ) {
			wfDebugLog( 'ValidationStatistic', __METHOD__ . " skipping, in progress" );
		} else {
			$ext = strpos( $_SERVER['SCRIPT_NAME'], 'index.php5' ) === false ? 'php' : 'php5';
			$path = wfEscapeShellArg( dirname(__FILE__).'/../maintenance/updateStats.php' );
			$wiki = wfEscapeShellArg( wfWikiId() );
			$devNull = wfIsWindows() ? "NUL" : "/dev/null";
			$commandLine = "$ext $path --wiki=$wiki > $devNull &";
			wfDebugLog( 'ValidationStatistic', __METHOD__ . " executing: $commandLine" );
			exec( $commandLine );
		}
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
