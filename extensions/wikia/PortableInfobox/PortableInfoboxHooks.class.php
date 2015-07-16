<?php

class PortableInfoboxHooks {
	const PARSER_TAG_GALLERY = 'gallery';

	static public function onBeforePageDisplay(OutputPage $out, Skin $skin) {
		if (F::app()->checkSkin('monobook', $skin)) {
			Wikia::addAssetsToOutput('portable_infobox_monobook_scss');
		} else {
			Wikia::addAssetsToOutput('portable_infobox_scss');
		}

		return true;
	}

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

	static public function onEditPageLayoutExecute( $editPageContext ) {
		$data = $editPageContext->response->getData();

		$data[ 'isPortableInfoboxBuilder' ] = true;
		$data[ 'PortableInfoboxBuilderHTML' ] = F::app()->renderView( 'PortableInfoboxBuilder', 'index' );

		$editPageContext->response->setData( $data );

		return true;
	}

	static public function onAddPortableInfoboxBuilderText( &$article, &$text ) {
		//TODO: run it only on a template page
		$infoboxText = '<center><span class="wikia-button big plainlinks">or<br />[{{fullurl:{{FULLPAGENAMEE}}|action=edit&portableInfoboxBuilder=true}} <span>Create new infobox!</span>]<br /></span></center>
<br />';
		$text = $text.$infoboxText;

		return true;
	}

	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		//var_dump($skin);
		//if ( WikiaPageType::isMainPage() ) {
		//TODO: run it only on a template page
		if (true) {
			$scripts = AssetsManager::getInstance()->getURL( 'portable_infobox_js' );

			foreach ( $scripts as $script ) {
				$text .= Html::linkedScript( $script );
			}
		}

		//add js from PortableInfoboxBuilder handling only for template pages
		//if ($out->getTitle()->mNamespace == '10')
		return true;
	}
}
