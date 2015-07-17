<?php

class PortableInfoboxHooks {
	const PARSER_TAG_GALLERY = 'gallery';

	/**
	 * adds portable infobox styles
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return bool
	 */
	static public function onBeforePageDisplay(OutputPage $out, Skin $skin) {
		if (F::app()->checkSkin('monobook', $skin)) {
			Wikia::addAssetsToOutput('portable_infobox_monobook_scss');
		} else {
			Wikia::addAssetsToOutput('portable_infobox_scss');
		}

		return true;
	}

	/**
	 * adds infobox images to image serving
	 *
	 * @param $imageNamesArray
	 * @param $articleTitle
	 * @return bool
	 */
	static public function onImageServingCollectImages(&$imageNamesArray, $articleTitle) {
		if ($articleTitle) {
			$infoboxImages = PortableInfoboxDataService::newFromTitle($articleTitle)->getImages();
			if (!empty($infoboxImages)) {
				$imageNamesArray = array_merge($infoboxImages, (array)$imageNamesArray);
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
	 */
	static public function onParserTagHooksBeforeInvoke($name, $marker, $content, $attributes, $parser, $frame) {
		if ($name === self::PARSER_TAG_GALLERY) {
			\Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag::getInstance()->setGallery($marker, $content);
		}

		return true;
	}

	/**
	 * renders portable infobox builder instead of edit page while creating new template
	 *
	 * @param EditPageLayoutController $editPageContext
	 * @return bool
	 */
	static public function onEditPageLayoutExecute( $editPageContext ) {
		global $wgRequest;

		if ( self::isEditingNewTemplate() && $wgRequest->getVal( 'portableInfoboxBuilder', false ) ) {
			$data = $editPageContext->response->getData();

			$data[ 'isPortableInfoboxBuilder' ] = true;
			$data[ 'PortableInfoboxBuilderHTML' ] = F::app()->renderView( 'PortableInfoboxBuilder', 'index' );

			$editPageContext->response->setData( $data );
		}

		return true;
	}

	/**
	 * adds portable infobox builder call to actiom modal js assets to edit page
	 *
	 * @param $skin
	 * @param $text
	 * @return bool
	 * @throws WikiaException
	 */
	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		global $wgRequest;

		if ( self::isEditingNewTemplate() && !$wgRequest->getVal( 'portableInfoboxBuilder', false ) ) {
			$text .= JSMessages::printPackages( ['PortableInfoboxBuilder'] );

			$scripts = AssetsManager::getInstance()->getURL( 'portable_infobox_builder_js' );
			foreach ( $scripts as $script ) {
				$text .= Html::linkedScript( $script );
			}
		}

		return true;
	}

	/**
	 * checks edit page is opened for a new blank template
	 *
	 * @return bool
	 */
	private static function isEditingNewTemplate() {
		global $wgTitle, $wgRequest;

		return $wgTitle->getNamespace() === NS_TEMPLATE &&
		!$wgTitle->exists() &&
		$wgRequest->getVal( 'action' ) === 'edit';
	}
}
