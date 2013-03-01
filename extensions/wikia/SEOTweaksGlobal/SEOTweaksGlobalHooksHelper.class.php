<?php
/**
 * @author: Jacek Jursza <jacek@wikia-inc.com>
 * Date: 28.02.13 14:45
 *
 */
class SEOTweaksGlobalHooksHelper extends WikiaModel {

	/**
	 * @param $meta
	 * @param $title Title
	 * @return bool
	 */
	public function onOpenGraphMetaHeaders( &$meta, $title ) {

		if ( !empty( $title ) && $title instanceof Title && !$title->isMainPage() ) {

			$cacheKey = $this->wf->memcKey( __METHOD__, $title->getDBKey() );
			$imageUrl = $this->wg->memc->get( $cacheKey );

			if ( !empty( $imageUrl ) ) {
				$meta['og:image'] = $imageUrl;
				return true;
			}

			if ( !empty( $title ) ) {

				$namespace = $title->getNamespace();
				$maxWidth = 500;

				if ( $namespace == NS_FILE ) {

					$file = wfFindFile( $title );

					if ( !empty( $file ) ) {
						$thumb = $file->getUrl();
						$meta['og:image'] = $thumb;
						$width = $file->getWidth();
						$width = $width > $maxWidth ? $maxWidth : $width;
						$thumbObj = $file->transform( array('width'=>$width ), 0 );
						$thumb = $thumbObj->getUrl();
						$this->wg->memc->set( $cacheKey, $thumb );
					}

				} else {

					$imageServing = new ImageServing( array( $title->getArticleID() ), $maxWidth );
					$out = $imageServing->getImages( 1 );
					if ( !empty( $out ) ) {

						$first = reset( $out );
						$name = $first[0]['name'];
						$fileTitle = Title::newFromText($name, NS_FILE);
						$file = wfFindFile( $fileTitle );
						$width = $file->getWidth();
						$width = $width > $maxWidth ? $maxWidth : $width;
						$thumbObj = $file->transform( array('width'=>$width ), 0 );
						$thumb = $thumbObj->getUrl();

						$meta["og:image"] = $thumb;
						$this->wg->memc->set( $cacheKey, $thumb );

					} else {

						$this->wg->memc->set( $cacheKey, $meta["og:image"] );
					}
				}
			}
		}
		return true;
	}
}
