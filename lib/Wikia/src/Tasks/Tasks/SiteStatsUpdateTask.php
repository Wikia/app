<?php
namespace Wikia\Tasks\Tasks;

/**
 * Asynchronously update site statistics such as total edits, page count etc. after an edit
 * @see SRE-109
 */
class SiteStatsUpdateTask extends BaseTask {

	public function onArticleEdit( bool $wasNewlyCreated, bool $wasContentPage ) {
		$updates = [
			'ss_total_edits = ss_total_edits + 1'
		];

		if ( $wasNewlyCreated ) {
			$updates[] = 'ss_total_pages = ss_total_pages + 1';

			if ( $wasContentPage ) {
				$updates[] = 'ss_good_articles = ss_good_articles + 1';
			} elseif ( $this->isFile() ) {
				$updates[] = 'ss_images = ss_images + 1';
			}
		}

		$dbw = wfGetDB( DB_MASTER );

		$dbw->update( 'site_stats', $updates, [ 'ss_row_id' => 1 ], __METHOD__ );
	}

	private function isFile(): bool {
		if ( !$this->title->inNamespace( NS_FILE ) || $this->title->isRedirect() ) {
			return false;
		}

		$localRepo = \RepoGroup::singleton()->getLocalRepo();
		$file = $localRepo->newFile( $this->title );

		return $file && $file->exists();
	}
}
