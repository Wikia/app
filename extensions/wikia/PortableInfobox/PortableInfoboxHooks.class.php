<?php

class PortableInfoboxHooks {
	const PARSER_TAG_GALLERY = 'gallery';
	const INFOBOX_BUILDER_MERCURY_ROUTE = 'infoboxBuilder';

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
	 * @param EditPageLayoutController $editPage
	 *
	 * @return bool
	 */
	public static function onEditPageLayoutExecute( $editPage ) {
		// run only on template
		$requestContext = $editPage->getContext();
		$title = $requestContext->getTitle();

		if ( $title->getNamespace() == NS_TEMPLATE &&
			!$title->exists() &&
			$requestContext->getRequest()->getBool( PortableInfoboxBuilderController::INFOBOX_BUILDER_PARAM )
		) {
			$host = $requestContext->getRequest()->getAllHeaders()['HOST'];
			$url = 'http://' . $host . '/' . self::INFOBOX_BUILDER_MERCURY_ROUTE . '/' . $title->getBaseText();

			$editPage->getResponse()->setVal( 'isPortableInfoboxBuilder', true );
			$editPage->getResponse()->setVal( 'portableInfoboxBuilderUrl', $url );
		}

		return true;
	}

	public static function onAddPortableInfoboxBuilderText( &$article, &$text, &$wgOut ) {
		//check if extension is on and user has rights
		$text = '';
		$templateTitle = $article->getTitle()->getText();
		$infoboxBuilderLink = "/Special:InfoboxBuilder/" . $templateTitle;
		$editorLink = "/wiki/" . $templateTitle . "?action=edit";
		$HTML = '<a href="'. $infoboxBuilderLink . '" class="wikia-button">CREATE INFOBOX TEMPLATE</a> or <a href="'. $editorLink . '" class="wikia-button">CREATE NORMAL TEMPLATE</a>';

		$wgOut->addHTML($HTML);
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
		$request = $skin->getRequest();

		if ( $title->getNamespace() == NS_TEMPLATE &&
			!$title->exists() &&
			$request->getVal( 'action' ) == 'edit' &&
			$request->getBool( PortableInfoboxBuilderController::INFOBOX_BUILDER_PARAM )
		) {
			//$text .= JSMessages::printPackages( [ 'PortableInfoboxBuilder' ] );

			$scripts = AssetsManager::getInstance()->getURL( 'portable_infobox_builder_js' );
			foreach ( $scripts as $script ) {
				$text .= Html::linkedScript( $script );
			}
		}
		return true;
	}
}
