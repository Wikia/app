<?php
class InfoIconTemplate {
	/**
	 * @desc sanitize infoicon template content, that is remove all non-images
	 * from it's wikitext. Then, parse them and add to stripState with
	 * handlerParams[template-type] set to TEMPLATE_INFOICON.
	 *
	 * @param string $wikitext
	 * @param \Parser $parser
	 * @return string wikitext containing strip markers. Each strip marker represents parsed markup of an infoicon
	 * @throws \MWException
	 */
	public static function handle( $wikitext, Parser $parser ) {
		global $wgContLang;
		$images = FileNamespaceSanitizeHelper::getInstance()->getCleanFileMarkersFromWikitext( $wikitext, $wgContLang );
		
		if ( !$images ) {
			return $wikitext;
		}
		
		$output = '';
		foreach ( $images as $image ) {
			$title = Title::newFromText( $image );
			$file = wfFindFile( $title );
			$output .= Linker::makeImageLink2(
				$title,
				$file,
				[],
				[ 'template-type' => TemplateClassificationService::TEMPLATE_INFOICON ]
			);
		}
		$stripMarker = $parser->insertStripItem( $output );
		return $stripMarker;
	}
}
