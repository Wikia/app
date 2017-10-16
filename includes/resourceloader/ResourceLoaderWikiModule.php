<?php
/**
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
 *
 * @file
 * @author Trevor Parscal
 * @author Roan Kattouw
 */

defined( 'MEDIAWIKI' ) || die( 1 );

/**
 * Abstraction for resource loader modules which pull from wiki pages
 *
 * This can only be used for wiki pages in the MediaWiki and User namespaces,
 * because of its dependence on the functionality of
 * Title::isCssJsSubpage.
 */
abstract class ResourceLoaderWikiModule extends ResourceLoaderModule {

	// Wikia change - added - @author: wladek
	const MTIMES_CACHE_TTL = 60;

	/* Protected Members */

	# Origin is user-supplied code
	protected $origin = self::ORIGIN_USER_SITEWIDE;

	// In-object cache for title mtimes
	protected $titleMtimes = array();

	/* Abstract Protected Methods */

	/**
	 * @abstract
	 * @param $context ResourceLoaderContext
	 */
	abstract protected function getPages( ResourceLoaderContext $context );

	/* Protected Methods */

	/**
	 * Get the Database object used in getTitleMTimes(). Defaults to the local slave DB
	 * but subclasses may want to override this to return a remote DB object, or to return
	 * null if getTitleMTimes() shouldn't access the DB at all.
	 *
	 * NOTE: This ONLY works for getTitleMTimes() and getModifiedTime(), NOT FOR ANYTHING ELSE.
	 * In particular, it doesn't work for getting the content of JS and CSS pages. That functionality
	 * will use the local DB irrespective of the return value of this method.
	 *
	 * @return DatabaseBase|null
	 */
	protected function getDB() {
		return wfGetDB( DB_SLAVE );
	}

	/**
	 * @param $title Title
     * @param $titleText string Title text
	 * @param $options array Extra options for subclasses
	 * @return null|string
	 */
	protected function getContent( $title, $titleText, $options = array() ) {
		if ( $title->getNamespace() === NS_MEDIAWIKI ) {
			$message = wfMessage( $title->getDBkey() )->inContentLanguage();
			return $message->exists() ? $message->plain() : null;
		}
		if ( !$title->isCssJsSubpage() && !$title->isCssOrJsPage() ) {
			return null;
		}
		$revision = Revision::newFromTitle( $title );
		if ( !$revision ) {
			return null;
		}
		return $revision->getRawText();
	}

	/* Methods */

	/**
	 * Create a title given title text and options coming along with this
	 * title item.
	 *
	 * @param $titleText string Title text
	 * @param $options array Options provided with this item
	 * @return Title|null
	 */
	protected function createTitle( $titleText, $options = array() ) {
		return Title::newFromText( $titleText );
	}

	/**
	 * @param $context ResourceLoaderContext
	 * @return string
	 */
	public function getScript( ResourceLoaderContext $context ) {
		$scripts = '';
		foreach ( $this->getPages( $context ) as $titleText => $options ) {
			if ( $options['type'] !== 'script' ) {
				continue;
			}
			$title = $this->createTitle( $titleText, $options );
			if ( !$title || $title->isRedirect() ) {
				continue;
			}
			$script = $this->getContent( $title, $titleText, $options );
			if ( strval( $script ) !== '' ) {
				$script = $this->validateScriptFile( $titleText, $script );
				if ( strpos( $titleText, '*/' ) === false ) {
					$scripts .=  "/* " . $this->getResourceName($title,$titleText,$options) . " */\n";
				}
				$scripts .= $script . "\n;\n";
			}
		}
		return $scripts;
	}

	/**
	 * @param $context ResourceLoaderContext
	 * @return array
	 */
	public function getStyles( ResourceLoaderContext $context ) {
		global $wgScriptPath;

		$styles = array();
		foreach ( $this->getPages( $context ) as $titleText => $options ) {
			if ( $options['type'] !== 'style' ) {
				continue;
			}
			$title = $this->createTitle( $titleText, $options );
			if ( !$title || $title->isRedirect()  ) {
				continue;
			}
			$media = isset( $options['media'] ) ? $options['media'] : 'all';
			$style = $this->getContent( $title, $titleText, $options );
			if ( strval( $style ) === '' ) {
				continue;
			}
			if ( $this->getFlip( $context ) ) {
				$style = CSSJanus::transform( $style, true, false );
			}
			$style = CSSMin::remap( $style, false, $wgScriptPath, true );
			if ( !isset( $styles[$media] ) ) {
				$styles[$media] = '';
			}
			if ( strpos( $titleText, '*/' ) === false ) {
				$styles[$media] .=  "/* " . $this->getResourceName($title,$titleText,$options) . " */\n";
			}
			$styles[$media] .= $style . "\n";
		}
		return $styles;
	}

