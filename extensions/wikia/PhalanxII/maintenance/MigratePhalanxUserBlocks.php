<?php

use Wikia\DependencyInjection\Injector;

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

/**
 * Cleanup infinite Phalanx username blocks
 *
 * Script to close the accounts for permanent Phalanx username blocks
 * older than three months and delete the relevant Phalanx block.
 */
class MigratePhalanxUserBlocks extends Maintenance {
	private $batchSize = 1000;
	private $curBlockId = 0;
	private $dryRun = false;

	public function __construct() {
		parent::__construct();
		$this->addOption( 'dry-run', "Perform a dry run, don't close any accounts" );
	}

	public function execute() {
		global $wgExternalSharedDB;

		$this->dryRun = $this->getOption( 'dry-run', false );

		$this->setCurrentUser();

		do {
			$userBlocks = $this->getUserBlocks();

			if ( empty( $userBlocks ) ) {
				break;
			}

			$blockIdsClosed = $this->closeAccounts( $userBlocks );

			$this->deletePhalanxBlocks( $blockIdsClosed );

			// Make sure slaves are caught up before running another delete query
			// to minimise lag just in case
			wfWaitForSlaves( $wgExternalSharedDB );

			$this->output( count( $blockIdsClosed ) . " user accounts closed.\n" );
		} while ( !empty( $userBlocks ) );

		$this->reloadPhalanxData();
	}

	private function getUserBlocks() {
		$dbr = $this->getPhalanxDB();

		$userBlocks = [];

		$res = $dbr->select(
			'phalanx',
			[ 'p_id', 'p_text' ],
			[
				'p_type' => 8,
				'p_exact' => 1,
				'p_regex' => 0,
				'p_expire IS NULL',
				'p_timestamp < ' . $dbr->addQuotes( date( 'YmdHis', strtotime( '-3 months' ) ) ),
				'p_id > ' . $dbr->addQuotes( $this->curBlockId ),
			],
			__METHOD__,
			[
				'LIMIT' => $this->batchSize,
			]
		);

		$blockId = 0;
		foreach ( $res as $row ) {
			$blockId = $row->p_id;
			if ( !empty( $row->p_text ) && !IP::isIPAddress( $row->p_text ) ) {
				$userBlocks[$blockId] = $row->p_text;
			}
		}

		$this->curBlockId = $blockId;

		return $userBlocks;
	}

	private function closeAccounts( $userBlocks ) {
		$blockIdsClosed = [];

		if ( empty( $userBlocks ) ) {
			return $blockIdsClosed;
		}

		foreach ( $userBlocks as $blockId => $userName ) {
			$userObj = User::newFromName( $userName );

			if ( $userObj instanceof User && $userObj->getId() != 0 ) {
				if ( !$this->isClosed( $userObj ) ) {
					$success = $this->closeUserAccount( $userObj );
					if ( !$success ) {
						continue;
					}
				}

				$blockIdsClosed[] = $blockId;
			} else {
				$this->output( "User block {$userName} for ID {$blockId} does not match an existing user!\n" );
			}
		}

		return $blockIdsClosed;
	}

	private function closeUserAccount( User $userObj ) {
		$this->output( "Closing account {$userObj->getName()} ... " );

		$closeReason = 'Closing perma Phalanx blocked accounts';
		$statusMsgOne = '';
		$statusMsgTwo = '';
		$keepEmail = true;

		if ( !$this->dryRun ) {
			$success = EditAccount::closeAccount( $userObj, $closeReason, $statusMsgOne, $statusMsgTwo, $keepEmail );
		} else {
			$this->output( "skipped (dry run)\n" );
			return true;
		}

		if ( !$success ) {
			$this->output( "failed\n" );
			return false;
		}

		$this->output( "success\n" );
		return true;
	}

	private function deletePhalanxBlocks( $blockIds ) {
		if ( $this->dryRun ) {
			return true;
		}

		$dbw = $this->getPhalanxDB( DB_MASTER );

		return $dbw->delete(
			'phalanx',
			[
				'p_id' => $blockIds,
			],
			__METHOD__
		);
	}

	private function reloadPhalanxData() {
		$this->output( 'Reloading Phalanx data ... ' );
		if ( $this->dryRun ) {
			$this->output( "skipped (dry run)\n" );
			return;
		}

		PhalanxHooks::notifyPhalanxService( [] );
	}

	private function isClosed( User $user ) {
		return (bool)$user->getGlobalFlag( 'disabled', false );
	}

	private function setCurrentUser() {
		global $wgUser;

		$wgUser = User::newFromName( 'Fandom' );
	}

	private function getPhalanxDB( $db = DB_SLAVE ) {
		global $wgExternalSharedDB;
		return wfGetDB( $db, [], $wgExternalSharedDB );
	}
}

$maintClass = 'MigratePhalanxUserBlocks';
require_once RUN_MAINTENANCE_IF_MAIN;
