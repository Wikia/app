<?php
/**
 * @file CheckpointCharlieWhitelistsEditor.php
 * @brief A simple whitelists editor for the CheckpointCharlie extension.
 * @author Michał ‘Mix’ Roszka <mix@wikia-inc.com>
 * @date Thursday, 7 August 2014 (created)
 */

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class CheckpointCharlieWhitelistsEditor extends Maintenance {

	protected $aCheckpointCharlieIPWhitelist = [];
	protected $aCheckpointCharlieSpecialPagesWhitelist = [];
	protected $bChanged = false;


	public function __construct() {
		parent::__construct();
		$this->addOption( 'show', 'Display whitelists.' );
		$this->addOption( 'ip-add', 'Add an IP address to the whitelist', false, true );
		$this->addOption( 'ip-remove', 'Remove an IP address from the whitelist.', false, true );
		$this->addOption( 'page-add', 'Add a page to the special pages whitelist.', false, true );
		$this->addOption( 'page-remove', 'Remove a page from the special pages whitelist.', false, true );
		$this->mDescription = 'A simple whitelists editor for the CheckpointCharlie extension.';
	}

	public function execute() {

		global $wgCheckpointCharlieIPWhitelist, $wgCheckpointCharlieSpecialPagesWhitelist;
		$this->aCheckpointCharlieIPWhitelist = $wgCheckpointCharlieIPWhitelist;
		$this->aCheckpointCharlieSpecialPagesWhitelist = $wgCheckpointCharlieSpecialPagesWhitelist;

		$sOut = '';

		if ( $this->hasOption( 'show' ) ) {
			$sOut .= "IP Whitelist\n\n" . implode( "\n", $this->aCheckpointCharlieIPWhitelist );
			$sOut .= "\n\nSpecial Pages Whitelist\n\n" . implode( "\n", $this->aCheckpointCharlieSpecialPagesWhitelist );
			$sOut .= "\n\n";
			$this->output( $sOut );
			return;
		}

		$sOption = $this->getOption( 'ip-add', null );
		if ( $sOption ) {
			$this->ipAdd( $sOption );
		}

		$sOption = $this->getOption( 'ip-remove', null );
		if ( $sOption ) {
			$this->ipRemove( $sOption );
		}

		$sOption = $this->getOption( 'page-add', null );
		if ( $sOption ) {
			$this->pageAdd( $sOption );
		}

		$sOption = $this->getOption( 'page-remove', null );
		if ( $sOption ) {
			$this->pageRemove( $sOption );
		}

		if ( $this->bChanged ) {
			$this->save();
		}
	}

	protected function ipAdd( $sIp ) {
		if ( false === array_search( $sIp, $this->aCheckpointCharlieIPWhitelist ) ) {
			$this->aCheckpointCharlieIPWhitelist[] = $sIp;
			$this->bChanged = true;
			$this->output( sprintf( "Added %s to the IP whitelist.\n", $sIp ) );
			return;
		}
		$this->output( sprintf( "%s is already on the IP whitelist.\n", $sIp ) );
	}

	protected function ipRemove( $sIp ) {
		$iKey = array_search( $sIp, $this->aCheckpointCharlieIPWhitelist );
		if ( false !== $iKey ) {
			unset( $this->aCheckpointCharlieIPWhitelist[$iKey] );
			$this->bChanged = true;
			$this->output( sprintf( "Removed %s from the IP whitelist.\n", $sIp ) );
			return;
		}
		$this->output( sprintf( "%s is not on the IP whitelist.\n", $sIp ) );
	}

	protected function pageAdd( $sPage ) {
		if ( false === array_search( $sPage, $this->aCheckpointCharlieSpecialPagesWhitelist ) ) {
			$this->aCheckpointCharlieSpecialPagesWhitelist[] = $sPage;
			$this->bChanged = true;
			$this->output( sprintf( "Added %s to the Special Pages whitelist.\n", $sPage ) );
			return;
		}
		$this->output( sprintf( "%s is already on the Special Pages whitelist.\n", $sPage ) );
	}

	protected function pageRemove( $sPage ) {
		$iKey = array_search( $sPage, $this->aCheckpointCharlieSpecialPagesWhitelist );
		if ( false !== $iKey ) {
			unset( $this->aCheckpointCharlieSpecialPagesWhitelist[$iKey] );
			$this->bChanged = true;
			$this->output( sprintf( "Removed %s from the Special Pages whitelist.\n", $sPage ) );
			return;
		}
		$this->output( sprintf( "%s is not on the Special Pages whitelist.\n", $sPage ) );
	}

	protected function save() {
		sort( $this->aCheckpointCharlieIPWhitelist, SORT_STRING );
		sort( $this->aCheckpointCharlieSpecialPagesWhitelist, SORT_STRING );
		WikiFactory::setVarByName( 'wgCheckpointCharlieIPWhitelist', WikiFactory::COMMUNITY_CENTRAL, $this->aCheckpointCharlieIPWhitelist );
		WikiFactory::setVarByName( 'wgCheckpointCharlieSpecialPagesWhitelist', WikiFactory::COMMUNITY_CENTRAL, $this->aCheckpointCharlieSpecialPagesWhitelist );
		WikiFactory::clearCache( WikiFactory::COMMUNITY_CENTRAL );
		$this->output( "Whitelists saved.\n" );
	}
}

$maintClass = 'CheckpointCharlieWhitelistsEditor';
require_once RUN_MAINTENANCE_IF_MAIN;

