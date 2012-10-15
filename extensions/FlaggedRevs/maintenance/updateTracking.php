<?php
/**
 * @ingroup Maintenance
 */
if ( getenv( 'MW_INSTALL_PATH' ) ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$IP = dirname(__FILE__).'/../../..';
}

require_once( "$IP/maintenance/Maintenance.php" );

class UpdateFRTracking extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Correct the page data in the flaggedrevs tracking tables. " .
			"Update the quality tier of revisions based on their rating tags. " .
			"Migrate flagged revision file version data to proper table.";
		$this->addOption( 'startpage', 'Page ID to start on', false, true );
		$this->addOption( 'startrev', 'Rev ID to start on', false, true );
		$this->addOption( 'updateonly', 'One of (revs, pages, images)', false, true );
	}

	public function execute() {
		$startPage = $this->getOption( 'startpage' );
		$startRev = $this->getOption( 'startrev' );
		$updateonly = $this->getOption( 'updateonly' );
		if ( $updateonly ) {
			switch ( $updateonly ) {
				case 'revs':
					$this->update_flaggedrevs( $startRev );
					break;
				case 'pages':
					$this->update_flaggedpages( $startPage );
					break;
				case 'images':
					$this->update_flaggedimages( $startRev );
					break;
				default:
					$this->error( "Invalidate operation specified.\n", true );
			}
		} else {
			$this->update_flaggedrevs( $startRev );
			$this->update_flaggedpages( $startPage );
			$this->update_flaggedimages( $startRev );
		}
	}

	protected function update_flaggedrevs( $start = null ) {
		$this->output( "Populating and correcting flaggedrevs columns\n" );

		$BATCH_SIZE = 1000;

		$db = wfGetDB( DB_MASTER );

		if ( $start === null ) {
			$start = $db->selectField( 'revision', 'MIN(rev_id)', false, __METHOD__ );
		}
		$end = $db->selectField( 'revision', 'MAX(rev_id)', false, __METHOD__ );
		if ( is_null( $start ) || is_null( $end ) ) {
			$this->output( "...revision table seems to be empty.\n" );
			return;
		}
		# Do remaining chunk
		$end += $BATCH_SIZE - 1;
		$blockStart = $start;
		$blockEnd = $start + $BATCH_SIZE - 1;
		$count = 0;
		$changed = 0;
		while ( $blockEnd <= $end ) {
			$this->output( "...doing fr_rev_id from $blockStart to $blockEnd\n" );
			$cond = "rev_id BETWEEN $blockStart AND $blockEnd 
				AND fr_rev_id = rev_id AND page_id = rev_page";
			$res = $db->select(
				array( 'revision', 'flaggedrevs', 'page' ),
				array( 'fr_rev_id', 'fr_tags', 'fr_quality', 'page_namespace', 'page_title',
					'fr_img_name', 'fr_img_timestamp', 'fr_img_sha1', 'rev_page'), 
				$cond,
				__METHOD__
			);
			$db->begin();
			# Go through and clean up missing items, as well as correct fr_quality...
			foreach ( $res as $row ) {
				$tags = FlaggedRevision::expandRevisionTags( $row->fr_tags );
				# Quality rating levels may have changed due to config tweaks...
				$quality = FlaggedRevs::getQualityTier( $tags, 0 /* sanity */ );

				$file = $row->fr_img_name;
				$fileTime = $row->fr_img_timestamp;
				$fileSha1 = $row->fr_img_sha1;
				# Check for file version to see if it's stored the old way...
				if ( $row->page_namespace == NS_FILE && !$file ) {
					$irow = $db->selectRow( 'flaggedimages',
						array( 'fi_img_timestamp', 'fi_img_sha1' ),
						array( 'fi_rev_id' => $row->fr_rev_id, 'fi_name' => $row->page_title ),
						__METHOD__ );
					$fileTime = $irow ? $irow->fi_img_timestamp : null;
					$fileSha1 = $irow ? $irow->fi_img_sha1 : null;
					$file = $irow ? $row->page_title : null;
					# Fill in from current if broken
					if ( !$irow ) {
						$crow = $db->selectRow( 'image',
							array( 'img_timestamp', 'img_sha1' ),
							array( 'img_name' => $row->page_title ),
							__METHOD__ );
						$fileTime = $crow ? $crow->img_timestamp : null;
						$fileSha1 = $crow ? $crow->img_sha1 : null;
						$file = $crow ? $row->page_title : null;
					}
				}

				# Check if anything needs updating
				if ( $quality != $row->fr_quality
					|| $file != $row->fr_img_name
					|| $fileSha1 != $row->fr_img_sha1
					|| $fileTime != $row->fr_img_timestamp )
				{
					# Update the row...
					$db->update( 'flaggedrevs',
						array(
							'fr_quality'        => $quality,
							'fr_img_name'       => $file,
							'fr_img_sha1'       => $fileSha1,
							'fr_img_timestamp'  => $fileTime
						),
						array( 'fr_rev_id' => $row->fr_rev_id ),
						__METHOD__
					);
					$changed++;
				}
				$count++;
			}
			$db->commit();
			$db->freeResult( $res );
			$blockStart += $BATCH_SIZE;
			$blockEnd += $BATCH_SIZE;
			wfWaitForSlaves( 5 );
		}
		$this->output( "fr_quality and fr_img_* columns update complete ..." .
			" {$count} rows [{$changed} changed]\n" );
	}
	
	protected function update_flaggedpages( $start = null ) {
		$this->output( "Populating and correcting flaggedpages/flaggedpage_config columns\n" );

		$BATCH_SIZE = 300;

		$db = wfGetDB( DB_MASTER );

		if ( $start === null ) {
			$start = $db->selectField( 'page', 'MIN(page_id)', false, __METHOD__ );
		}
		$end = $db->selectField( 'page', 'MAX(page_id)', false, __METHOD__ );
		if ( is_null( $start ) || is_null( $end ) ) {
			$this->output( "...flaggedpages table seems to be empty.\n" );
			return;
		}
		# Do remaining chunk
		$end += $BATCH_SIZE - 1;
		$blockStart = $start;
		$blockEnd = $start + $BATCH_SIZE - 1;
		$count = $deleted = $fixed = 0;
		while ( $blockEnd <= $end ) {
			$this->output( "...doing page_id from $blockStart to $blockEnd\n" );
			$cond = "page_id BETWEEN $blockStart AND $blockEnd";
			$res = $db->select( 'page',
				array( 'page_id', 'page_namespace', 'page_title', 'page_latest' ),
				$cond, __METHOD__ );
			# Go through and update the de-normalized references...
			$db->begin();
			foreach ( $res as $row ) {
				$title = Title::newFromRow( $row );
				$article = new FlaggableWikiPage( $title );
				$oldFrev = FlaggedRevision::newFromStable( $title, FR_MASTER );
				$frev = FlaggedRevision::determineStable( $title, FR_MASTER );
				# Update fp_stable, fp_quality, and fp_reviewed
				if ( $frev ) {
					$article->updateStableVersion( $frev, $row->page_latest );
					$changed = ( !$oldFrev || $oldFrev->getRevId() != $frev->getRevId() );
				# Somethings broke? Delete the row...
				} else {
					$article->clearStableVersion();
					if ( $db->affectedRows() > 0 ) $deleted++;
					$changed = (bool)$oldFrev;
				}
				# Get the latest revision
				$revRow = $db->selectRow( 'revision', '*',
					array( 'rev_page' => $row->page_id ),
					__METHOD__,
					array( 'ORDER BY' => 'rev_timestamp DESC' ) );
				# Correct page_latest if needed (import/files made plenty of bad rows)
				if ( $revRow ) {
					$revision = new Revision( $revRow );
					if ( $article->updateIfNewerOn( $db, $revision ) ) {
						$fixed++;
					}
				}
				if ( $changed ) {
					# Lazily rebuild dependancies on next parse (we invalidate below)
					FlaggedRevs::clearStableOnlyDeps( $title );
					$title->invalidateCache();
				}
				$count++;
			}
			$db->freeResult( $res );
			# Remove manual config settings that simply restate the site defaults
			$db->delete( 'flaggedpage_config',
				array( "fpc_page_id BETWEEN $blockStart AND $blockEnd",
					'fpc_override'  => intval( FlaggedRevs::isStableShownByDefault() ),
					'fpc_level'     => ''
				),
				__METHOD__
			);
			$deleted = $deleted + $db->affectedRows();
			$db->commit();
			$blockStart += $BATCH_SIZE;
			$blockEnd += $BATCH_SIZE;
			wfWaitForSlaves( 5 );
		}
		$this->output( "flaggedpage columns update complete ..." .
			" {$count} rows [{$fixed} fixed] [{$deleted} deleted]\n" );
	}

	protected function update_flaggedimages( $start = null ) {
		$this->output( "Cleaning up flaggedimages columns\n" );

		$BATCH_SIZE = 1000;

		$db = wfGetDB( DB_MASTER );

		if ( $start === null ) {
			$start = $db->selectField( 'flaggedimages', 'MIN(fi_rev_id)', false, __METHOD__ );
		}
		$end = $db->selectField( 'flaggedimages', 'MAX(fi_rev_id)', false, __METHOD__ );
		if ( is_null( $start ) || is_null( $end ) ) {
			$this->output( "...flaggedimages table seems to be empty.\n" );
			return;
		}
		# Do remaining chunk
		$end += $BATCH_SIZE - 1;
		$blockStart = $start;
		$blockEnd = $start + $BATCH_SIZE - 1;
		$nulled = 0;
		while ( $blockEnd <= $end ) {
			$this->output( "...doing fi_rev_id from $blockStart to $blockEnd\n" );
			$cond = "fi_rev_id BETWEEN $blockStart AND $blockEnd";
			$db->begin();
			# Remove padding garbage and such...turn to NULL instead
			$db->update( 'flaggedimages',
				array( 'fi_img_timestamp' => null ),
				array( $cond, "fi_img_timestamp = '' OR LOCATE( '\\0', fi_img_timestamp )" ),
				__METHOD__
			);
			if ( $db->affectedRows() > 0 ) {
				$nulled += $db->affectedRows();
			}
			$db->commit();
			$blockStart += $BATCH_SIZE;
			$blockEnd += $BATCH_SIZE;
			wfWaitForSlaves( 5 );
		}
		$this->output( "flaggedimages columns update complete ... [{$nulled} fixed]\n" );
	}
}

$maintClass = "UpdateFRTracking";
require_once( RUN_MAINTENANCE_IF_MAIN );
