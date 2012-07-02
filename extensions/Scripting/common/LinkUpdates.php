<?php
/**
 * Wikitext scripting infrastructure for MediaWiki: link updating code
 * Copyright (C) 2011-2012 Victor Vasiliev <vasilvv@gmail.com> et al
 * Based on MediaWiki file LinksUpdate.php
 * http://www.mediawiki.org/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

if( !defined( 'MEDIAWIKI' ) )
	die();


/**
 * Class that contains hooks related to tracking links to scripts and invalidating
 * pages on script change.
 */
class ScriptLinksUpdateHooks {
	/**
	 * Appends script links to the output.
	 */
	public static function appendToOutput( &$parser, &$text ) {
		if( isset( $parser->scripting_engine ) ) {
			$parser->mOutput->scripting_links = $parser->scripting_engine->getUsedModules();
		}
		return true;
	}

	/**
	 * Runs the link updater.
	 */
	public static function updateLinks( &$update ) {
		$output = $update->mParserOutput;
		if( isset( $output->scripting_links ) ) {
			$new = $output->scripting_links;
		} else {
			$new = array();
		}
		
		$isupdate = new ScriptLinksUpdate( $update, $new );
		$isupdate->run();
		return true;
	}

	/**
	 * Purges cache for all the pages where the script is used.
	 * @param $article Article
	 * @param $editInfo
	 * @param $changed
	 * @return bool
	 */
	public static function purgeCache( &$article, &$editInfo, $changed ) {
		global $wgDeferredUpdateList, $wgParser;

		if( $article->getTitle()->getNamespace() == NS_MODULE ) {
			// Invalidate the script cache
			$engine = Scripting::getEngine( $wgParser );
			$engine->invalidateModuleCache( $article->getTitle() );
			
			// Invalidate caches of articles which include the script
			$wgDeferredUpdateList[] = new HTMLCacheUpdate( $article->getTitle(), 'scriptlinks' );
		}

		return true;
	}

	/**
	 * Adds scriptlinks to the list of tables supported by BacklinkCache.
	 */
	public static function getBacklinkCachePrefix( $table, &$prefix ) {
		if( $table == 'scriptlinks' ) {
			$prefix = 'sl';
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Adds scriptlinks to the list of tables supported by BacklinkCache.
	 * @param $table
	 * @param $title Title
	 * @param $conds
	 * @return bool
	 */
	public static function getBacklinkCacheConditions( $table, $title, &$conds ) {
		if( $table == 'scriptlinks' ) {
			$conds = array(
				'sl_to' => $title->getDBkey(),
				'page_id=sl_from'
			);
			return false;
		} else {
			return true;
		}
	}
}

/**
 * A class that updates links on scripts like phase3/includes/LinksUpdate.php does that
 * with templates.
 */
class ScriptLinksUpdate {
	var $mUpdate, $mId, $mNew;

	public function __construct( $update, $new ) {
		$this->mUpdate = $update;
		$this->mId = $update->mId;
		$this->mNew = $new;
	}

	public function run() {
		global $wgUseDumbLinkUpdate;

		wfProfileIn( __METHOD__ );

		if( $wgUseDumbLinkUpdate ) {
			$this->mUpdate->dumbTableUpdate( 'scriptlinks', $this->getScriptInsertions(), 'sl_from' );
		} else {
			$existing = $this->getExistingScripts();
			$this->mUpdate->incrTableUpdate( 'scriptlinks', 'sl', $this->getScriptDeletions( $existing ),
				$this->getScriptInsertions( $existing ) );
		}

		if( $this->mUpdate->mRecursive && $this->mUpdate->mTitle->getNamespace() == NS_MODULE ) {
			$this->queueRecursiveJobs();
		}

		wfProfileOut( __METHOD__ );
	}

	protected function getExistingScripts() {
		$result = array();

		$res = $this->mUpdate->mDb->select( 'scriptlinks', array( 'sl_to' ),
			array( 'sl_from' => $this->mId ), __METHOD__, $this->mUpdate->mOptions );
		foreach ( $res as $row ) {
			$result[] = $row->sl_to;
		}

		return $result;
	}

	protected function getScriptInsertions( $existing = array() ) {
		$result = array();

		foreach( array_diff( $this->mNew, $existing ) as $module ) {
			$result[] = array(
				'sl_from' => $this->mId,
				'sl_to' => $module,
			);
		}

		return $result;
	}

	protected function getScriptDeletions( $existing = array() ) {
		$result = array();

		foreach( array_diff( $existing, $this->mNew ) as $module ) {
			$result[] = array(
				'sl_from' => $this->mId,
				'sl_to' => $module,
			);
		}

		return $result;
	}

	protected function queueRecursiveJobs() {
		global $wgUpdateRowsPerJob;
		wfProfileIn( __METHOD__ );

		$cache = $this->mUpdate->mTitle->getBacklinkCache();
		$batches = $cache->partition( 'scriptlinks', $wgUpdateRowsPerJob );
		if ( !$batches ) {
			wfProfileOut( __METHOD__ );
			return;
		}
		$jobs = array();
		foreach ( $batches as $batch ) {
			list( $start, $end ) = $batch;
			$params = array(
				'table' => 'scriptlinks',
				'start' => $start,
				'end' => $end,
			);
			$jobs[] = new RefreshLinksJob2( $this->mUpdate->mTitle, $params );
		}
		Job::batchInsert( $jobs );

		wfProfileOut( __METHOD__ );
	}
}

