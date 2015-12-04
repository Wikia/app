<?php

class InfoIconTemplate {
	/**
	 * @desc sanitize infoicon template content, that is remove all non-images
	 * from it's wikitext. They usually contain span with 'display: none' style
	 * or other stuff we don't want on mobile.
	 *
	 * @param string $wikitext
	 *
	 * @return string wikitext containing strip markers. Each strip marker represents parsed markup of an infoicon
	 */
	public static function handle( $wikitext, Parser $parser ) {
		global $wgContLang;

		$images = FileNamespaceSanitizeHelper::getInstance()->getCleanFileMarkersFromWikitext( $wikitext, $wgContLang );

		$output = '';

		foreach ( $images as $image ) {
			$title = Title::newFromText( $image );
			$file = wfFindFile( $title );
			$output .= Linker::makeImageLink2(
				$title,
				$file,
				[],
				[ 'template-type' => AutomaticTemplateTypes::TEMPLATE_INFOICON ]
			);
		}

		$stripMarker = $parser->insertStripItem( $output );

		return $stripMarker;
	}
}
