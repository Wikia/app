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

	protected function createTitle( $titleText, $options = array() ) {
		global $wgCityId;

		$title = null;
		if ( !empty( $options['city_id'] ) && $wgCityId != $options['city_id'] ) {
			$realTitleText = isset($options['title']) ? $options['title'] : $titleText;
			list( $text, $namespace ) = $this->parseTitle($realTitleText);
			if ( $text !== false ) {
				$title = GlobalTitle::newFromText($text,$namespace,$options['city_id']);
			}
		} else {
			$title = Title::newFromText( $titleText );
		}

		return $title;
	}

	protected function getContent( $title, $titleText, $options = array() ) {
		if ( $title instanceof GlobalTitle ) {
			// todo: think of pages like NS_MAIN:Test/code.js that are pulled
			// from dev.wikia.com
			/*
			if ( !$title->isCssJsSubpage() && !$title->isCssOrJsPage() ) {
				return null;
			}
			*/
			$content = $title->getContent();
		} else {
			$content = parent::getContent($title,$options);
		}

        if ( ($content === false || $content === null)
                && isset($options['missingCallback']) ) {
            $missingCallback = $options['missingCallback'];
            $missingArticle = $this->getResourceName($title,$titleText,$options);
            $missingArticle = json_encode((string)$missingArticle);
            $content = "window.{$missingCallback} && {$missingCallback}({$missingArticle});";
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
