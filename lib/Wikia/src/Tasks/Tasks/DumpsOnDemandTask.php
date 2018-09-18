<?php

namespace Wikia\Tasks\Tasks;

/**
 *
 * @package Wikia\Tasks\Tasks
 */
class DumpsOnDemandTask extends BaseTask {
	/**
	 * @throws \Exception
	 */
	public function dump() {
		global $wgExternalSharedDB;

		$this->info( "Searching for dump requests to process." );

		global $IP, $wgWikiaLocalSettingsPath, $wgMaxShellTime, $wgMaxShellFileSize;

		/**
		 * This prevents runBackups.php from timing out due to default values of $wgMaxShellTime used by wfShellExec()
		 *
		 * @see SUS-1395
		 */
		$wgMaxShellTime     = 0;
		$wgMaxShellFileSize	= 0;

		$wikiId = $this->getWikiId();

		$this->info( "Creating dumps for wiki #{$wikiId}." );

		$sCommand = sprintf( 'SERVER_ID=%d php %s/extensions/wikia/WikiFactory/Dumps/runBackups.php --conf %s --id=%d --both --s3 2>&1', \Wikia::COMMUNITY_WIKI_ID, $IP, $wgWikiaLocalSettingsPath, $wikiId );
		$this->info( "Running {$sCommand}" );

		$sOutput = wfShellExec( $sCommand, $iStatus );
		$this->info( "Command finished with exit code #{$iStatus}\n{$sOutput}\n" );

		$oDB = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		$sDumpHold = (string) $oDB->selectField(
			'dumps',
			'dump_hold',
			array( 'dump_wiki_id' => $wikiId ),
			__METHOD__,
			array(
				'ORDER BY' => 'dump_requested DESC',
				'LIMIT' => 1
			)
		);

		if ( $sDumpHold === 'Y' ) {
			$this->error( 'Dump for this wiki is on hold.', [
				'wikiId' => $wikiId
			] );
		}

		if ( $iStatus > 0 ) {
			$this->error( __METHOD__ . ' - failed creating dumps', [
				'exception' => new \Exception( $sCommand, $iStatus ),
				'output' => $sOutput,
			] );

			$this->error( "Failed creating dumps. Terminating." );
			$oDB->update(
				'dumps',
				array(
					'dump_compression' => \DumpsOnDemand::DEFAULT_COMPRESSION_FORMAT,
					'dump_hold' => 'Y',
					'dump_errors' => wfTimestampNow()
				),
				array(
					'dump_wiki_id' => $wikiId,
					'dump_completed IS NULL',
					'dump_hold' => 'N'
				),
				__METHOD__
			);

			return;
		}

		$this->info( "Dumps completed. Updating the status of the request." );

		$oDB->update(
			'dumps',
			array(
				'dump_completed' => wfTimestampNow(),
				'dump_compression' => \DumpsOnDemand::DEFAULT_COMPRESSION_FORMAT,
			),
			array(
				'dump_wiki_id' => $wikiId,
				'dump_completed IS NULL',
				'dump_hold' => 'N'
			),
			__METHOD__
		);

		\DumpsOnDemand::purgeLatestDumpInfo( intval( $wikiId ) );

		$this->info( "Done." );

		return;
	}
}