	/**
	 * @param $context ResourceLoaderContext
	 * @return int|mixed
	 */
	public function getModifiedTime( ResourceLoaderContext $context ) {
		$modifiedTime = 1; // wfTimestamp() interprets 0 as "now"
		$mtimes = $this->getTitleMtimes( $context );
		if ( count( $mtimes ) ) {
			$modifiedTime = max( $modifiedTime, max( $mtimes ) );
		}
		$modifiedTime = max( $modifiedTime, $this->getMsgBlobMtime( $context->getLanguage() ) );
		return $modifiedTime;
	}

	/**
	 * @param $context ResourceLoaderContext
	 * @return bool
	 */
	public function isKnownEmpty( ResourceLoaderContext $context ) {
		return count( $this->getTitleMtimes( $context ) ) == 0;
	}

	/**
	 * Get the modification times of all titles that would be loaded for
	 * a given context.
	 * Caches data from underlying layers.
	 *
	 * @param $context ResourceLoaderContext: Context object
	 * @return array( prefixed DB key => UNIX timestamp ), nonexistent titles are dropped
	 */
	protected function getTitleMtimes( ResourceLoaderContext $context ) {
		global $wgMemc;
		wfProfileIn(__METHOD__);
		$hash = $context->getHash();
		if ( isset( $this->titleMtimes[$hash] ) ) {
			wfProfileOut(__METHOD__);
			return $this->titleMtimes[$hash];
		}

		// Wikia change - begin - @author: wladek
		$memcKey = null; // silence PHPStorm
		if ( !$context->getDebug() ) {
			$memcKey = wfMemcKey('ResourceLoaderWikiModule','mtimes',$this->getName(),md5($hash));
			$mtimes = $wgMemc->get($memcKey);
			if ( is_array($mtimes) ) {
				wfProfileOut(__METHOD__);
				return $mtimes;
			}
		}
		// Wikia change - end

		$this->titleMtimes[$hash] = $this->reallyGetTitleMtimes( $context );

		// Wikia change - begin - @author: wladek
		if ( !$context->getDebug() ) {
			$wgMemc->set($memcKey,$this->titleMtimes[$hash],self::MTIMES_CACHE_TTL);
		}
		// Wikia change - end

		wfProfileOut(__METHOD__);
		return $this->titleMtimes[$hash];
	}

	/**
	 * Get the modification times of all title that would be loaded for
	 * a given context.
	 * Doesn't cache data and executes direct queries on database.
	 *
	 * @param $context ResourceLoaderContext: Context object
	 * @return array( prefixed DB key => UNIX timestamp ), nonexistent titles are dropped
	 */
	protected function reallyGetTitleMtimes( ResourceLoaderContext $context ) {
		$dbr = $this->getDB();
		if ( !$dbr ) {
			// We're dealing with a subclass that doesn't have a DB
			return array();
		}

		$mtimes = array();
		$batch = new LinkBatch;
		foreach ( $this->getPages( $context ) as $titleText => $options ) {
			$batch->addObj( $this->createTitle( $titleText, $options ) );
		}

		if ( !$batch->isEmpty() ) {
			$res = $dbr->select( 'page',
				array( 'page_namespace', 'page_title', 'page_touched' ),
				$batch->constructSet( 'page', $dbr ),
				__METHOD__
			);
			foreach ( $res as $row ) {
				$title = Title::makeTitle( $row->page_namespace, $row->page_title );
				$mtimes[$title->getPrefixedDBkey()] =
					wfTimestamp( TS_UNIX, $row->page_touched );
			}
		}

		return $mtimes;
	}

	/**
	 * Return human-readable name of the file that was included
	 * By default it's put in the comment before the file contents
	 *
	 * @param $title Title
	 * @param $titleText string
	 * @param $options array
	 * @return string
	 */
	protected function getResourceName( $title, $titleText, $options ) {
		return $titleText;
	}

}
