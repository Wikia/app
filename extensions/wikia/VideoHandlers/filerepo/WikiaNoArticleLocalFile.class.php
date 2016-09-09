<?php

/* Wikia wrapper on WikiaLocalFile.
 * Alter some functionality allow using thumbnails as a representative of videos in file structure.
 * Works as interface, logic should go to WikiaLocalFileShared
 */

use Wikia\Util\PerformanceProfilers\UsernameUseProfiler;

class WikiaNoArticleLocalFile extends WikiaLocalFile {
	
	/**
	 * Record a file upload in the upload log and the image table
	 */
	function recordUpload2( $oldver, $comment, $pageText, $props = false, $timestamp = false, $user = null )
	{
		global $wgCityId;

		if( is_null( $user ) ) {
			global $wgUser;
			$user = $wgUser;
		}

		$dbw = $this->repo->getMasterDB();
		$dbw->begin();
		if ( !$props ) {
			$props = $this->repo->getFileProps( $this->getVirtualUrl() );
		}

		$props['description'] = $comment;
		$props['user'] = $user->getId();
		$props['user_text'] = $user->getName();
		$props['timestamp'] = wfTimestamp( TS_MW );
		$this->setProps( $props );
		// Delete thumbnails and refresh the metadata cache
		$this->purgeThumbnails();
		$this->saveToCache();
		SquidUpdate::purge( array( $this->getURL() ) );
		/* Wikia change begin - @author: Marooned, see RT#44185 */
		global $wgLogo;
		if ($this->url == $wgLogo) {
			SquidUpdate::purge( array( $this->url ) );
		}
		/* Wikia change end */
		// Fail now if the file isn't there
		if ( !$this->fileExists ) {
			wfDebug( __METHOD__ . ": File " . $this->getPath() . " went missing!\n" );
			return false;
		}

		$reupload = false;
		if ( $timestamp === false ) {
			$timestamp = $dbw->timestamp();
		}
		# Test to see if the row exists using INSERT IGNORE
		# This avoids race conditions by locking the row until the commit, and also
		# doesn't deadlock. SELECT FOR UPDATE causes a deadlock for every race condition.
		$dbw->insert( 'image',
			array(
				'img_name' => $this->getName(),
				'img_size'=> $this->size,
				'img_width' => intval( $this->width ),
				'img_height' => intval( $this->height ),
				'img_bits' => $this->bits,
				'img_media_type' => $this->media_type,
				'img_major_mime' => $this->major_mime,
				'img_minor_mime' => $this->minor_mime,
				'img_timestamp' => $timestamp,
				'img_description' => $comment,
				'img_user' => $user->getId(),
				'img_user_text' => $user->getName(),
				'img_metadata' => $this->metadata,
				'img_sha1' => $this->sha1
			),
			__METHOD__,
			'IGNORE'
		);

		if( $dbw->affectedRows() == 0 ) {
			$usernameUseProfiler = new UsernameUseProfiler( __CLASS__, __METHOD__ );
			$reupload = true;

			# Collision, this is an update of a file
			# Insert previous contents into oldimage
			$dbw->insertSelect( 'oldimage', 'image',
				array(
					'oi_name' => 'img_name',
					'oi_archive_name' => $dbw->addQuotes( $oldver ),
					'oi_size' => 'img_size',
					'oi_width' => 'img_width',
					'oi_height' => 'img_height',
					'oi_bits' => 'img_bits',
					'oi_timestamp' => 'img_timestamp',
					'oi_description' => 'img_description',
					'oi_user' => 'img_user',
					'oi_user_text' => 'img_user_text',
					'oi_metadata' => 'img_metadata',
					'oi_media_type' => 'img_media_type',
					'oi_major_mime' => 'img_major_mime',
					'oi_minor_mime' => 'img_minor_mime',
					'oi_sha1' => 'img_sha1'
				), array( 'img_name' => $this->getName() ), __METHOD__
			);

			# Update the current image row
			$dbw->update( 'image',
				array( /* SET */
					'img_size' => $this->size,
					'img_width' => intval( $this->width ),
					'img_height' => intval( $this->height ),
					'img_bits' => $this->bits,
					'img_media_type' => $this->media_type,
					'img_major_mime' => $this->major_mime,
					'img_minor_mime' => $this->minor_mime,
					'img_timestamp' => $timestamp,
					'img_description' => $comment,
					'img_user' => $user->getId(),
					'img_user_text' => $user->getName(),
					'img_metadata' => $this->metadata,
					'img_sha1' => $this->sha1
				), array( /* WHERE */
					'img_name' => $this->getName()
				), __METHOD__
			);
			$usernameUseProfiler->end();
		} else {
			# This is a new file
			# Update the image count
			$site_stats = $dbw->tableName( 'site_stats' );
			$dbw->query( "UPDATE $site_stats SET ss_images=ss_images+1", __METHOD__ );
		}

		# Commit the transaction now, in case something goes wrong later
		# The most important thing is that files don't get lost, especially archives
		$dbw->commit();

		# Invalidate cache for all pages using this file
		$task = ( new \Wikia\Tasks\Tasks\HTMLCacheUpdateTask() )
			->wikiId( $wgCityId )
			->title( $this->getTitle() );
		$task->call( 'purge', 'imagelinks' );
		$task->queue();

		return true;
	}
}