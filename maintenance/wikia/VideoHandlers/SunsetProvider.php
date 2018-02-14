<?php

require_once __DIR__ . '/../../Maintenance.php';

/**
 * Maintenance script to automate sunsetting a video provider
 * Deletes all videos from given provider and removes all references to them from article pages
 */
class SunsetProvider extends Maintenance {

	/** @var string VIDEO_REMOVE_EDIT_SUMMARY */
	const VIDEO_REMOVE_EDIT_SUMMARY = 'Removing unsupported video';

	public function __construct() {
		parent::__construct();

		$this->addOption( 'dry-run', "Don't make any changes to database - only display statistics." );
		$this->addOption( 'provider', 'Name of video provider to sunset', true /* required */, true /* needs arg :) */ );
	}

	public function execute() {
		global $wgUser;
		$wgUser = User::newFromName( Wikia::BOT_USER );

		$providerName = $this->getOption( 'provider' );
		$isDryRun = $this->getOption( 'dry-run', false );

		$videoList = $this->getProviderVideos( $providerName );
		$videoEmbeds = $this->getProviderVideoEmbeds( $providerName );

		if ( !$isDryRun ) {
			$this->deleteVideos( $videoList );
			$this->removeVideoReferences( $videoEmbeds );
		} else {
			$this->printAffectedContent( $videoList, $videoEmbeds );
		}
	}

	/**
	 * Return the titles of all videos that belong to this provider
	 *
	 * @param string $providerName name of provider to remove
	 * @return ResultWrapper
	 */
	private function getProviderVideos( string $providerName ): ResultWrapper {
		$db = $this->getDB( DB_SLAVE );

		$videoEmbeds = $db->select(
			'video_info',
			'video_title',
			[
				'provider' => $providerName,
				'premium' => 0
			],
			__METHOD__
		);

		// fallback to image table, video_info is out of sync on mediawiki119.wikia.com
		if ( $db->affectedRows() === 0 ) {
			$videoEmbeds = $db->select(
				'image',
				'img_name AS video_title',
				[
					'img_minor_mime' => $providerName,
					'img_media_type' => 'VIDEO'
				],
				__METHOD__
			);

			if ( $db->affectedRows() > 0 ) {
				$this->output( sprintf( "Applied fallback to image table for '%s' provider\n",
					$providerName ) );
			}
		}

		return $videoEmbeds;
	}

	/**
	 * Return the list of articles that embed videos from this provider, with a corresponding list of videos
	 *
	 * @param string $providerName name of provider to remove
	 * @return ResultWrapper
	 */
	private function getProviderVideoEmbeds( string $providerName ): ResultWrapper {
		$videoEmbeds = $this->getDB( DB_SLAVE )->select(
			[ 'page', 'imagelinks', 'video_info' ],
			[ 'page_title', 'page_namespace', 'GROUP_CONCAT(video_title SEPARATOR "#") as embedded_videos' ],
			[ 'provider' => $providerName, 'page_is_redirect' => 0 ],
			__METHOD__,
			[ 'DISTINCT', 'GROUP BY' => 'page_id' ],
			[
				'imagelinks' => [ 'INNER JOIN', 'page_id = il_from' ],
				'video_info' => [ 'INNER JOIN', 'il_to = video_title' ]
			]
		);

		return $videoEmbeds;
	}

	/**
	 * Delete all videos that belong to the target provider
	 * @see FileDeleteForm::doDelete()
	 * @see VideoHandlerController::removeVideo()
	 *
	 * @param ResultWrapper $videoList
	 */
	private function deleteVideos( ResultWrapper $videoList ) {
		global $wgUser;
		$reason = static::VIDEO_REMOVE_EDIT_SUMMARY;

		/** @var object $video */
		foreach ( $videoList as $video ) {
			$title = Title::makeTitle( NS_FILE, $video->video_title );
			$page = WikiPage::factory( $title );
			$file = wfFindFile( $title );

			// This logic is essentially a simplified form of FileDeleteForm::doDelete or VideoHandlerController::removeVideo
			// However the order of execution is reversed, since we do not have to update an UI or perform permissions check in this context
			// This allows for simplified structure
			$fileDeleteStatus = Status::newFatal( 'cannotdelete', wfEscapeWikiText( $title->getPrefixedText() ) );
			$pageDeleteResult = true;
			if ( ( $file instanceof File ) && $file->isLocal() ) {
				/** @var Status $fileDeleteStatus */
				$fileDeleteStatus = $file->delete( $reason );

				// Run post-deletion hook if file deletion was successful - extensions require it
				if ( $fileDeleteStatus->isOK() ) {
					$oldimage = null;
					Hooks::run( 'FileDeleteComplete', [ &$file, &$oldimage, &$page, &$wgUser, &$reason ] );

					// If the page never existed in the first place, that's good with us :)
					$pageDeleteResult = $page->doDeleteArticleReal( $reason ) >= WikiPage::DELETE_SUCCESS;
				}

				if ( !$pageDeleteResult || !$fileDeleteStatus->isOK() ) {
					$this->error( "Failed to delete video: {$video->video_title}" );
				}
				else {
					$this->output( sprintf("Deleted %s video\n", $title->getPrefixedDBkey()) );
				}
			}
		}

		$this->output("\nDone!\n");
	}

