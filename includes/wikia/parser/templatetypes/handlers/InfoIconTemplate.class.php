<?php
class InfoIconTemplate {

	/** @var string[string] Process cache map of info icon image names to rendered links */
	private static $infoIconCache = [];

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
			$output .= self::getIconLink( $image );
		}
		$stripMarker = $parser->insertStripItem( $output );
		return $stripMarker;
	}

	/**
	 * @desc for a given wikitext image mark, create imagelink
	 *
	 * @param $image
	 * @return String
	 * @throws \MWException
	 */
	private static function getIconLink($image ) {
		// SRE-117: Use process cache to avoid repeated expensive media queries
		if ( !isset( self::$infoIconCache[$image] ) ) {
			self::$infoIconCache[$image] = self::makeIconLink( $image );
		}

		return self::$infoIconCache[$image];
	}

	private static function makeIconLink( $image ): string {
		$title = Title::newFromText( $image );

		if ( $title instanceof Title ) {
			$file = wfFindFile( $title );

			if ( $file && $file->exists() ) {
				return Linker::makeImageLink2(
					$title,
					$file,
					[],
					[ 'template-type' => TemplateClassificationService::TEMPLATE_INFOICON ]
				);
			}
		}

		return '';
	}
}
