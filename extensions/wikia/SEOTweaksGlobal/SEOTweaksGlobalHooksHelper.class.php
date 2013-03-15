<?php
/**
 * @author: Jacek Jursza <jacek@wikia-inc.com>
 * @author Jacek 'mech' Woźniak <mech@wikia-inc.com>
 * Date: 28.02.13 14:45
 */

class SEOTweaksGlobalHooksHelper extends WikiaModel {

	const MAX_WIDTH = 500;

	/**
	 * Given a file, return its thumbnail url
	 * @param $file File
	 * @return string|false
	 */
	protected function getThumbFromFile( $file ) {
		$width = $file->getWidth();
		$width = $width > self::MAX_WIDTH ? self::MAX_WIDTH : $width;
		$thumbObj = $file->transform( array( 'width' => $width ), 0 );
		if ( $thumbObj ) return $thumbObj->getUrl();
		return false;
	}

	protected function makeKey( $title ) {
		return $this->wf->memcKey( 'OpenGraphTitleImage', $title->getDBKey() );
	}

	/**
	 * Return first image from an article
	 * @param $title
	 * @return null|Title
	 */
	protected function getFirstArticleImage( $title ) {
		$imageServing = new ImageServing( array( $title->getArticleID() ), self::MAX_WIDTH );
		$out = $imageServing->getImages( 1 );
		if ( !empty( $out ) ) {
			$first = reset( $out );
			$name = $first[0]['name'];
			return Title::newFromText($name, NS_FILE);
		}
		return null;
	}

	/**
	 * @param $meta
	 * @param $title Title
	 * @return bool
	 */
	public function onOpenGraphMetaHeaders( &$meta, $title ) {

		if ( !empty( $title ) && $title instanceof Title && !$title->isMainPage() ) {
			$namespace = $title->getNamespace();
			if ( $namespace == NS_USER ) {
				return true;
			}
			$cacheKey = $this->makeKey( $title );
			$imageUrl = $this->wg->memc->get( $cacheKey );

			if ( is_null( $imageUrl ) || $imageUrl === false ) {    // not in memcache
				if ( $namespace != NS_FILE ) {
					$title = $this->getFirstArticleImage( $title );
				}
				if ( !empty( $title ) ) {
					$file = F::app()->wf->findFile( $title );
					if ( !empty( $file ) ) {
						$thumb = $this->getThumbFromFile( $file );
						if ( !empty( $thumb ) ) $meta["og:image"] = $thumb;
					}
				}
				if ( isset( $meta["og:image"] ) && ( !empty( $meta["og:image"] ) ) ) {
					$imageUrl = $meta["og:image"];
				} else {
					// Even if there is no og:image, we store the info in memcahe so we don't do the
					// processing again
					$imageUrl = '';
				}
				$this->wg->memc->set( $cacheKey, $imageUrl );
			}

			if ( !empty( $imageUrl ) ) { // only when there is a thumbnail url
				$meta['og:image'] = $imageUrl;
			}
		}
		return true;
	}

}
