<?php

/**
 * Subclass of ResourceLoaderWikiModule that supports fetching
 * articles from other wikis
 */
abstract class ResourceLoaderGlobalWikiModule extends ResourceLoaderWikiModule {

	protected function parseTitle( $titleText ) {
		global $wgCanonicalNamespaceNames;

		$text = $titleText;
		$namespace = NS_MAIN;
		foreach ($wgCanonicalNamespaceNames as $namespaceId => $namespacePrefix) {
			// check only standard namespaces
			if ( $namespaceId < 0 || $namespaceId >= 100 ) {
				continue;
			}
			$namespacePrefix = strtolower($namespacePrefix) . ':';
			if ( startsWith( strtolower( $titleText ), $namespacePrefix ) ) {
				$text = substr( $titleText, strlen($namespacePrefix) );
				$namespace = $namespaceId;
				break;
			}
		}

		$text = str_replace(' ','_',$text);
		$text = trim($text,'_');
		if ( $text === '' ) {
			$text = false;
		}

		return array( $text, $namespace );
	}

	/**
	 * Get target title if the current title is a redirect.
	 * It doesn't handle
	 *
	 * @param $title Title|GlobalTitle
	 * @return Title|GlobalTitle
	 */
	protected function resolveRedirect( $title ) {
		$origTitle = $title;
		if ( $title instanceof GlobalTitle ) {
			if ( $title->isRedirect() ) {
				$target = $title->getRedirectTarget();
				if ( $target ) {
					$title = $target;
				}
			}
		} else if ( $title instanceof Title ) {
			if ( $title->isRedirect() ) {
				$page = new WikiPage( $title );
				$target = $page->getRedirectTarget();
				if ( $target->exists() ) {
					$title = $target;
				}
			}
		}
		return $title;
	}

	protected function createTitle( $titleText, $options = array() ) {
		global $wgCityId;
		$title = null;
		$realTitleText = isset($options['title']) ? $options['title'] : $titleText;
		if ( !empty( $options['city_id'] ) && $wgCityId != $options['city_id'] ) {
			list( $text, $namespace ) = $this->parseTitle($realTitleText);
			if ( $text !== false ) {
				$title = GlobalTitle::newFromText($text, $namespace, $options['city_id']);
			}
			$title = $this->resolveRedirect($title);
		} else {
			$title = Title::newFromText( $realTitleText );
			$title = $this->resolveRedirect($title);
		}

		return $title;
	}

	protected function getContent( $title, $titleText, $options = array() ) {
		global $wgCityId;
		$content = null;

		if ( $title instanceof GlobalTitle ) {
			// todo: think of pages like NS_MAIN:Test/code.js that are pulled
			// from dev.wikia.com
			/*
			if ( !$title->isCssJsSubpage() && !$title->isCssOrJsPage() ) {
				return null;
			}
			*/

			if ( WikiFactory::isWikiPrivate( $title->getCityId() ) == false ) {
				$content = $title->getContent();
			}

		// Try to load the contents of an article before falling back to a message (BugId:45352)
		} elseif ( WikiFactory::isWikiPrivate( $wgCityId ) == false ) {
			$revision = Revision::newFromTitle( $title );

			if ($revision) {
				$content = $revision->getRawText();
			}

			// Fall back to parent logic
			if ( !$content ) {
				$content = parent::getContent( $title, $options );
			}
		}

		// Failed to get contents
		if ( ( $content === false || $content === null || isset( $options['missing'] ) ) ) {
			$missingArticle = $this->getResourceName( $title, $titleText, $options );

			if ( $options['type'] == 'script' && isset( $options['missingCallback'] ) ) {
				$missingCallback = $options['missingCallback'];
				$missingArticle = json_encode( (string) $missingArticle );
				$content = "window.{$missingCallback} && window.{$missingCallback}({$missingArticle});";

			} else if ( $options['type'] == 'style' ) {
				$content = "/* Not found (requested by user-supplied javascript) */";
			}
		}

		return $content;
	}

	protected function reallyGetTitleMtimes( ResourceLoaderContext $context ) {
		$dbr = $this->getDB();
		if ( !$dbr ) {
			// We're dealing with a subclass that doesn't have a DB
			return array();
		}

		$mtimes = array();
		$local = array();
		$byWiki = array();

		foreach ( $this->getPages( $context ) as $titleText => $options ) {
			$title = $this->createTitle($titleText,$options);
			if ($title instanceof GlobalTitle) {
				$byWiki[$title->getCityId()][] = array( $title, $titleText, $options );
			} else {
				$local[] = array( $title, $titleText, $options );
			}
		}

		if ( !empty($local) ) {
			$batch = new LinkBatch;
			foreach ( $local as $page ) {
				list( $title, $titleText, $options ) = $page;
				$batch->addObj( $title );
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
		}

		foreach ($byWiki as $cityId => $pages) {
			// $pages[0][0] has to be GlobalTitle
			$dbName = $pages[0][0]->getDatabaseName();
			$dbr = wfGetDB(DB_SLAVE,array(),$dbName);

			$pagesData = array();
			foreach ($pages as $page) {
				list( $title, $titleText, $options ) = $page;
				$pagesData[$title->getNamespace()][$title->getDBkey()] = true;
			}

			$res = $dbr->select( 'page',
				array( 'page_namespace', 'page_title', 'page_touched' ),
				$dbr->makeWhereFrom2d( $pagesData, 'page_namespace', 'page_title' ),
				__METHOD__
			);
			foreach ( $res as $row ) {
				$title = GlobalTitle::newFromText( $row->page_title, $row->page_namespace, $cityId );
				$mtimes[$dbName.'::'.$title->getPrefixedDBkey()] =
					wfTimestamp( TS_UNIX, $row->page_touched );
			}
		}

		return $mtimes;
	}

	protected function getResourceName( $title, $titleText, $options ) {
		if ( isset( $options['originalName'] ) ) {
			return $options['originalName'];
		}
		if ( $title instanceof GlobalTitle ) {
			$name = "[city_id=".$title->getCityId()."]:";
			$name .= isset($options['title']) ? $options['title'] : $titleText;
			return $name;
		} else {
			return parent::getResourceName($title,$titleText,$options);
		}
	}
}