<?php

class PortableInfoboxHooks {
	const PARSER_TAG_GALLERY = 'gallery';
	const INFOBOX_BUILDER_SPECIAL_PAGE = 'Special:PortableInfoboxBuilder';

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		if ( F::app()->checkSkin( 'monobook', $skin ) ) {
			Wikia::addAssetsToOutput( 'portable_infobox_monobook_scss' );
		} else {
			Wikia::addAssetsToOutput( 'portable_infobox_scss' );
		}

		return true;
	}

	public static function onImageServingCollectImages( &$imageNamesArray, $articleTitle ) {
		if ( $articleTitle ) {
			$infoboxImages = PortableInfoboxDataService::newFromTitle( $articleTitle )->getImages();
			if ( !empty( $infoboxImages ) ) {
				$imageNamesArray = array_merge( $infoboxImages, (array)$imageNamesArray );
			}
		}

		return true;
	}

	/**
	 * Store information about raw content of all galleries in article to handle images in infoboxes
	 *
	 * @param $name Parser tag name
	 * @param $marker substitution marker
	 * @param $content raw tag contents
	 * @param $attributes
	 * @param $parser
	 * @param $frame
	 *
	 * @return bool
	 */
	public static function onParserTagHooksBeforeInvoke( $name, $marker, $content, $attributes, $parser, $frame ) {
		if ( $name === self::PARSER_TAG_GALLERY ) {
			\Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag::getInstance()->setGallery( $marker, $content );
		}

		return true;
	}

	public static function onWgQueryPages( &$queryPages = [ ] ) {
		$queryPages[] = [ 'AllinfoboxesQueryPage', 'AllInfoboxes' ];

		return true;
	}

	/**
	 * @param $article
	 * @param $text
	 * @param $wgOut
	 *
	 * @return bool
	 */
	public static function onArticleNonExistentPage( Article $article, OutputPage $wgOut, $text ) {
		$title = $article->getTitle();
		if ( $title && !$title->exists() && $title->inNamespace( NS_TEMPLATE ) && $title->userCan( 'edit' ) ) {
			$HTML = F::app()->renderView(
				'PortableInfoboxBuilderSpecialController',
				'renderCreateTemplateEntryPoint',
				[ 'title' => $title->getText() ]
			);
			$wgOut->clearHTML();
			$wgOut->addHTML( $HTML );
			// we don't want to add anything else, it also stops parser
			// (see Article.php:wfRunHook(ArticleNonExistentPage))
			return false;
		}

		return true;
	}

	/**
	 * @param Skin $skin
	 * @param string $text
	 *
	 * @return bool
	 */
	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		$title = $skin->getTitle();

		if ( $title && $title->isSpecial( PortableInfoboxBuilderSpecialController::PAGE_NAME ) ) {
			$scripts = AssetsManager::getInstance()->getURL( 'portable_infobox_builder_js' );

			foreach ( $scripts as $script ) {
				$text .= Html::linkedScript( $script );
			}
		}

		return true;
	}
}
