<?php

use Wikia\Logger\WikiaLogger;

class NodeSanitizer {
	/**
	 * @desc call proper for given type sanitizer class
	 *
	 * @param $type
	 * @param $data
	 * @return mixed
	 */
	public function sanitizeInfoboxFields( $type, $data ) {
		switch ( $type ) {
			case 'data':
				return (new NodeDataSanitizer())->sanitize($data);
			case 'horizontal-group-content':
				return (new NodeHorizontalGroupSanitizer())->sanitize($data);
			case 'title':
				return (new NodeTitleSanitizer())->sanitize($data);
			case 'image':
				return (new NodeImageSanitizer())->sanitize($data);
			case 'hero-mobile':
				return (new NodeHeroImageSanitizer())->sanitize($data);
		}

		return $data;
	}

	/**
	 * process single title or label
	 *
	 * @param $elementText
	 * @param string $allowedTags
	 * @return string
	 */
	protected function sanitizeElementData( $elementText, $allowedTags = null ) {
		$elementTextAfterTrim = trim( strip_tags( $elementText, $allowedTags ) );

		if ( $elementTextAfterTrim !== $elementText ) {
			WikiaLogger::instance()->info( 'Striping HTML tags from infobox element' );
			$elementText = $elementTextAfterTrim;
		}
		return $elementText;
	}
}
