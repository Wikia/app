<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

global $wgVersion;
if ( version_compare( $wgVersion, '1.16', '<' ) ) {
	// LiquidThreads compatibility wrapper around the Article object.
	class Article_LQT_Compat extends Article {
		public function getOutputFromWikitext( $text, $cache = true, $parserOptions = false ) {
			global $wgParser, $wgOut, $wgEnableParserCache, $wgUseFileCache;

			if ( !$parserOptions ) {
				$parserOptions = $wgOut->parserOptions();
			}

			$time = - wfTime();
			$parserOutput = $wgParser->parse( $text, $this->mTitle,
				$parserOptions, true, true, $this->getRevIdFetched() );
			$time += wfTime();

			# Timing hack
			if ( $time > 3 ) {
				wfDebugLog( 'slow-parse', sprintf( "%-5.2f %s", $time,
					$this->mTitle->getPrefixedDBkey() ) );
			}

			if ( $wgEnableParserCache && $cache && $this && $parserOutput->getCacheTime() != - 1 ) {
				$parserCache = ParserCache::singleton();
				$parserCache->save( $parserOutput, $this, $parserOptions );
			}
			// Make sure file cache is not used on uncacheable content.
			// Output that has magic words in it can still use the parser cache
			// (if enabled), though it will generally expire sooner.
			if ( $parserOutput->getCacheTime() == - 1 || $parserOutput->containsOldMagic() ) {
				$wgUseFileCache = false;
			}
			return $parserOutput;
		}

		/** Stolen from 1.16-alpha, for compatibility with 1.15 */
		/** Lightweight method to get the parser output for a page, checking the parser cache
		  * and so on. Doesn't consider most of the stuff that Article::view is forced to
		  * consider, so it's not appropriate to use there. */
		function getParserOutput( $oldid = null ) {
			global $wgEnableParserCache, $wgUser, $wgOut;

			// Should the parser cache be used?
			$useParserCache = $wgEnableParserCache &&
					  intval( $wgUser->getOption( 'stubthreshold' ) ) == 0 &&
					  $this->exists() &&
					  $oldid === null;

			wfDebug( __METHOD__ . ': using parser cache: ' . ( $useParserCache ? 'yes' : 'no' ) . "\n" );
			if ( $wgUser->getOption( 'stubthreshold' ) ) {
				wfIncrStats( 'pcache_miss_stub' );
			}

			$parserOutput = false;
			if ( $useParserCache ) {
				$parserOutput = ParserCache::singleton()->get( $this, $wgOut->parserOptions() );
			}

			if ( $parserOutput === false ) {
				// Cache miss; parse and output it.
				$rev = Revision::newFromTitle( $this->getTitle(), $oldid );

				return $this->getOutputFromWikitext( $rev->getText(), $useParserCache );
			} else {
				return $parserOutput;
			}
		}
	}
} else {
	class Article_LQT_Compat extends Article { }
}