	/**
	 * Removes all references to target video from all pages on this wiki where it was embedded on
	 *
	 * @param ResultWrapper $videoEmbeds
	 */
	private function removeVideoReferences( ResultWrapper $videoEmbeds ) {
		// MediaWiki understands both English and local (as set in $wgLanguageCode) namespace names
		// So in regex we need to account for both of those
		global $wgContLang;

		$englishLanguage = Language::factory( 'en' );
		$englishFileNs = $englishLanguage->getNsText( NS_FILE );
		if ( $wgContLang->getCode() !== 'en' ) {
			$localFileNs = $wgContLang->getNsText( NS_FILE );

			$localFileNs = str_replace( '_', '[_\s]', $localFileNs );
			$fileNsRegex = "($localFileNs|$englishFileNs)";
		} else {
			$fileNsRegex = $englishFileNs;
		}

		/** @var object $embedData */
		foreach ( $videoEmbeds as $embedData ) {
			$title = Title::newFromRow( $embedData );
			$page = WikiPage::factory( $title );
			$text = $page->getText();

			if ( $text ) {
				// see GROUP_CONCAT query above
				$videoList = explode( '#', $embedData->embedded_videos );

				// escape regex characters in title
				array_walk( $videoList, function ( string &$videoTitle ) {
					$videoTitle = preg_quote( $videoTitle, '/' );
				} );

				$videosRegex = '(' . implode( '|', $videoList ) . ')';
				$videosRegex = str_replace( '_', '[_\s]', $videosRegex );

				$this->removeGalleryReferences( $text, $videosRegex, $fileNsRegex );
				$this->removeDirectEmbeds( $text, $videosRegex, $fileNsRegex );

				$status = $page->doEdit( $text, static::VIDEO_REMOVE_EDIT_SUMMARY, EDIT_MINOR | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT );
				if ( !$status->isOK() ) {
					$this->error( "Failed to remove videos from page: {$title->getPrefixedText()}\n" );
				}
				else {
					$this->output( sprintf("Updated %s article\n", $title->getPrefixedDBkey()) );
				}
			}
		}
	}

	/**
	 * Removes all reference to the given videos from <gallery> tags inside the article
	 *
	 * @param string $text article text to transform (passed by reference)
	 * @param string $videosRegex precompiled regex fragment of all videos to remove
	 * @param string $fileNsRegex precompiled regex fragment of possible File namespace aliases
	 */
	private function removeGalleryReferences( string &$text, string $videosRegex, string $fileNsRegex ) {
		$regex = "/^($fileNsRegex\\:)?$videosRegex(\\|.*)?$/m";
		$text = preg_replace_callback( '/<gallery>(.*)<\/gallery>/s', function ( array $matches ) use ( $regex ): string {
			$content = $matches[1];
			$replacedContent = preg_replace( $regex, '', $content );

			return "<gallery>$replacedContent</gallery>";
		}, $text );
	}

	/**
	 * Removes all direct embeds of the given videos from the article
	 *
	 * @param string $text article text to transform (passed by reference)
	 * @param string $videosRegex precompiled regex fragment of all videos to remove
	 * @param string $fileNsRegex precompiled regex fragment of possible File namespace aliases
	 */
	private function removeDirectEmbeds( string &$text, string $videosRegex, string $fileNsRegex ) {
		$fileLinksRegex = "/\\[\\[$fileNsRegex:$videosRegex(\\|[^\\]]*)?\\]\\]/";

		$text = preg_replace( $fileLinksRegex, '', $text );
	}

	/**
	 * Print the list of articles and videos that would be affected by the script
	 * Also provides article and video count as well as total count
	 *
	 * @param ResultWrapper $videoList
	 * @param ResultWrapper $videoEmbeds
	 */
	private function printAffectedContent( ResultWrapper $videoList, ResultWrapper $videoEmbeds ) {
		$articlesCount = $videosCount = 0;

		$this->output( "List of affected content:\n\n" );

		/** @var object $embedData */
		foreach ( $videoEmbeds as $embedData ) {
			$title = Title::newFromRow( $embedData );
			$videoCount = count( str_getcsv( $embedData->embedded_videos ) );

			$this->output( "{$title->getPrefixedText()} ($videoCount videos)\n" );
			$articlesCount++;
		}

		$this->output( "\n" );

		/** @var object $video */
		foreach ( $videoList as $video ) {
			$title = Title::makeTitle( NS_FILE, $video->video_title );
			$this->output( "{$title->getPrefixedText()} \n" );
			$videosCount++;
		}

		$totalCount = $articlesCount + $videosCount;
		$this->output( "\nNumber of affected articles: $articlesCount\n" );
		$this->output( "Number of affected videos: $videosCount\n" );
		$this->output( "Total affected content count: $totalCount\n" );
	}
}

$maintClass = SunsetProvider::class;
require_once RUN_MAINTENANCE_IF_MAIN;
